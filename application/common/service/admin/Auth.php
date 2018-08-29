<?php
/* =============================================================================
 * Author: qinyongbo - 408964446@qq.com
 * QQ : 408964446
 * Last modified: 2017-05-11 17:21
 * Filename: RedisService.class.php
 * Description: 
 * @copyright    Copyright (c) 2016, rocketbird.cn
=============================================================================*/
namespace app\common\service\admin;

use app\common\tools\RedisClient;


class RedisService
{
    //设置权限节点
    public static function set_auth($admin_id,$nodes)
    {
        try{
            $key = "nodes_" . $admin_id;
            $redisClient = new RedisClient();
            $encode_nodes = json_encode($nodes);
            $ret = $redisClient->set($key, $encode_nodes, 14400);
            return $ret;
        } catch (\Exception $e) {
            return $ret = false;
        }

    }

    //获取权限节点
    public static function get_auth($admin_id)
    {
        try{
            $key = "nodes_" . $admin_id;
            $redisClient = new RedisClient();
            $res = $redisClient->get($key);
            if ($res) {
                $ret = json_decode($res,true);
            }
            return $ret;
        } catch (\Exception $e) {
            return $ret = false;
        }

    }

    //清空权限节点
    public static function clear_auth($admin_id)
    {
        $ret = false;
        try {
            $key = "nodes_" . $admin_id;
            $redisClient = new RedisClient();
            $ret = $redisClient->delKey($key);
        } catch (\Exception $e) {
        }
        return $ret;
    }
}
