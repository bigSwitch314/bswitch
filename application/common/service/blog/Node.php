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
     * @param $id
     * @param $type
     * @param $data
     * @param $is_json_data
     * @return bool|false|int|mixed
     * @throws \think\exception\DbException
     */
    public function save($id, $type, $data, $is_json_data)
    {
        // 数据不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['type'] = $type;
        $map['delete'] = 0;
        $result = $this->getNodeModel()->getOneData($map);
        if ($result) {
            throw new \Exception('数据已存在！', FAIL);
        }
        // 添加/修改
        $save_data['type'] = $type;
        if ($is_json_data) {
            $save_data['json_data'] = $data;
        } else {
            $save_data['text_data'] = $data;
        }
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $save_data['edit_time'] = time();
            return $this->getNodeModel()->updateData($map, $save_data);
        } else {
            $save_data['create_time'] = time();
            return $this->getNodeModel()->addOneData($save_data);
        }
    }

    /**
     * 获取记录
     * @param $type
     * @return false|mixed
     * @throws \think\exception\DbException
     */
    public function get($type)
    {
        $map['type'] = $type;
        $map['delete'] = 0;
        return $this->getNodeModel()->getOneData($map);
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

}