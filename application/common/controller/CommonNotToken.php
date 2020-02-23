<?php

/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/23
 * Time: 上午11:39
 */
namespace app\common\controller;

use think\Controller;
use think\Response;

class CommonNotToken extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        // 跨域设置
		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, token, cache-control, pragma");
        header("Access-Control-Max-Age: 600");
        // 跨域返回
        $method = $this->request->method();
        if (strtoupper($method) == 'OPTIONS') {
            return Response::create()->send();
        }
    }

}
