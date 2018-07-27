<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:21
 */

namespace app\common\service\admin;

use app\common\model\admin\Menu as MenuModel;


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
     * 添加/修改菜单
     * @param $id
     * @param $pid
     * @param $name
     * @param $sort
     * @param $display
     * @return bool|false|int
     * @throws \Exception
     */
    public function save($id,
                         $pid,
                         $name,
                         $sort,
                         $display)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['name'] = $name;
        $map['deleted'] = 0;
        $result = $this->getMenuModel()->getOneData($map);
        if ($result) {
            throw new \Exception('菜单名重复！', FAIL);
        }
        // 添加/修改
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data = [
                'name'      => $name,
                'sort'      => $sort,
                'display'   => $display,
                'edit_time' => time()
            ];
            return $this->getMenuModel()->updateData($map, $data);
        } else {
            $data = [
                'pid'         => $pid,
                'name'        => $name,
                'sort'        => $sort,
                'display'     => $display,
                'create_time' => time()
            ];
            return $this->getMenuModel()->addOneData($data);
        }
    }

    /**
     * 获取
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        if ($id) {
            $map['id'] = $id;
            $map['deleted'] = 0;
            $result = $this->getMenuModel()->getOneData(['id' => $id]);
        } else {
            $result = $this->getMenuModel()->getMenu();
            $temp = [];
            foreach ($result as $val) {

                if (empty($temp[$val['id']]['id'])) {
                    $temp[$val['id']]['id']   = $val['id'];
                    $temp[$val['id']]['name'] = $val['name'];
                    $temp[$val['id']]['sort'] = $val['sort'];
                }

                if ($val['no_title']) {
                    $temp[$val['id']]['son'][] = [
                        'name'  => $val['no_title'],
                        'level' => $val['no_level'],
                        'url'   => $val['no3_name'] . '/' . $val['no2_name'] . '/' . $val['no_name'],
                        'sort'  => $val['no_sort'],
                    ];
                } else {
                    $temp[$val['id']]['son'] = [];
                }
            }
            $result = array_values($temp);
        }

        return $result;
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $map['id'] = $id;
        return $this->getMenuModel()->deleteData($map);
    }
}