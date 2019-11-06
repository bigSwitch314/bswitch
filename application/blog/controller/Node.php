<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Node as NodeService;


class Node extends Common
{
    /**
     * Node constructor.
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
            $param    = $this->param;
            $name     = $param['name'];
            $pid      = $param['pid'];
            $node     = $param['node'];
            $status   = $param['status'];
            $menu     = $param['menu'];
            $menu_id  = $param['menu_id'];
            $group_id = $param['group_id'];

            check_string([$name, $node]);
            check_number([$pid, $group_id, $menu_id]);
            check_number_range($status, [0, 1]);
            check_number_range($menu, [0, 1]);

            $status = (new NodeService())->save(
                $id=0,
                $name,
                $pid,
                $node,
                $status,
                $menu,
                $menu_id,
                $group_id);

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
            $param    = $this->param;
            $id       = $param['id'];
            $name     = $param['name'];
            $pid      = $param['pid'];
            $node     = $param['node'];
            $status   = $param['status'];
            $menu     = $param['menu'];
            $menu_id  = $param['menu_id'];
            $group_id = $param['group_id'];

            check_string([$name, $node]);
            check_number([$id, $pid, $group_id, $menu_id]);
            check_number_range($status, [0, 1]);
            check_number_range($menu, [0, 1]);

            $status = (new NodeService())->save(
                $id,
                $name,
                $pid,
                $node,
                $status,
                $menu,
                $menu_id,
                $group_id);

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
            $param     = $this->param;
            $id        = $param['id'];
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $page_no], false);

            $result = (new NodeService())->get($id, $page_no, $page_size);

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

    /**
     * 获取一级节点
     */
    public function getLevelOneNode()
    {
        try {

            $result = (new NodeService())->getLevelOneNode();

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



