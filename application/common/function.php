<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/20
 * Time: 上午11:40
 */

use think\Env;
use think\Config;
use app\common\tools\RedisClient;

/**
 * 获取环境变量
 * @param string $key
 * @return mixed|string
 */
function get_env($key='env') {
    $value = Env::get($key);
    if ('env' === $key)
        return in_array($value, ['dev', 'beta', 'sim', 'online']) ? $value : 'dev';
    return $value;
}

/**
 * 获取客户端IP
 * @return bool
 */
function get_real_ip()
{
    static $ip = false;
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $ip = $_SERVER["HTTP_CLIENT_IP"];
    }
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
        if ($ip) {
            array_unshift($ips, $ip);
            $ip = FALSE;
        }
        for ($i = 0; $i < count($ips); $i++) {
            if (method_exists('eregi') && !eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
                $ip = $ips[$i];
                break;
            }
        }
    }
    $ip = $ip ? $ip : $_SERVER['REMOTE_ADDR'];
    return $ip;
}

/**
 * 记录日志
 * @param $msg
 * @param string $file_name
 * @param bool $socket_log
 * @return bool
 */
function logw($msg, $file_name ='info', $socket_log=false) {
    $log_file = sprintf("/mnt/%s/log/%s/bs-%s.%s.log", get_env('env'), date('Ym'), $file_name, date('Y-m-d'));
    // 判断日志大小
    $log_size = Config::get('log_size') ?: 100 * 1024 * 1024;
    if (file_exists($log_file) && filesize($log_file) > $log_size) {
        $str = date('Y-m-d', strtotime('today')) . '-' . time();
        $new_name = sprintf("/mnt/%s/log/%s/bs-%s.%s.log", get_env('env'), date('Ym'), $file_name, $str);
        rename($log_file, $new_name);
    }
    // 创建目录
    $dir = dirname($log_file);
    if (!is_dir($dir) && false === mark_directory($dir)) {
        exit('日志目录创建失败！');
    }
    $host_name = phpversion() < "5.3.0" ? $_SERVER['HOSTNAME'] : gethostname();
    $ip = get_real_ip();
    // 写日志
    $content = sprintf("%s\t[ip]: %s\t%s\t[hostname]: %s\n\n", date("H:i:s"), $ip, $msg, $host_name);
    $fp = fopen($log_file, 'a');
    fwrite($fp, $content);
    fclose($fp);
    // Socket远程调试
    if ($socket_log) { // 将日志存入redis，然后swoole读取并发送到客户端
        $queue = Config::get('log.queue');
        $job   = json_encode_unescape([
            'route' => 'script/SocketLog/readLog',
            'param' => ['log' => $content]
        ]);
        (new RedisClient())->rPush($queue, $job);
    }

    return true;
}

/**
 * 创建目录
 * @param $dir
 * @return bool
 */
function mark_directory($dir) {
    return !is_dir($dir) && mkdir($dir, 0755, true);
}

/**
 * 可逆字符串动态加密
 * @param string $txt
 * @return string
 */
function auth_encode($txt) {
    if (!$txt)
        return false;

    $key = Config::get('encode_key');
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rmFuck";
    $nh1 = 1;
    $nh2 = 1;
    $nh3 = 1;
    //$nh1 = rand(0, 32);
    //$nh2 = rand(0, 32);
    //$nh3 = rand(0, 32);
    $ch1 = $chars{$nh1};
    $ch2 = $chars{$nh2};
    $ch3 = $chars{$nh3};
    $nhnum = $nh1 + $nh2 + $nh3;
    $knum = 0;
    $i = 0;
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $txt = base64_encode($txt);
    $txt = str_replace(['+', '/', '='], ['-', '_', '.'], $txt);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = ($nhnum + strpos($chars, $txt{$i}) + ord($mdKey{$k++})) % 64;
        $tmp .= $chars{$j};
    }
    $tmplen = strlen($tmp);
    $tmp = substr_replace($tmp, $ch3, $nh2 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch2, $nh1 % ++$tmplen, 0);
    $tmp = substr_replace($tmp, $ch1, $knum % ++$tmplen, 0);
    return $tmp;
}

/**
 * 可逆字符串解密
 * @param string $txt
 * @return string
 */
function auth_decode($txt) {
    if (!$txt)
        return false;

    $key = Config::get('encode_key');
    $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-_.";
    $ikey = "x6g6ZWm2G9g_vr0Bo.pOq3kRIxsZ6rmFuck";
    $knum = 0;
    $i = 0;
    $tlen = strlen($txt);
    while (isset($key{$i}))
        $knum += ord($key{$i++});
    $ch1 = $txt{$knum % $tlen};
    $nh1 = strpos($chars, $ch1);
    $txt = substr_replace($txt, '', $knum % $tlen--, 1);
    $ch2 = $txt{$nh1 % $tlen};
    $nh2 = strpos($chars, $ch2);
    $txt = substr_replace($txt, '', $nh1 % $tlen--, 1);
    $ch3 = $txt{$nh2 % $tlen};
    $nh3 = strpos($chars, $ch3);
    $txt = substr_replace($txt, '', $nh2 % $tlen--, 1);
    $nhnum = $nh1 + $nh2 + $nh3;
    $mdKey = substr(md5(md5(md5($key . $ch1) . $ch2 . $ikey) . $ch3), $nhnum % 8, $knum % 8 + 16);
    $tmp = '';
    $j = 0;
    $k = 0;
    $tlen = strlen($txt);
    $klen = strlen($mdKey);
    for ($i = 0; $i < $tlen; $i++) {
        $k = $k == $klen ? 0 : $k;
        $j = strpos($chars, $txt{$i}) - $nhnum - ord($mdKey{$k++});
        while ($j < 0)
            $j += 64;
        $tmp .= $chars{$j};
    }
    $tmp = str_replace(['-', '_', '.'], ['+', '/', '='], $tmp);
    return trim(base64_decode($tmp));
}

/**
 * json编码
 * @param $json
 * @return mixed
 */
function json_encode_unescape($json) {
    return json_encode($json, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
}

/**
 * 解析转义后json
 * @param $json
 * @return mixed
 */
function json_decode_escape($json) {
    $json = str_replace('&quot;', '"', $json);
    return json_decode($json, true);
}

/**
 * 获取微妙时间
 * @param string $time
 * @return string
 */
function  get_microtime($time = '')
{
    $time = $time ?: microtime();
    $arr  = explode(" ", $time);
    return sprintf("%d%06d", $arr[1], $arr[0] * 1000000);
}

/**
 * 其他单位转换为字节
 * @param $other
 * @return int
 */
function other2byte ($other) {
    $uint = strtoupper(substr(trim($other), -1));
    switch ($uint) {
        case 'K':
            $byte = intval($other) * pow(1024, 1);
            break;
        case 'M':
            $byte = intval($other) * pow(1024, 2);
            break;
        case 'G':
            $byte = intval($other) * pow(1024, 3);
            break;
        default:
            $byte = $other;
    }
    return $byte;
}

/**
 * sql执行追踪
 * @return string
 */
function sql_trace() {
    $trace = debug_backtrace();
    foreach ($trace as $value) {
        if(false !== strpos($value['class'], 'controller')) {
            $controller = 'class=' . $value['class'] . '  function=' . $value['function'];
        }
        if(false !== strpos($value['class'], 'service')) {
            $service= 'class=' . $value['class'] . '  function=' . $value['function'];
        }
        if(false !== strpos($value['class'], 'model')) {
            $model = 'class=' . $value['class'] . '  function=' . $value['function'];
        }
    }

    $sql_trace = '';
    if (isset($controller) && $controller) $sql_trace .= $controller;
    if (isset($service)    && $service)    $sql_trace .= '    ' . $service;
    if (isset($model)      && $model)      $sql_trace .= '    ' . $model;
    return $sql_trace;
}

/**
 * 二维数组分组
 * @param $arr
 * @param array $key
 * @return array
 */
function array_group($arr, $key) {
    $grouped = [];
    foreach ($arr as $value) {
        $grouped[$value[$key]][] = $value;
    }
    // Recursively build a nested grouping if more parameters are supplied
    // Each grouped array value is grouped according to the next sequential key
    if (func_num_args() > 2) {
        $args = func_get_args();
        foreach ($grouped as $key => $value) {
            $parms = array_merge([$value], array_slice($args, 2, func_num_args()));
            $grouped[$key] = call_user_func_array('array_group', $parms);
        }
    }
    return $grouped;
}

/**
 * 返回数组中指定多列
 * @param $input
 * @param null $column_keys
 * @param null $index_key
 * @return array
 */
function array_columns($input, $column_keys=null, $index_key=null) {
    $result = [];
    $keys = isset($column_keys)? explode(',', $column_keys) : [];
    $keys = array_map('trim', $keys);

    if ($input) {
        foreach ($input as $k=>$v) {
            // 指定返回列
            if ($keys) {
                $tmp = array();
                foreach ($keys as $key) {
                    $tmp[$key] = $v[$key];
                }
            } else {
                $tmp = $v;
            }
            // 指定索引列
            if (isset($index_key)) {
                $result[$v[$index_key]] = $tmp;
            } else {
                $result[] = $tmp;
            }
        }
    }
    return $result;
}

/**
 * 判断两个时间段是否有交集（边界重叠不算）
 * @param $begin_time1
 * @param $end_time1
 * @param $begin_time2
 * @param $end_time2
 * @return bool
 */
function time_cross($begin_time1, $end_time1, $begin_time2, $end_time2) {
    $status = $begin_time2 - $begin_time1;
    if ($status > 0) {
        $status2 = $begin_time2 - $end_time1;
        if ($status2 >= 0) {
            return false;
        } else {
            return true;
        }
    } else {
        $status2 = $end_time2 - $begin_time1;
        if ($status2 > 0) {
            return true;
        } else {
            return false;
        }
    }
}

/**
 * 默认获取当前时间戳为周几
 * @param int $time
 * @param int $offset
 * @return mixed
 */
function get_week($time, $offset=0) {
    $week = ['周日', '周一', '周二', '周三', '周四', '周五', '周六'];
    $index = date('w', $time + 86400 * $offset);
    return $week[$index];
}

/**
 * 计算两个时间戳相差的天数
 * @param $timestamp1
 * @param $timestamp2
 * @return float
 */
function count_days($timestamp1, $timestamp2) {
    $date1 = getdate($timestamp1);
    $date2 = getdate($timestamp2);
    $time1 = mktime(12, 0, 0, $date1['mon'], $date1['mday'], $date1['year']);
    $time2 = mktime(12, 0, 0, $date2['mon'], $date2['mday'], $date2['year']);
    return round(abs($time1 - $time2) / 86400);
}

/**
 * 将xml转为array
 * @param $xml
 * @return mixed
 */
function xml2array($xml) {
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
}

/**
 * 将array转为xml
 * @param $arr
 * @return string
 */
function array2xml($arr) {
    $xml = "<xml>";
    foreach ($arr as $key => $val) {
        if('key' == $key) {
            continue;
        }
        if (is_numeric($val)) {
            $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
        }else{
            $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
        }
    }
    $xml .= "</xml>";
    return $xml;
}

/**
 * 生成一个唯一ID(如用作订单号)
 * @return string
 */
function create_uniqid() {
    $temp = array_map('ord', str_split(substr(uniqid(), 7, 13), 1));
    return date('Ymd') . substr(implode(NULL, $temp), 0, 8);
}

/**
 * 计算两个经纬度之间的距离,单位米
 * @param $lng1
 * @param $lat1
 * @param $lng2
 * @param $lat2
 * @return string
 */
function get_distance($lng1, $lat1, $lng2, $lat2) {
    $radLat1 = deg2rad( $lat1 );
    $radLat2 = deg2rad( $lat2 );
    $radLng1 = deg2rad( $lng1 );
    $radLng2 = deg2rad( $lng2 );
    $a = $radLat1 - $radLat2;
    $b = $radLng1 - $radLng2;
    $s = 2 * asin(sqrt(pow(sin($a / 2), 2) + cos($radLat1) * cos($radLat2) * pow(sin($b / 2), 2))) * 6378.137 * 1000;

    return number_format($s, 1, '.', '');
}

/**
 * curl发送http_post请求
 * @param $url
 * @param $param
 * @return bool|mixed
 */
function http_post($url, $param) {
    $curl = curl_init();
    if (FALSE !== stripos($url,"https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    if (is_string($param)) {
        $str_post = $param;
        if('@' == substr($param,0,1)) {
            $str_post = ['file'=>$param];
        }
    } else {
        $arr_post = [];
        foreach ($param as $key=>$val) {
            $arr_post[] = $key . "=" . urlencode($val);
        }
        $str_post = join("&", $arr_post);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $str_post);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl);

    curl_close($curl);
    if (200 == intval($status["http_code"])) {
        return $result;
    } else {
        return false;
    }
}

/**
 * curl发送http_get请求
 * @param $url
 * @return bool|mixed
 */
function http_get($url) {
    $curl = curl_init();
    if (FALSE !== stripos($url,"https://")) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    }
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl);

    curl_close($curl);
    if (200 == intval($status["http_code"])) {
        return $result;
    } else {
        return false;
    }
}

/**
 * 导出excel表
 * @param array $data
 * @param array $title
 * @param string $filename
 */
function import_excel($data=[], $title=[], $filename='file') {
    header('Content-type:application/octet-stream');
    header('Accept-Ranges:bytes');
    header('Content-type:application/vnd.ms-<excel></excel>');
    header('Content-Disposition:attachment;filename=' . $filename . '.xls');
    header('Pragma: no-cache');
    header('Expires: 0');

    if (!empty($title)) {
        foreach ($title as $k => $v) {
            $title[$k] = iconv('UTF-8', 'GBK', $v);
        }
        $title = implode("\t", $title);
        echo "$title\n";
    }
    if (!empty($data)) {
        foreach ($data as $key=>$val) {
            foreach ($val as $ck => $cv) {
                $data[$key][$ck] = iconv('UTF-8', 'GBK', "\"$cv\"");
            }
            $data[$key] = implode("\t", $data[$key]);
        }
        echo implode("\n", $data);
    }
}

/**
 * 无限极分类，递归查询某分类的子分类
 * @param $category
 * @param int $id
 * @return array
 */
function get_subs($category, $id=0) {
    $subs = [];
    foreach ($category as $key => $item) {
        if ($item['pid'] == $id) {
            $subs[] = $item;
            unset($category[$key]);
            $subs = array_merge($subs, get_subs($category, $item['id']));
        }
    }
    return $subs;
}

/**
 * 无限极分类，生成树（引用）
 *
 * @param $list
 * @param int $root
 * @return mixed
 */
function generate_tree($list, $root=0) {
    $tree = [];
    $list = array_column($list, null, 'id');
    foreach ($list as $key => $value) {
        if (!$list[$key]['children']) {
            $list[$key]['children'] = [];
        }

        if ($root == $value['pid']) {
            $tree[] = &$list[$key];
        } else {
            $list[$value['pid']]['children'][] = &$list[$key];
        }
    }
    return $tree;
}

/**
 * 无限极分类，递归生成树
 * @param $list
 * @param int $pid
 * @return array
 */
function generate_tree2($list, $pid = 0) {
    $tree = [];
    foreach ($list as $val) {
        if ($val['pid'] == $pid) {
            $tree[] = [
                'id'   => $val['id'],
                'name' => $val['name'],
                'pid'  => $val['pid'],
                'children'  => generate_tree2($list, $val['id'])
            ];
        }
    }
    return $tree;
}

/**
 * 二维数组根据某字段去重
 * @param $arr
 * @param null $key
 * @return mixed
 */
function two_dim_array_unique($arr, $key=null) {
    $temp_arr = [];
    foreach($arr as $k => $val) {
        if (!in_array($val[$key], $temp_arr)) {
            unset($arr[$k]);
        } else {
            $temp_arr[] = $val[$key];
        }
    }
    return $arr;
}

/**
 * 获取请求参数
 * @return string
 */
function get_params()
{
    $params = '';
    $inputs = $_REQUEST;
    ksort($inputs, SORT_STRING);
    foreach ($inputs as $key=>$value) {
        if ('op' == $key || 's' == $key) continue;

        if (empty($params)) {
            if (is_array($value)) {
                $params_value = implode(',', $value);
            } else {
                $params_value = $value;
            }
            $params = "{$key}={$params_value}";
        } else {
            if (is_array($value)) {
                $params_value = implode(',', $value);
            }else{
                $params_value = $value;
            }
            $params = "{$params}\t{$key}={$params_value}";
        }
    }
    return $params;
}

/**
 * 格式化时间,显示刚刚、几分钟前、昨天、前天...
 * @param $time
 * @return string
 */
function get_time_ago($time){
    $t=time()-$time;
    $f=array(
        '31536000'=>'年',
        '2592000'=>'个月',
        '86400'=>'天',
        '3600'=>'小时',
        '60'=>'分钟',
        '1'=>'秒'
    );
    foreach ($f as $k=>$v)    {
        if (0 !=$c=floor($t/(int)$k)) {
            return $v === '秒' ? '刚刚' : $c.$v.'前';
        }
    }
}

