<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Role as RoleService;


class Role extends Common
{
    /**
     * Role constructor.
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
            $param  = $this->param;
            $name   = $param['name'];
            $status = $param['status'];
            $nodes  = $param['nodes'];

            check_string($name);
            check_number_range($status, [0, 1]);
            check_number($nodes);

            $status = (new RoleService())->save(
                $id=0,
                $name,
                $status,
                $nodes);

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
            $param  = $this->param;
            $id     = $param['id'];
            $name   = $param['name'];
            $status = $param['status'];
            $nodes  = $param['nodes'];

            check_number($id);
            check_string($name);
            check_number_range($status, [0, 1]);
            check_number($nodes);

            $status = (new RoleService())->save(
                $id,
                $name,
                $status,
                $nodes);

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

            $result = (new RoleService())->get($id, $page_no, $page_size);

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

            $status = (new RoleService())->delete($id);

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
     * 修改角色状态
     */
    public function changeStatus()
    {
        try {
            $param  = $this->param;
            $id     = $param['id'];
            $status = $param['status'];

            check_number($id);
            check_number($status, [0, 1]);

            $status = (new RoleService())->changeStatus($id, $status);

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
     * 获取菜单节点树
     */
    public function getMenuNodeTree()
    {
        try {
            $result = (new RoleService())->getMenuNodeTree();

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
     * 绑定账号
     */
    public function bindAccount()
    {
        try {
            $param       = $this->param;
            $role_id     = $param['role_id'];
            $account_ids = $param['account_ids'];

            check_number($role_id);
            check_number($account_ids);
            $status = (new RoleService())->bindAccount($role_id, $account_ids);

            if (false === $status) {
                throw new \Exception('绑定失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '绑定成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }


}



