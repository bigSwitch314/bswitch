<?php
namespace app\blog\controller;

use app\common\controller\Common;
use think\Config;


class Article extends Common
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function test()
    {
        dump(Config::get());
        echo 11;die;
    }





}



