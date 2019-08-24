<?php

/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/23
 * Time: 上午11:39
 */
namespace app\common\controller;

use think\Controller;
use think\Config;
use Firebase\JWT\JWT;

class Common extends Controller
{
    public function _initialize()
    {
        parent::_initialize();
        // 跨域设置
		header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, authKey, sessionId, token, cache-control, pragma");
        header("Access-Control-Max-Age: 600");
        // 解析token
        //$this->ParseToken();
    }

    /**
     * 解析token
     */
    public function ParseToken()
    {
        try {
            if (!isset($_SERVER['HTTP_TOKEN'])) {
                throw new \Exception("请求错误,token不存在", PARAM_ERROR);
            }
            $tokenStr = str_replace('Bearer ', '', $_SERVER['HTTP_TOKEN']);
            if (!$tokenStr) {
                throw new \Exception("请求错误，token为空", PARAM_ERROR);
            }
            //尝试解密
            $token = (array)JWT::decode($tokenStr, Config::get('encode_key'), ['HS256']);
            $this->user_id = $token['data']->user_id;

        } catch (\DomainException $e) {
            $ret['errormsg'] = $e->getMessage();
            $ret['errorcode'] = 90;
            $this->ajaxReturn($ret);
        } catch (\InvalidArgumentException $e) {
            $ret['errormsg'] = $e->getMessage();
            $ret['errorcode'] = 91;
            $this->ajaxReturn($ret);
        } catch (\UnexpectedValueException $e) {
            $ret['errormsg'] = $e->getMessage();
            $ret['errorcode'] = 92;
            $this->ajaxReturn($ret);
        } catch (\DateTime $e) {
            $ret['errormsg'] = $e->getMessage();
            $ret['errorcode'] = 93;
            $this->ajaxReturn($ret);
        } catch (\Exception $e) {
            $ret['errormsg'] = $e->getMessage();
            $ret['errorcode'] = $e->getCode();
            $this->ajaxReturn($ret);
        }
    }
}