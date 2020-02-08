<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\TransshipmentArticle as TransshipmentArticleService;


class TransshipmentArticle extends Common
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加记录
     */
    public function add()
    {
        try {
            $param        = $this->param;
            $title        = $param['title'];
            $author       = $param['author'];
            $link         = $param['link'];
            $release      = $param['release'];
            $content_md   = $param['content_md'];

            check_string([$title, $author, $link, $content_md]);
            check_number_range($release, [0, 1]);

            $status = (new TransshipmentArticleService())->save(
                $id=0,
                $title,
                $author,
                $link,
                $release,
                $content_md);

            if (false === $status) {
                throw new \Exception('添加失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '添加成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 修改记录
     */
    public function edit()
    {
        try {
            $param        = $this->param;
            $id           = $param['id'];
            $title        = $param['title'];
            $author       = $param['author'];
            $link         = $param['link'];
            $release      = $param['release'];
            $content_md   = $param['content_md'];

            check_string([$title, $author, $link, $content_md]);
            check_number_range($release, [0, 1]);
            check_number($id);

            $status = (new TransshipmentArticleService())->save(
                $id,
                $title,
                $author,
                $link,
                $release,
                $content_md);
            if (false === $status) {
                throw new \Exception('编辑失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '编辑成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
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
     * 删除记录
     */
    public function delete()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];

            if (false === strpos($id, ',')) {
                check_number($id, true);
            } else {
                $id = array_filter(explode(',', $id));
                check_not_null($id);
            }

            $status = (new TransshipmentArticleService())->delete($id);

            if (false === $status) {
                throw new \Exception('删除失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '删除成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 修改文章发布状态
     */
    public function changeReleaseStatus()
    {
        try {
            $param  = $this->param;
            $id     = $param['id'];
            $release = $param['release'];

            check_number($id);
            check_number($release, [0, 1]);

            $status = (new TransshipmentArticleService())->changeReleaseStatus($id, $release);

            if (false === $status) {
                throw new \Exception('修改失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '修改成功!',
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



