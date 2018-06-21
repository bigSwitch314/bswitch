<?php
namespace app\test\controller;

use think\config;
class Index
{
    public function index()
    {
        echo get_env();die;
        return 'Hello world!';
    }
}
