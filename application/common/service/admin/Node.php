<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午11:55
 */

namespace app\common\service\admin;

use app\common\model\admin\Node as NodeModel;


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
     * @param $id
     * @param $pid
     * @param $gid
     * @param $name
     * @param $title
     * @param $level
     * @param $status
     * @param $sort
     * @param $menu
     * @param $module
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id,
                         $pid,
                         $gid,
                         $name,
                         $title,
                         $level,
                         $status,
                         $sort,
                         $menu,
                         $module)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['title'] = $title;
        $map['deleted'] = 0;
        $result = $this->getNodeModel()->getOneData($map);
        if ($result) {
            throw new \Exception('用户名重复！', FAIL);
        }
        // 添加/修改
        $data = [
            'pid'       => $pid,
            'gid'       => $gid,
            'name'      => $name,
            'title'     => $title,
            'level'     => $level,
            'status'    => $status,
            'sort'      => $sort,
            'menu'      => $menu,
            'module'    => $module,
        ];
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
     * @return mixed
     */
    public function get($id)
    {
        if ($id) {
            $map['id'] = $id;
            $map['deleted'] = 0;
            $result = $this->getNodeModel()->getOneData(['id' => $id]);
        } else {
            $map['deleted'] = 0;
            $fields = 'id, pid, gid, name, title, level, status, sort, menu, module';
            $order = 'create_time desc';
            $result = $this->getNodeModel()->getMultiData($map, $fields, $order);
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
        return $this->getNodeModel()->deleteData($map);
    }

}