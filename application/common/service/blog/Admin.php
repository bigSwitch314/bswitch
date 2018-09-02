<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Admin as AdminModel;


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
     * @param $email
     * @param $status
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id,
                         $username,
                         $password,
                         $email,
                         $status)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['username'] = $username;
        $map['delete'] = 0;
        $result = $this->getAdminModel()->getOneData($map);
        if ($result) {
            throw new \Exception('用户名重复！', FAIL);
        }
        // 添加/修改
        $data = [
            'username'  => $username,
            'password'  => $password,
            'email'     => $email,
            'status'    => $status
        ];
        if ($id) {
            if (empty($password)) {
                unset($data['password']);
            }
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
     * @param $page_no
     * @param $page_size
     * @return false|mixed
     * @throws \think\exception\DbException
     */
    public function get($id, $page_no, $page_size)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getAdminModel()->getOneData(['id' => $id]);
        } else {
            $page_no   = $page_no ?: 1;
            $page_size = $page_size ?: 10;
            $map['delete'] = 0;
            $fields = 'id, username, email, status, type, if(last_login_time, from_unixtime(last_login_time, \'%Y-%m-%d %H:%i\'), \'—\') as last_login_time';
            $order  = 'create_time desc';
            $list = $this->getAdminModel()->getMultiData($map,
                $fields,
                $order,
                $page_no,
                $page_size);

            $count = $this->getAdminModel()->getDataCount($map);

            $result = [
                'list' => $list ?: [],
                'count' => $count ?: 0
            ];
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
        $map['id'] = ['in', $id];
        $data['delete'] = 1;
        $data['edit_time'] = time();
        return $this->getAdminModel()->updateData($map, $data);
    }

    /**
     * 修改账号状态
     * @param $id
     * @param $status
     * @return bool|false|int
     */
    public function changeStatus($id, $status)
    {
        $map['id'] = $id;
        $data['status'] = $status;
        $data['edit_time'] = time();
        return $this->getAdminModel()->updateData($map, $data);
    }

}