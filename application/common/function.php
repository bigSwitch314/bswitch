<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/20
 * Time: 上午11:40
 */

use think\Env;
use think\Config;

/**
 * 获取环境变量
 * @param string $key
 * @return mixed|string
 */
function get_env($key='ENV') {
    $value = Env::get($key);
    if ('ENV' === $key)
        return in_array($value, ['dev', 'beta', 'sim', 'online']) ? $value : 'dev';
    return $value;
}

/**
 * 记录日志
 * @return bool
 */
function logw() {
    return true;
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
