<?php

/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/23
 * Time: 上午11:39
 */
namespace app\common\controller;

use think\Controller;

class Common extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        // 防止跨域
		//header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        //header('Access-Control-Allow-Credentials: true');
        //header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        //header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId");
    }
}