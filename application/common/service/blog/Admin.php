<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Admin as AdminModel;
use app\common\model\blog\AccountRole as AccountRoleModel;
use think\Db;


class Admin
{
    /**
     * @var AdminModel
     */
    public $AdminModel;

    /**
     * @var AccountRoleModel
     */
    public $AccountRoleModel;

    /**
     * Admin constructor
     */
    public function __construct()
    {

    }

    /**
     * getAccountRoleModel
     */
    public function getAccountRoleModel()
    {
        if(empty($this->AccountRoleModel)) {
            $this->AccountRoleModel = new AccountRoleModel();
        }
        return $this->AccountRoleModel;
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
     * @param $roles
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id,
                         $username,
                         $password,
                         $email,
                         $status,
                         $roles)
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

        // 使用事务闭包
        Db::transaction(function() use($id, $data, $roles, $password) {
            if ($id) {
                if (empty($password)) {
                    unset($data['password']);
                }
                unset($map);
                $map['id'] = $id;
                $data['edit_time'] = time();
                $this->getAdminModel()->updateData($map, $data);
            } else {
                $data['create_time'] = time();
                $id = $this->getAdminModel()->addOneData($data);
            }

            $this->getAccountRoleModel()->deleteData(['admin_id' => $id]);
            $role_data = array_map(function($value) use($id) {
                return [
                    'role_id' => $value,
                    'admin_id' => $id,
                ];
            }, $roles);
            $this->getAccountRoleModel()->addMultiData($role_data);
        });

        return true;
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

            if (100 == $page_size) {
               $list = array_map(function($value) {
                   return [
                       'id' => $value['id'],
                       'username' => $value['username'],
                   ];
               }, (array)$list);
            }

            // 关联角色
            $roles = [];
            $admin_ids = array_column((array)$list, 'id');
            if ($admin_ids) {
                // 关联账号
                $role_arr = $this->getAdminModel()->getRoleByAdminIds($admin_ids);
                foreach ($role_arr as $key => $value) {
                    $roles[$value['admin_id']][] = [
                        'id' => $value['role_id'],
                        'name' => $value['name'],
                    ];
                }
            }
            array_walk($list, function(&$value) use($roles) {
                $value['roles'] = $roles[$value['id']] ?: [];
            });

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

    /**
     * 登录
     *
     * @param $username
     * @param $password
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function login($username, $password)
    {
        $map['username'] = $username;
        $map['password'] = $password;
        $map['delete'] = 0;

        return $this->getAdminModel()->getOneData($map);
    }

    /**
     * 设置登录时间
     *
     * @param $username
     * @return bool|false|int
     */
    public function setLoginTime($username)
    {
        $map['username'] = $username;
        $data['last_login_time'] = time();
        return $this->getAdminModel()->updateData($map, $data);

    }

    /**
     * 修改密码
     *
     * @param $userid
     * @param $old_password
     * @param $new_password
     * @return bool|false|int
     * @throws \think\exception\DbException
     * @throws \Exception
     */
    public function modifyPassword($userid, $old_password, $new_password)
    {

        $map['id'] = $userid;
        $map['password'] = $old_password;
        $result = $this->getAdminModel()->getOneData($map);
        if (!$result) {
            throw new \Exception('原始密码错误', OLD_PASSWORD_ERROR);
        }

        unset($map['password']);
        $data['password'] = $new_password;
        $data['edit_time'] = time();
        return $this->getAdminModel()->updateData($map, $data);

    }

}