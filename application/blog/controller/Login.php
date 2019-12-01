<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\Admin as AdminService;


class Login extends Common
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
    public function login()
    {
        try {
            $param      = $this->param;
            $username   = $param['username'];
            $password   = $param['password'];
            $valid_code = $param['valid_code'];

            check_string([$username, $password, $valid_code]);

            $status = (new AdminService())->login($username, $password, $valid_code);

            switch ($status) {
                case 2:
                    throw new \Exception('账号或密码错误', LOGIN_PASSWORD_ERROR);
                    break;
                case 3:
                    throw new \Exception('验证码错误', LOGIN_CODE_ERROR);
                    break;
                case 4:
                    throw new \Exception('验证码过期', LOGIN_CODE_EXPIRE);
                    break;
                default:
                    break;
            }


            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '登录成功',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 添加记录
     */
    public function logout()
    {
        try {
            $param      = $this->param;
            $username   = $param['username'];
            $password   = $param['password'];

            check_string([$username, $password], false);
            
            $status = (new AdminService())->logout($username, $password);

            if (false === $status) {
                throw new \Exception('退出失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '退出成功',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

}



