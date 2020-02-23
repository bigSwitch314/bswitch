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
    public function get()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $page_no, $page_size], false);

            $result = (new CategoryService())->get($id, $page_no, $page_size);

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
     * 所有分类统计
     */
    public function getAllCategoryStats()
    {
        try {

            $data = (new CategoryService())->getAllCategoryStats();

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 根据分类查文章
     */
    public function getArticleByCategory()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $page_no, $page_size]);

            $data = (new CategoryService())->getArticleByCategory($id, $page_no, $page_size);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

}



