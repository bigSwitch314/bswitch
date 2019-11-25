<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/27
 * Time: 下午11:14
 */

namespace app\common\model;

use think\Model;

class Common extends Model
{
    /**
     * 查询单条记录
     * @param array $where
     * @param array $fields
     * @return array|false|
     * @throws \think\exception\DbException
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
     * @param null $page_no
     * @param null $page_size
     * @return false
     * @throws \think\exception\DbException
     */
    public function getMultiData($where = [],
                                 $fields = ['id'],
                                 $order = 'id desc',
                                 $page_no = null,
                                 $page_size = null)
    {
        return $this
            ->where($where)
            ->field($fields)
            ->order($order)
            ->page($page_no, $page_size)
            ->select();
    }

    /**
     * 添加单条记录
     * @param $data
     * @return mixed
     */
    public function addOneData($data)
    {
        return $this->save($data);
    }

    /**
     * 添加多条记录
     * @param $data
     * @return array|false
     * @throws \Exception
     */
    public function addMultiData($data)
    {
        return $this->saveAll($data);
    }

    /**
     * 更新记录
     * @param array $where
     * @param $data
     * @return bool|false|int
     */
    public function updateData($where = [], $data)
    {
        return $this->save($data, $where);
    }

    /**
     * 批量更新
     *
     * @param $list
     * @return array|false
     * @throws \Exception
     */
    public function batchUpdateData($list)
    {
        return $this->saveAll($list);
    }

    /**
     * 删除记录
     * @param $where
     * @return int|mixed
     */
    public function deleteData($where)
    {
        return $this->where($where)->delete();
    }

    /**
     * 查询一条记录的某个字段
     * @param $where
     * @param $field
     * @return mixed
     * @throws \think\exception\DbException
     */
    public function getDataField($where, $field)
    {
        $result = $this->where($where)->find();
        return $result[$field];
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
     * @param null $page_no
     * @param null $page_size
     * @return false
     * @throws \think\exception\DbException
     */
    public function getTableMultiData($table,
                                      $where = [],
                                      $fields = ['id'],
                                      $order = 'id asc',
                                      $page_no = null,
                                      $page_size = null)
    {
        return $this
            ->table($table)
            ->where($where)
            ->field($fields)
            ->order($order)
            ->page($page_no, $page_size)
            ->select();
    }

    /**
     * 统计指定表记录数量
     * @param $table
     * @param array $where
     * @return int|string
     */
    public function getTableDataCount($table, $where = [])
    {
        return $this
            ->table($table)
            ->where($where)
            ->count();
    }

    /**
     * 删除指定表记录
     * @param $table
     * @param $where
     * @return int|mixed
     */
    public function deleteTableData($table, $where)
    {
        return $this
            ->table($table)
            ->where($where)
            ->delete();
    }

    /**
     * 添加多条记录
     * @param $table
     * @param $data
     * @return array|false
     * @throws \Exception
     */
    public function addTableMultiData($table, $data)
    {
        return $this->table($table)->saveAll($data);
    }
}