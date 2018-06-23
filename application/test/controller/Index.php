<?php
namespace app\test\controller;

use app\common\controller\Common;
use think\Config;

class Index extends Common
{
    public function index()
    {
        try {
            $param = $this->param;
            //dump($param);

            $data  = json_encode_unescape($param);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data,
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }
}
