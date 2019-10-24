<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Menu as MenuModel;


class Menu
{
    /**
     * @var MenuModel
     */
    public $MenuModel;

    /**
     * Menu constructor
     */
    public function __construct()
    {

    }

    /**
     * getMenuModel
     */
    public function getMenuModel()
    {
        if(empty($this->MenuModel)) {
            $this->MenuModel = new MenuModel();
        }
        return $this->MenuModel;
    }

    /**
     * 添加/修改记录
     *
     * @param $id
     * @param $name
     * @param $pid
     * @param $sort
     * @return bool|false|int|mixed
     * @throws \think\exception\DbException
     */
    public function save($id, $name, $pid, $sort)
    {
        // 菜单名重复
        if ($id) $map['id'] = ['neq', $id];
        $map['name'] = $name;
        $map['delete'] = 0;
        $result = $this->getMenuModel()->getOneData($map);
        if ($result) {
            throw new \Exception('菜单名重复！', FAIL);
        }
        // 添加/修改
        $data['name'] = $name;
        $data['pid']  = $pid;
        $data['sort'] = $sort;

        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getMenuModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getMenuModel()->addOneData($data);
        }
    }

    /**
     * 获取记录
     * @param $id
     * @return false|mixed
     * @throws \think\exception\DbException
     */
    public function get($id)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getMenuModel()->getOneData($map);
        } else {
            $list = $this->getMenuModel()->getList();
            $tree = [];
            if ($list) {
                $tree = $this->generate_tree($list);
                $tree = $this->sort_tree($tree);
                dump($tree);die;
                $tree = $this->generate_serial_number($tree);
            }
            $result['tree'] = $tree;
            $result['list'] = $list;
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
        return $this->getMenuModel()->updateData($map, $data);
    }

    /**
     * 批量更新排序
     *
     * @param $list
     * @return array|false
     * @throws \Exception
     */
    public function batchUpdateSort($list) {
        return $this->getMenuModel()->batchUpdateData($list);
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
                    'id'       => $val['id'],
                    'name'     => $val['name'],
                    'pid'      => $val['pid'],
                    'pName'    => $val['pName'],
                    'children' => $this->generate_tree($list, $val['id']),
                    'sort'     => $val['sort'],
                ];
            }
        }
        if (count($tree)) {
            return $tree;
        }
        return null;
    }

    /**
     * 树排序
     *
     * @param $tree
     * @return array|null
     */
    public function sort_tree($tree) {
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
     * 生成序号
     *
     * @param $tree
     * @return mixed
     */
    public function generate_serial_number($tree) {
        array_walk($tree, function(&$value, $key) {
            $value['serial_number'] = $key + 1;
            if ($value['children']) {
                array_walk($value['children'], function(&$v, $k) use($key) {
                    $v['serial_number'] = ($key + 1) . '-' . ($k + 1);
                });
            };
        });

        return $tree;
    }


}