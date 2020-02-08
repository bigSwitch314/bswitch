<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class OpenSourceProject extends Common
{
    /**
     * 开源项目列表
     *
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getList($map, $page_no, $page_size)
    {
        $fields = 'osp.id, osp.name, osp.level, osp.url, osp.version, osp.introduction, osp.release, from_unixtime(osp.create_time, \'%Y-%m-%d\') as create_time,
                   if(osp.edit_time, from_unixtime(osp.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
        $order  = 'osp.create_time desc';

        $count = $this
            ->alias('osp')
            ->where($map)
            ->count();

        $list = $this
            ->alias('osp')
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
     * 开源项目详情）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getDetail($id)
    {
        $map['osp.id'] = $id;
        $map['osp.delete'] = 0;
        $fields = 'osp.id, osp.name, osp.level, osp.url, osp.version, osp.introduction, osp.release, from_unixtime(osp.create_time, \'%Y-%m-%d %H:%i\') as create_time,
                   if(osp.edit_time, from_unixtime(osp.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';

        return $this
            ->alias('osp')
            ->where($map)
            ->field($fields)
            ->find();
    }

}