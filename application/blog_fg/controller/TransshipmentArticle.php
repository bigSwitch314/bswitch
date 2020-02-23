<?php
namespace app\blog_fg\controller;

use app\common\controller\CommonNotToken;
use app\common\service\blog\TransshipmentArticle as TransshipmentArticleService;


class TransshipmentArticle extends CommonNotToken
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
    public function get()
    {
        try {
            $param       = $this->param;
            $id          = $param['id'];
            $page_no     = $param['page_no'];
            $page_size   = $param['page_size'];
            $title       = $param['title'];
            $begin_time  = $param['begin_time'];
            $end_time    = $param['end_time'];
            $time_type   = $param['time_type'];
            $back_ground = $param['back_ground'] ?: 0;

            check_number([$id, $page_no, $page_size], false);
            check_date([$begin_time, $end_time], false);
            check_string([$title], false);
            check_number_range($time_type, [1, 2], false);

            $result = (new TransshipmentArticleService())->get(
                $id,
                $page_no,
                $page_size,
                $title,
                $begin_time,
                $end_time,
                $time_type,
                $back_ground);

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

    /**
     * 文章详情
     */
    public function getArticleDetail()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];

            check_number($id);

            $result = (new TransshipmentArticleService())->getArticleDetail($id);

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



