<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/27
 * Time: 下午11:14
 */

namespace app\common\model;

use think\model;

class Common extends model
{
    /**
     * Common constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 查询单条记录
     * @param array $where
     * @param array $fields
     * @return mixed
     */
    public function getOneData($where = [], $fields = [])
    {
        return $this
            ->where($where)
            ->field($fields)
            ->find();
    }

    /**
     * 查询多条记录
     * @param array $where
     * @param array $fields
     * @param string $order
     * @return mixed
     */
    public function getMultiData($where = [], $fields = ['id'], $order = 'id asc')
    {
        return $this
            ->where($where)
            ->field($fields)
            ->order($order)
            ->select();
    }

    /**
     * 添加单条记录
     * @param $data
     * @return mixed
     */
    public function addOneData($data)
    {
        return $this->add($data);
    }

    /**
     * 添加多条记录
     * @param $data
     * @return bool|string
     */
    public function addMultiData($data)
    {
        return $this->addAll($data);
    }

    /**
     * 更新记录
     *
     * @param array $where
     * @param $data
     * @return bool|false|int
     */
    public function updateData($where = [], $data)
    {
        return $this->where($where)->save($data);
    }

    /**
     * 删除记录
     *
     * @param $where
     * @return int|mixed
     */
    public function deleteData($where)
    {
        return $this->where($where)->delete();
    }

    /**
     * 查询一条记录的某个字段
     *
     * @param $where
     * @param $field
     * @return mixed
     */
    public function getDataField($where, $field)
    {
        return $this->where($where)->getField($field);
    }

    /**
     * 统计记录数量
     * @param array $where
     * @return false|mixed
     */
    public function getDataCount($where = [])
    {
        return $this->where($where)->count();
    }

    /**
     * 查询指定表的多条记录
     * @param $table
     * @param array $where
     * @param array $fields
     * @param string $order
     * @return mixed
     */
    public function getTableMultiData($table, $where = [], $fields = ['id'], $order = 'id asc')
    {
        return $this
            ->table($table)
            ->where($where)
            ->field($fields)
            ->order($order)
            ->select();
    }
}