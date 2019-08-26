<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\OpenSourceProject as OpenSourceProjectService;


class OpenSourceProject extends Common
{
    /**
     * OpenSourceProject constructor.
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
            $param   = $this->param;
            $name    = $param['name'];
            $level   = $param['level'];
            $url     = $param['url'];
            $version = $param['version'];
            $release = $param['release'];

            check_string([$name, $url, $version]);
            check_number_range($level, [1, 2, 3]);
            check_number_range($release, [0, 1]);

            $status = (new OpenSourceProjectService())->save(
                $id=0,
                $name,
                $level,
                $url,
                $version,
                $release);

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
            $param   = $this->param;
            $id      = $param['id'];
            $name    = $param['name'];
            $level   = $param['level'];
            $url     = $param['url'];
            $version = $param['version'];
            $release = $param['release'];

            check_string([$name, $url, $version]);
            check_number_range($level, [1, 2, 3]);
            check_number_range($release, [0, 1]);
            check_number($id);

            $status = (new OpenSourceProjectService())->save(
                $id,
                $name,
                $level,
                $url,
                $version,
                $release);
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
            $param      = $this->param;
            $id         = $param['id'];
            $page_no    = $param['page_no'];
            $page_size  = $param['page_size'];
            $name       = $param['name'];
            $begin_time = $param['begin_time'];
            $end_time   = $param['end_time'];
            $time_type  = $param['time_type'];

            check_number([$id, $page_no, $page_size], false);
            check_date([$begin_time, $end_time], false);
            check_string([$name], false);
            check_number_range($time_type, [1, 2], false);

            $result = (new OpenSourceProjectService())->get(
                $id,
                $page_no,
                $page_size,
                $name,
                $begin_time,
                $end_time,
                $time_type);

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

            $status = (new OpenSourceProjectService())->delete($id);

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
     * 修改发布状态
     */
    public function changeReleaseStatus()
    {
        try {
            $param  = $this->param;
            $id     = $param['id'];
            $release = $param['release'];

            check_number($id);
            check_number($release, [0, 1]);

            $status = (new OpenSourceProjectService())->changeReleaseStatus($id, $release);

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

}



