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

            $config = Config::get('template_msg.pt_card_template_id');

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
