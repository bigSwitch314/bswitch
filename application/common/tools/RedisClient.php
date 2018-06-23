<?php
namespace app\common\tools;

use think\Config;

class RedisClient
{
    public static $instance    = NULL;
    public static $link_handle = [];
    private $conf;

    /**
     * RedisClient constructor.
     * @param array $config
     */
    public function __construct($config = [])
    {
        if (empty($config)) {
            $config = Config::get('redis_conf');
        }
        $this->conf = $config;
    }

    /**
     * 实例化类，单例模式
     * @param $configs
     * @return RedisClient|bool|null
     */
    static function getInstance($configs)
    {
        if (!extension_loaded('redis')) {
            return false;
        }
        if (!self::$instance) {
            self::$instance = new self($configs);
        }
        return self::$instance;
    }

    /**
     * 获得redis resources
     * @param null $key
     * @param string $tag
     * @return \Redis
     */
    public function getRedis($key=null, $tag='master')
    {
        if (!self::$link_handle[$tag]) {
            return self::$link_handle[$tag];
        }

        empty($key) ? $key = uniqid() : true;
        $redis_arr  = $this->conf[$tag];
        $arr_index  = $this->getHostByHash($key, count($this->conf[$tag]));
        $redis = new \Redis;
        $redis->pconnect($redis_arr[$arr_index]['host'], $redis_arr[$arr_index]['port']);

        if ($redis_arr[$arr_index]['auth']) {
            $redis->auth($redis_arr[$arr_index]['auth']);
        }
        self::$link_handle[$tag] = $redis;
        return $redis;
    }

    /**
     * 随机取出主机
     * @param $key
     * @param $n
     * @return int
     */
    private function getHostByHash($key, $n)
    {
        if ($n<2) return 0;
        $id = sprintf("%u", crc32($key));
        $m  = base_convert(intval(fmod($id, $n)), 10, $n);
        return $m{0};
    }

    /**
     * 关闭连接
     * pconnect 连接是无法关闭的
     * @param int $flag 关闭选择 0:关闭Master 1:关闭Slave 2:关闭所有
     * @return boolean
     */
    public function close($flag=2)
    {
        switch ($flag) {
            case 0:  // 关闭master
                foreach (self::$link_handle['master'] as $var) {
                    $var->close();
                }
                break;
            case 1: // 关闭slave
                foreach (self::$link_handle['slave'] as $var) {
                    $var->close();
                }
                break;
            case 2: // 关闭所有
                $this->close(0);
                $this->close(1);
                break;
            default:
                ;
        }
        return true;
    }

    /**
     * 返回key指定的哈希集中所有的字段和值
     * @param $key
     * @return array
     */
    public function hGetAll($key)
    {
        return $this->getRedis($key, 'slave')->hGetAll($key);
    }

    /**
     * 将字符串值value关联到key
     * @param $key
     * @param $value
     * @param int $exp
     */
    public function set($key, $value, $exp=0)
    {
        $redis = $this->getRedis($key);
        $redis->set($key, $value);
        !empty($exp) && $redis->expire($key, $exp);
    }

    /**
     * 将值 value关联到key ，并将key的生存时间设为seconds(以秒为单位)
     * @param  $key
     * @param  $value
     * @param  $exp
     */
    public function setex($key, $value, $exp=0)
    {
        $redis = $this->getRedis($key);
        $redis->setex($key, $value, $exp);
    }

    /**
     * 设置一个key的过期时间
     * @param  $key     
     * @param  $exp
    */
    public function setExpire($key, $exp)
    {
        $redis = $this->getRedis($key);
        $redis->expire($key, $exp);
    }

    /**
     * 获取键值
     * @param $key
     * @return bool|string
     */
    public function get($key)
    {
        return $this->getRedis($key, 'slave')->get($key);
    }

    /**
     * 查找所有匹配给定的模式的键
     * @param $key
     * @param bool $is_key
     * @return array
     */
    public function keys($key, $is_key=true)
    {
        if ($is_key) {
            return $this->getRedis($key, 'slave')->keys("*$key*");
        }
        return $this->getRedis($key, 'slave')->keys("$key");
    }

    /**
     * 重命名key
     * @param $oldkey
     * @param $newkey
     * @return bool
     */
    public function renameKey($oldkey, $newkey)
    {
        return $this->getRedis($oldkey)->rename($oldkey, $newkey);
    }

    /**
     * 删除一个或多个key
     * @param $keys
     */
    public function delKey($keys)
    {
        if (is_array($keys)) {
            foreach ($keys as $key) {
                $this->getRedis($key)->del($key);
            }
        } else {
            $this->getRedis($keys)->del($keys);
        }
    }

    /**
     * 批量的添加多个key 到redis
     * @param $field_arr
     */
    public function mSetnx($field_arr)
    {
        $this->getRedis()->mSetnx($field_arr);
    }

    /**
     * 返回LIST顶部（右侧）的VALUE，并且从LIST中把该VALUE弹出
     * @param $key
     * @param $val
     * @return int
     */
    public function lPush($key, $val)
    {
        return $this->getRedis($key)->lPush($key, $val);
    }

    /**
     * 返回LIST顶部（左侧）的VALUE，并且从LIST中把该VALUE弹出
     * @param $key
     * @return string
     */
    public function lPop($key)
    {
        return $this->getRedis($key)->lPop($key);
    }

    /**
     * 获取队列的总数
     * @param $key
     * @return int
     */
    public function lLen($key)
    {
        return $this->getRedis($key)->lLen($key);
    }

    /**
     * 返回列表key中，下标为index的元素
     * @param $key
     * @param $index
     * @return String
     */
    public function lIndex($key, $index)
    {
        return $this->getRedis()->lIndex($key, $index);
    }

    /**
     * 批量填充HASH表
     * @param $key
     * @param $field_arr
     * @return bool
     */
    public function hMSet($key, $field_arr)
    {
        return $this->getRedis($key)->hmset($key, $field_arr);
    }

    /**
     * 设置 key 指定的哈希集中指定字段的值
     * @param $key
     * @param $field_name
     * @param $field_value
     * @return int
     */
    public function hSet($key, $field_name, $field_value)
    {
        return $this->getRedis($key)->hset($key, $field_name, $field_value);
    }

    /**
     * 向已存在于redis里的Hash 添加多个新的字段及值
     * @param $key
     * @param $field_arr
     */
    public function hAddFieldArr($key, $field_arr)
    {
        foreach ($field_arr as $k => $v) {
            $this->hAddFieldOne($key, $k, $v);
        }
    }

    /**
     * 向已存在于redis里的Hash 添加一个新的字段及值
     * @param  $key
     * @param  $field_name
     * @param  $field_value
     * @return bool
     */
    public function hAddFieldOne($key, $field_name, $field_value)
    {
        return $this->getRedis($key)->hsetnx($key, $field_name, $field_value);
    }

    /**
     * 向Hash里添加多个新的字段或修改一个已存在字段的值
     * @param $key
     * @param $field_arr
     */
    public function hAddOrUpValueArr($key, $field_arr)
    {
        foreach ($field_arr as $k => $v) {
            $this->hAddOrUpValueOne($key, $k, $v);
        }
    }

    /**
     * 向Hash里添加多个新的字段或修改一个已存在字段的值
     * @param $key
     * @param $field_name
     * @param $field_value
     * @return int
     */
    public function hAddOrUpValueOne($key, $field_name, $field_value)
    {
        return $this->getRedis($key)->hset($key, $field_name, $field_value);
    }

    /**
     * 删除哈希表key中的多个指定域，不存在的域将被忽略。
     * @param $key
     * @param $field_arr
     */
    public function hDel($key, $field_arr)
    {
        foreach ($field_arr as $var) {
            $this->hDelOne($key, $var);
        }
    }

    /**
     * 删除哈希表key中的一个指定域，不存在的域将被忽略
     * @param $key
     * @param $field
     * @return int
     */
    public function hDelOne($key, $field)
    {
        return $this->getRedis($key)->hdel($key, $field);
    }
}
