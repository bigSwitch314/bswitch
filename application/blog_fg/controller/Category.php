<?php
namespace app\blog_fg\controller;

use app\common\controller\CommonNotToken;
use app\common\service\blog\Category as CategoryService;



class Category extends CommonNotToken
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取记录
     */
    public function getStat()
    {
        try {
            $result = (new CategoryService())->getStat();

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $result ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }
}



