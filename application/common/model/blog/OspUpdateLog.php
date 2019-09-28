<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class OspUpdateLog extends Common
{
    /**
     * 更新日志列表
     *
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getList($map, $page_no, $page_size)
    {
        $fields = 'id, osp_id, version, content, from_unixtime(create_time, \'%Y-%m-%d\') as create_time';
        $order  = 'create_time desc';

        $count = $this->where($map)->count();

        $list = $this
            ->where($map)
            ->field($fields)
            ->order($order)
            ->page($page_no, $page_size)
            ->select();

        return [
            'count' => $count,
            'list'  => $list
        ];
    }

    /**
     * 更新日志详情
     *
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getDetail($id)
    {
        $map['id'] = $id;
        $fields = 'id, osp_id, version, content, from_unixtime(create_time, \'%Y-%m-%d\') as create_time';

        return $this
            ->where($map)
            ->field($fields)
            ->find();
    }

}