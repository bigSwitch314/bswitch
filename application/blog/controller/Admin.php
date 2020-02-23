<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Admin as AdminService;


class Admin extends Common
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
            $param    = $this->param;
            $username = $param['username'];
            $password = $param['password'];
            $email    = $param['email'];
            $status   = $param['status'];
            $roles    = $param['roles'];

            check_string([$username, $password]);
            check_number_range($status, [0, 1]);
            check_email($email);
            check_number($roles);

            $status = (new AdminService())->save($id=0,
                $username,
                $password,
                $email,
                $status,
                $roles);
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
            $username = $param['username'];
            $password = $param['password'];
            $email    = $param['email'];
            $status   = $param['status'];
            $roles    = $param['roles'];

            check_number($id);
            check_string($username);
            check_string($password, false);
            check_email($email);
            check_number_range($status,[0, 1]);
            check_number($roles);

            $status = (new AdminService())->save($id,
                $username,
                $password,
                $email,
                $status,
                $roles);
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
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $page_no, $page_size], false);

            $result = (new AdminService())->get($id, $page_no, $page_size);

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

            $status = (new AdminService())->delete($id);

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
     * 修改账号状态
     */
    public function changeStatus()
    {
        try {
            $param  = $this->param;
            $id     = $param['id'];
            $status = $param['status'];

            check_number($id);
            check_number($status, [0, 1]);

            $status = (new AdminService())->changeStatus($id, $status);

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
     * 修改密码
     */
    public function modifyPassword()
    {
        try {
            $param        = $this->param;
            $userid       = $param['userid'];
            $old_password = $param['old_password'];
            $new_password = $param['new_password'];

            check_number($userid);
            check_string([$old_password, $new_password]);

            $status = (new AdminService())->modifyPassword($userid, $old_password, $new_password);

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



