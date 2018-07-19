<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\admin;

use app\common\model\admin\Admin as AdminModel;


class Admin
{
    /**
     * @var AdminModel
     */
    public $AdminModel;

    /**
     * Admin constructor
     */
    public function __construct()
    {

    }

    /**
     * getAdminModel
     */
    public function getAdminModel()
    {
        if(empty($this->AdminModel)) {
            $this->AdminModel = new AdminModel();
        }
        return $this->AdminModel;
    }

    /**
     * 添加/修改记录
     * @param $id
     * @param $username
     * @param $password
     * @param $phone
     * @param $status
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id,
                         $username,
                         $password,
                         $phone,
                         $status)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['username'] = $username;
        $map['deleted'] = 0;
        $result = $this->getAdminModel()->getOneData($map);
        if ($result) {
            throw new \Exception('用户名重复！', FAIL);
        }
        // 添加/修改
        $data = [
            'username'  => $username,
            'password'  => $password,
            'phone'     => $phone,
            'status'    => $status
        ];
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getAdminModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getAdminModel()->addOneData($data);
        }
    }

    /**
     * 获取记录
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        if ($id) {
            $map['id'] = $id;
            $map['deleted'] = 0;
            $result = $this->getAdminModel()->getOneData(['id' => $id]);
        } else {
            $map['deleted'] = 0;
            $fields = 'id, username, phone, status';
            $order = 'create_time desc';
            $result = $this->getAdminModel()->getMultiData($map, $fields, $order);
        }
        return $result;
    }

    /**
     * 删除记录
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $map['id'] = $id;
        return $this->getAdminModel()->deleteData($map);
    }




}