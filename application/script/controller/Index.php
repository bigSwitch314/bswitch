<?php
namespace app\script\controller;

use app\common\controller\Common;

class Index extends Common
{
    /**
     * Index constructor.
     */
    public function __construct() {
        parent::__construct();
        if (!IS_CLI) {
            exit($this->request->action().'(): It must be used in PHP CLI mode.');
        }
    }

    /**
     * 测试
     * @return string
     */
    public function index()
    {
        return 'This is script!';
    }
}
