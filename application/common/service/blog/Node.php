<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Node as NodeModel;


class Node
{
    /**
     * @var NodeModel
     */
    public $NodeModel;

    /**
     * Node constructor
     */
    public function __construct()
    {

    }

    /**
     * getNodeModel
     */
    public function getNodeModel()
    {
        if(empty($this->NodeModel)) {
            $this->NodeModel = new NodeModel();
        }
        return $this->NodeModel;
    }

    /**
     * 添加/修改记录
     *
     * @param int $id
     * @param $name
     * @param $pid
     * @param $node
     * @param $status
     * @param $menu
     * @param $menu_id
     * @param $group_id
     * @return bool|false|int|mixed
     * @throws \think\exception\DbException
     */
    public function save($id=0,
                         $name,
                         $pid,
                         $node,
                         $status,
                         $menu,
                         $menu_id,
                         $group_id)
    {
        // 数据不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['delete'] = 0;
        $map['name']   = $name;
        $map['pid']    = $pid;
        $result = $this->getNodeModel()->getOneData($map);
        if ($result) {
            throw new \Exception('数据已存在！', FAIL);
        }
        // 添加/修改
        $data['name']     = $name;
        $data['pid']      = $pid;
        $data['node']     = $node;
        $data['status']   = $status;
        $data['menu']     = $menu;
        $data['menu_id']  = $menu_id;
        $data['group_id'] = $group_id;

        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getNodeModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getNodeModel()->addOneData($data);
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
    public function get($id, $page_no=1, $page_size=5)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getNodeModel()->getOneData(['id' => $id]);
        } else {
            $map['n.delete'] = 0;
            $node  = $this->getNodeModel()->getList($map, $page_no, $page_size);

            $tree = $node['list'] ? $this->generate_tree($node['list']) : [];
            $tree = $this->generate_serial_number($tree, $page_no, $page_size);

            $result = [
                'list'  => $tree,
                'count' => $node['count'] ?: 0
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
        return $this->getNodeModel()->updateData($map, $data);
    }

    /**
     * 无限极分类，递归生成树
     * @param $list
     * @param int $pid
     * @return array
     */
    public function generate_tree($list, $pid = 0) {
        $tree = [];
        foreach ($list as $val) {
            if ($val['pid'] == $pid) {
                $tree[] = [
                    'id'         => $val['id'],
                    'name'       => $val['name'],
                    'pid'        => $val['pid'],
                    'pname'      => $val['pname'],
                    'children'   => $this->generate_tree($list, $val['id']),
                    'node'       => $val['node'],
                    'menu'       => $val['menu'],
                    'menu_id'    => $val['menu_id'],
                    'status'     => $val['status'],
                    'group_id'   => $val['group_id'],
                    'group_name' => $val['group_name'],
                ];
            }
        }
        if (count($tree)) {
            return $tree;
        }
        return null;
    }

    /**
     * 生成序号
     *
     * @param $tree
     * @return mixed
     */
    public function generate_serial_number($tree, $page_no, $page_size) {
        array_walk($tree, function(&$value, $key) use($page_no, $page_size) {
            $serial_number = $key + 1 + ($page_no - 1) * $page_size;
            $value['serial_number'] = $serial_number;
            if ($value['children']) {
                array_walk($value['children'], function(&$v, $k) use($serial_number) {
                    $v['serial_number'] = $serial_number . '-' . ($k + 1);
                });
            };
        });

        return $tree;
    }

    /**
     * 获取一级节点
     *
     * @return false
     * @throws \think\exception\DbException
     */
    public function getLevelOneNode()
    {
        $map['delete'] = 0;
        $map['pid'] = 0;
        $fields = 'id, name';
        return $this->getNodeModel()->getMultiData($map, $fields);
    }

}