<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Menu as MenuService;


class Menu extends Common
{
    /**
     * Menu constructor.
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
            $param = $this->param;
            $name  = $param['name'];
            $pid   = $param['pid'];
            $sort  = $param['sort'];

            check_string($name);
            check_number([$pid, $sort]);

            $status = (new MenuService())->save($id=0, $name, $pid, $sort);
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
            $param = $this->param;
            $id    = $param['id'];
            $name  = $param['name'];
            $pid   = $param['pid'];
            $sort  = $param['sort'];

            check_string($name);
            check_number([$id, $pid, $sort]);

            $status = (new MenuService())->save($id, $name, $pid, $sort);
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
            $param = $this->param;
            $id    = $param['id'];

            check_number($id, false);

            $result = (new MenuService())->get($id);

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

            $status = (new MenuService())->delete($id);

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

    public function batchUpdateSort() {
        try {
            $param = $this->param;
            $list = $param['list'];

            check_list($list, ['id', 'sort']);

            $status = (new MenuService())->batchUpdateSort($list);

            if (false === $status) {
                throw new \Exception('操作失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '操作成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

}



