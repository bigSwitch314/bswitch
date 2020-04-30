<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Article as ArticleService;


class Article extends Common
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
            $category_id  = $param['category_id'];
            $label_ids    = $param['label_ids'];
            $type         = $param['type'];
            $release      = $param['release'];
            $content_md   = $param['content_md'];
            $content_html = $param['content_html'];
            $word_number  = $param['word_number'];

            check_string([$title, $content_md, $content_html]);
            check_number($category_id, $word_number);
            check_string($label_ids, false);
            check_number_range($type, [1, 2, 3, 4]);
            check_number_range($release, [0, 1]);

            $status = (new ArticleService())->save($id=0,
                $title,
                $category_id,
                $label_ids,
                $type,
                $release,
                $content_md,
                $content_html,
                $word_number);

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
            $category_id  = $param['category_id'];
            $label_ids    = $param['label_ids'];
            $type         = $param['type'];
            $release      = $param['release'];
            $content_md   = $param['content_md'];
            $content_html = $param['content_html'];
            $word_number  = $param['word_number'];

            check_string([$title, $content_md, $content_html]);
            check_number($category_id, $word_number);
            check_string($label_ids, false);
            check_number_range($type, [1, 2, 3, 4]);
            check_number_range($release, [0, 1]);

            $status = (new ArticleService())->save($id,
                $title,
                $category_id,
                $label_ids,
                $type,
                $release,
                $content_md,
                $content_html,
                $word_number);
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

            $status = (new ArticleService())->delete($id);

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

            $status = (new ArticleService())->changeReleaseStatus($id, $release);

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



