<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:03
 */

namespace app\admin\controller;

use app\common\controller\Common;
use app\common\service\admin\Admin as AdminService;


class Admin extends Common
{
    /**
     * 添加/修改记录
     */
    public function save()
    {
        try {
            $param    = $this->param;
            $id       = $param['id'];
            $username = $param['username'];
            $password = $param['password'];
            $phone    = $param['phone'];
            $status   = $param['status'];

            check_number_range($status, [0, 1]);
            check_phone($phone);
            if (!$username || !is_string($username) ||
                !$password || !is_string($password) ||
                $id        && !is_numeric($id))
            {
                throw new \Exception('参数错误！', PARAM_ERROR);
            }

            $status = (new AdminService())->save($id,
                $username,
                $password,
                $phone,
                $status);
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

            $result = (new AdminService())->get($id);

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

}