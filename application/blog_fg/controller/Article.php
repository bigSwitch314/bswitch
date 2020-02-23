<?php
namespace app\blog_fg\controller;

use app\common\controller\CommonNotToken;
use app\common\service\blog\Article as ArticleService;


class Article extends CommonNotToken
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
            $category_id = $param['category_id'];
            $label_ids   = $param['label_ids'];
            $type        = $param['type'];
            $time_type   = $param['time_type'];
            $back_ground = $param['back_ground'] ?: 0;

            check_number([$id, $page_no, $page_size, $category_id], false);
            check_date([$begin_time, $end_time], false);
            check_string([$title, $label_ids], false);
            check_number_range($type, [1, 2], false);

            $result = (new ArticleService())->get($id,
                $page_no,
                $page_size,
                $title,
                $begin_time,
                $end_time,
                $category_id,
                $label_ids,
                $type,
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
     * 文章详情（前台）
     */
    public function getDetail()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];

            check_number($id);

            $result = (new ArticleService())->getDetial($id);

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
     * 文章归档（前台）
     */
    public function getArchive()
    {
        try {
            $param     = $this->param;
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number($page_no, $page_size);

            $result = (new ArticleService())->getArchive($page_no, $page_size);

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



