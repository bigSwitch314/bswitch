<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:02
 */

namespace app\admin\controller;

use app\common\controller\Common;
use app\common\service\admin\Node as NodeService;


class Node extends Common
{
    /**
     * 添加/修改记录
     */
    public function save()
    {
        try {
            $param  = $this->param;
            $id     = $param['id'];
            $pid    = $param['pid'];
            $gid    = $param['gid'];
            $name   = $param['name'];
            $title  = $param['title'];
            $level  = $param['level'];
            $status = $param['status'];
            $sort   = $param['sort'];
            $menu   = $param['menu'];
            $module = $param['module'];

            check_number([$id], false);
            check_number([$pid, $gid, $sort]);
            check_number_range($level, [1, 2, 3]);
            check_number_range($status, [0, 1]);
            check_number_range($menu, [0, 1]);
            check_string([$name, $title, $module]);

            $status = (new NodeService())->save($id,
                $pid,
                $gid,
                $name,
                $title,
                $level,
                $status,
                $sort,
                $menu,
                $module);

            $msg = $id ? '修改' : '添加';
            if (false === $status) {
                throw new \Exception($msg . '失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => $msg . '成功!',
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
            $param = $this->param;
            $id    = $param['id'];

            if ($id && !is_numeric($id)) {
                throw new \Exception('参数错误！', PARAM_ERROR);
            }

            $result = (new NodeService())->get($id);

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

            check_number($id);

            $status = (new NodeService())->delete($id);

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

}