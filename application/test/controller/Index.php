<?php
namespace app\test\controller;

use app\common\controller\Common;
use app\common\model\UserBus;
use app\common\tools\RedisClient;
use app\common\model\UserBus as UserBusModel;
use think\Config;
use think\Db;

class Index extends Common
{
    /**
     * Index constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 框架测试
     */
    public function index()
    {
        try {
            $param = $this->param;

            $config = Config::get('template_msg.pt_card_template_id');

            $data  = json_encode_unescape($param);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data,
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * redis测试
     */
    public function redis()
    {
        //error_reporting(E_ERROR | E_WARNING | E_PARSE);

        try {
            $param = $this->param;
            echo $qq;die;
            $redis = new RedisClient();
            $res = $redis->get('name');
            dump($res);die;

            $data  = json_encode_unescape($param);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data,
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * mysql测试
     */
    public function mysql()
    {
        try {
            $UserBusModel = new UserBusModel();  //dump($UserBusModel);die;
            $map['bus_id'] = 1;
            $map['phone'] = 18203004644;
            $fields = 'user_id, username, phone';
            //$fields = '*';
            $result = $UserBusModel->getOneData($map, $fields);
            //$result = Db::table('rb_user_bus')->where($map)->field($fields)->select();
            //dump($UserBusModel::$links);die;

            //$reflect = new \ReflectionObject($UserBusModel);
            //dump($reflect);
            //dump($reflect->getProperties());
            //dump($reflect->getMethods());
            //die;

            dump($result);die;


            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data,
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }
}



