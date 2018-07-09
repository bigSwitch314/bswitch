<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/8
 * Time: 下午5:38
 */

namespace app\script\controller;

use app\script\server\WebSocket;


class swoole
{
    public function __construct()
    {
        if (!IS_CLI) {
            exit($this->request->action().'(): it must be used in PHP CLI mode.');
        }

    }

    public function webSocket()
    {
        // 启动服务器
        $server = new WebSocket();
        $server->serv->start();
    }

}