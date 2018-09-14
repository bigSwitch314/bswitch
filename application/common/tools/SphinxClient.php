<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/9/14
 * Time: 下午4:16
 */

namespace app\common\tools;

use think\Config;
require_once  __DIR__.'/../../../extend/sphinxapi.php';

class SphinxClient
{
    /**
     * 私有化内部实例化的对象
     * @var null
     */
    private static $instance = null;

    /**
     * 默认设置
     * @var array
     */
    private static $config = [
        'host' => '127.0.0.1',
        'port' => 9312
    ];

    /**
     * 私有化构造方法，禁止外部实例化
     * SphinxClient constructor.
     */
    private function __construct() {}

    /**
     * 私有化__clone，防止被克隆
     */
    private function __clone() {}

    /**
     * 公有静态实例方法
     * @param array $config
     * @return null|\Sphinx
     */
    public static function getInstance($config=[]) {
        if (empty($config)) {
            self::$config = array_merge(self::$config, Config::get('sphinx_conf'));
        }

        if (empty(self::$instance)) {
            $Sphinx = new \Sphinx();
            $Sphinx->SetServer(self::$config['host'], self::$config['port']);
            self::$instance = $Sphinx;
        }

        return self::$instance;
    }
}


