<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Label as LabelModel;


class Label
{
    /**
     * @var LabelModel
     */
    public $LabelModel;

    /**
     * Label constructor
     */
    public function __construct()
    {

    }

    /**
     * getLabelModel
     */
    public function getLabelModel()
    {
        if(empty($this->LabelModel)) {
            $this->LabelModel = new LabelModel();
        }
        return $this->LabelModel;
    }

    /**
     * 添加/修改记录
     * @param $id
     * @param $name
     * @param $size
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id, $name, $size)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['name'] = $name;
        $map['delete'] = 0;
        $result = $this->getLabelModel()->getOneData($map);
        if ($result) {
            throw new \Exception('标签名重复！', FAIL);
        }
        // 添加/修改
        $data['name'] = $name;
        $data['size'] = $size;
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getLabelModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getLabelModel()->addOneData($data);
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
            $result = $this->getLabelModel()->getOneData(['id' => $id]);
            $result['size'] = (string)$result['size'];
        } else {
            $map['delete'] = 0;
            $fields = 'id, name, size, from_unixtime(create_time, \'%Y-%m-%d %H:%i\') as create_time';
            $order  = 'create_time desc';
            $list = $this->getLabelModel()->getMultiData($map,
                $fields,
                $order,
                $page_no,
                $page_size);

            $count = $this->getLabelModel()->getDataCount($map);

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
        return $this->getLabelModel()->updateData($map, $data);
    }

    /**
     * 所有标签统计
     * @return array
     * @throws \think\exception\DbException
     */
    public function getAllLabelStats()
    {
        $sql = 'SELECT `id`, `name`, `size` FROM bs_label WHERE `delete`=0 ORDER BY convert(`name` USING gbk)';
        $result = $this->getLabelModel()->query($sql);

        return [
            'list'  => $result,
            'count' => is_array($result)? count($result) : 0
        ];
    }

    /**
     * 根据标签查文章
     * @param $id
     * @param $page_no
     * @param $page_size
     * @return array
     */
    public function getArticleByLabel($id, $page_no, $page_size)
    {
        return $this->getLabelModel()->getArticleByLabel($id, $page_no, $page_size);
    }

}