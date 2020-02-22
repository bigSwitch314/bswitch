<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Role as RoleModel;
use app\common\model\blog\RoleNode as RoleNodeModel;
use app\common\model\blog\AccountRole as AccountRoleModel;
use think\Db;


class Role
{
    /**
     * @var RoleModel
     */
    public $RoleModel;
    public $RoleNodeModel;
    public $AccountRoleModel;

    /**
     * Role constructor
     */
    public function __construct()
    {

    }

    /**
     * getRoleModel
     */
    public function getRoleModel()
    {
        if(empty($this->RoleModel)) {
            $this->RoleModel = new RoleModel();
        }
        return $this->RoleModel;
    }

    /**
     * getRoleNodeModel
     */
    public function getRoleNodeModel()
    {
        if(empty($this->RoleNodeModel)) {
            $this->RoleNodeModel = new RoleNodeModel();
        }
        return $this->RoleNodeModel;
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
     * 添加/修改记录
     *
     * @param int $id
     * @param $name
     * @param $status
     * @param $nodes
     * @return bool|false|int|mixed
     * @throws \think\exception\DbException
     */
    public function save($id=0,
                         $name,
                         $status,
                         $nodes)
    {
        // 数据不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['delete'] = 0;
        $map['name'] = $name;
        $result = $this->getRoleModel()->getOneData($map);
        if ($result) {
            throw new \Exception('角色名称重复！', FAIL);
        }

        // 添加/修改
        $data['name']   = $name;
        $data['status'] = $status;

        // 使用事务闭包
        Db::transaction(function() use($id, $data, $nodes) {
            $role_id = $id;
            if ($id) {
                $map['id'] = $id;
                $data['edit_time'] = time();
                $this->getRoleModel()->updateData($map, $data);
                $this->getRoleNodeModel()->deleteData(['role_id' => $id]);
            } else {
                $data['create_time'] = time();
                $role_id = $this->getRoleModel()->addOneData($data);
            }

            $node_data = array_map(function($value) use($role_id) {
                return [
                    'role_id' => $role_id,
                    'node_id' => $value,
                ];
            }, $nodes);
            $this->getRoleNodeModel()->addMultiData($node_data);
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
    public function get($id, $page_no=1, $page_size=5)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getRoleModel()->getOneData(['id' => $id]);

        } else {
            $map['delete'] = 0;
            $fields = 'id, name, status';
            $order  = 'create_time desc';
            $list = $this->getRoleModel()->getMultiData($map,
                $fields,
                $order,
                $page_no,
                $page_size);

            $count = $this->getRoleModel()->getDataCount($map);

            $accounts = [];
            $nodes = [];
            $role_ids = array_column((array)$list, 'id');
            if ($role_ids) {
                // 关联账号
                $admin = $this->getRoleModel()->getAdminByRoleIds($role_ids);
                foreach ($admin as $key => $value) {
                    $accounts[$value['role_id']][] = [
                        'id' => $value['admin_id'],
                        'name' => $value['username'],
                    ];
                }
                // 关联节点
                $table = 'bs_role_node';
                $where['role_id'] = ['in', $role_ids];
                $fields = 'node_id, role_id';
                $order = 'id asc';
                $page_no = 1;
                $page_size = 10000;
                $access = $this->getRoleModel()->getTableMultiData(
                    $table,
                    $where,
                    $fields,
                    $order,
                    $page_no,
                    $page_size);
                foreach ($access as $key => $value) {
                    $nodes[$value['role_id']][] = $value['node_id'];
                }
            }
            array_walk($list, function(&$value) use($accounts, $nodes) {
                $value['accounts'] = $accounts[$value['id']] ?: [];
                $value['nodes'] = $nodes[$value['id']] ?: [];
            });

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
        return $this->getRoleModel()->updateData($map, $data);
    }

    /**
     * 修改状态
     * @param $id
     * @param $status
     * @return bool|false|int
     */
    public function changeStatus($id, $status)
    {
        $map['id'] = $id;
        $data['status'] = $status;
        $data['edit_time'] = time();
        return $this->getRoleModel()->updateData($map, $data);
    }

    /**
     * 获取菜单节点树
     *
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function getMenuNodeTree()
    {
        $node_level_1 = $this->getRoleModel()->getNodeLevel1();

        $table = 'bs_node';
        $map['delete'] = 0;
        $map['status'] = 1;
        $map['pid'] = ['neq', 0];
        $field = 'id, name, pid, 1 as sort';
        $order = 'id asc';
        $page_no = 1;
        $page_size = 1000;
        $node_level_2 = $this->getRoleModel()->getTableMultiData(
            $table,
            $map,
            $field,
            $order,
            $page_no,
            $page_size);

        $table = 'bs_menu';
        unset($map);
        $map['pid'] = 0;
        $field = '-1*id as id, name, pid, sort';
        $menu_level_1 = $this->getRoleModel()->getTableMultiData($table, $map, $field);

        $list = array_merge($node_level_1, $node_level_2, $menu_level_1);

        $tree = generate_tree($list, $pid = 0);
        $tree = $this->sort_tree($tree);

        $result = [
            'tree' => $tree ?: [],
        ];

        return $result;
    }

    /**
     * 树排序
     *
     * @param $tree
     * @return array|null
     */
    public function sort_tree($tree)
    {
        //根据字段sort对数组$tree进行升序排列
        $sort = array_column($tree, 'sort');
        array_multisort($sort, SORT_ASC, $tree);
        foreach ($tree as &$value) {
            if (count($value['children']) > 1) {
                $sort = array_column($value['children'], 'sort');
                array_multisort($sort, SORT_ASC, $value['children']);
            }

        }
        unset($value);

        return $tree;
    }

    /**
     * 绑定账户
     *
     * @param $role_id
     * @param $account_ids
     * @return bool
     */
    public function bindAccount($role_id, $account_ids)
    {
        // 使用事务闭包
        Db::transaction(function() use($role_id, $account_ids) {
            $table = 'bs_account_role';
            $map['role_id'] = $role_id;
            $this->getRoleNodeModel()->deleteTableData($table, $map);

            $data = array_map(function($value) use($role_id) {
                return [
                    'role_id' => $role_id,
                    'admin_id' => $value,
                ];
            }, $account_ids);
            $this->getAccountRoleModel()->addMultiData($data);

        });

        return true;
    }

}