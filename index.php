<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// [ 应用入口文件 ]

// 记录执行到入口文件时间
$GLOBALS['index_start_time'] = microtime();
// 设置报错类型
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// 定义应用目录
define('APP_PATH', __DIR__ . '/application/');
// 定义配置文件目录
define('CONF_PATH', __DIR__.'/config/');
// 定义公共文件目录
define('COMM_PATH', __DIR__ . '/application/common/');
// 加载框架引导文件
//debug('1111');
require __DIR__ . '/thinkphp/start.php';
