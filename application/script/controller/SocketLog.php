<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/7
 * Time: 下午10:49
 */

namespace app\script\controller;

use app\common\tools\RedisClient;
use think\Config;


class SocketLog
{
    /**
     * SocketLog constructor
     */
    public function __construct()
    {

    }

    /**
     * 从redis里读取log
     */
    public function readLog()
    {
       return (new RedisClient())->lPop(Config::get('log.queue'));
    }

}