<?php
namespace app\blog_fg\controller;

use app\common\controller\CommonNotToken;
use app\common\service\blog\MetaData as MetaDataService;


class AuthorIntroduction extends CommonNotToken
{
    /**
     * MetaData constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取记录
     */
    public function get()
    {
        try {
            $param = $this->param;
            $type    = $param['type'];

            check_number_range($type, range(1, 50));

            $result = (new MetaDataService())->get($type);

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



