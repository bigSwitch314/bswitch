<?php
namespace app\abace\controller;

use think\Controller;
use app\common\service\abace\Admin as AdminService;


class Index extends Controller
{
    /**
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // 跨域设置
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, token");
        header("Access-Control-Max-Age: 600");
    }

    /**
     * 登录
     */
    public function login()
    {
        try {
            $param    = $this->param;
            $username = $param['username'];
            $password = $param['password'];

            check_string([$username, $password]);

            $data = (new AdminService())->login($username, $password);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '登录成功!',
                'data'    => $data
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 退出
     */
    public function logout()
    {

    }
}



