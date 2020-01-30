<?php
namespace app\blog\controller;

use app\common\service\blog\Admin as AdminService;
use think\captcha\Captcha;
use Firebase\JWT\JWT;
use think\Config;
use think\Controller;
use think\Response;


class PublicController extends Controller
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();
        // 跨域设置
        header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, token, cache-control, pragma");
        header("Access-Control-Max-Age: 600");
        // 跨域返回
        $method = $this->request->method();
        if (strtoupper($method) == 'OPTIONS') {
            return Response::create()->send();
        }
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

            check_string([$username, $password]);

            $result = (new AdminService())->login($username, $password);
            if($result == null) {
                throw new \Exception('账号或密码错误', LOGIN_PASSWORD_ERROR);
            }

            // 验证码校验
            $captcha = new Captcha();
            $verify_result = $captcha->check($valid_code);
            switch ($verify_result) {
                case -3:
                    throw new \Exception('验证码错误！', VERIFY_CODE_ERROR);
                case -2:
                    throw new \Exception('验证码过期！', VERIFY_CODE_EXPIRE);
                case -1:
                    throw new \Exception('验证码不能为空！', VERIFY_CODE_EMPTY);
                default:
            }

            $key = Config::get('encode_key');
            $time = time(); //当前时间
            $token = [
                'nbf' => $time, //(Not Before)：某个时间点后才能访问，比如设置time+30，表示当前时间30秒后才能使用
                'exp' => $time + 86400 * 7, //过期时间,这里设置7天
                'data' => [ //自定义信息，不要定义敏感信息
                    'user_id'   => $result['id'],
                    'user_name' => $result['username'],
                ]
            ];
            $token = JWT::encode($token, $key);    //输出Token


            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '登录成功',
                'data'    => [
                    'token'     => $token,
                    'user_id'   => $result['id'],
                    'user_name' => $result['username'],
                ],
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

    /**
     * 获取验证码
     *
     * @return \think\Response
     */
    function getCaptcha()
    {
        $id = '';
        $config = [
            'length' => 4,
            'fontSize' => 14,
            'useCurve' => true,
            'useNoise' => false,
            'fontttf'  => 'Elephant.ttf',
        ];

        $captcha = new Captcha($config);

        return $captcha->entry($id);
    }

}



