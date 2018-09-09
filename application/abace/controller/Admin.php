<?php
namespace app\abace\controller;

use app\common\controller\Common;
use app\common\service\blog\Customer as CustomerService;


class Customer extends Common
{
    /**
     * Customer constructor.
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

            check_string([$username, $password]);
            check_number_range($status, [0, 1]);
            check_email($email);

            $status = (new CustomerService())->save($id=0,
                $username,
                $password,
                $email,
                $status);
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

            check_number($id);
            check_string($username);
            check_string($password, false);
            check_email($email);
            check_number_range($status,[0, 1]);

            $status = (new CustomerService())->save($id,
                $username,
                $password,
                $email,
                $status);
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

            $result = (new CustomerService())->get($id, $page_no, $page_size);

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

            $status = (new CustomerService())->delete($id);

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



