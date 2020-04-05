<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Category extends Common
{
    /**
     * 获取分类列表
     *
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategoryList($map, $page_no, $page_size)
    {
        $fields = 'ca.id, ca.name, ca.pid, ifnull(ca2.name, "") as pname, from_unixtime(ca.create_time, \'%Y-%m-%d\') as create_time';
        $order  = 'ca.create_time desc';

        $count = $this
            ->alias('ca')
            ->where($map)
            ->join('bs_category ca2', 'ca2.id=ca.pid and ca2.delete=0', 'left')
            ->count();

        $list = $this
            ->alias('ca')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca2', 'ca2.id=ca.pid and ca2.delete=0', 'left')
            ->order($order)
            ->page($page_no, $page_size)
            ->select();

        return [
            'count' => $count,
            'list'  => $list
        ];

    }

    /**
     * 获取子分类
     *
     * @param $id
     * @return false|\PDOStatement|string|\think\Collection
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getCategoryChildren($id)
    {
        $map['ca.id'] = ['in', $id];
        $map['ca2.delete'] = 0;
        $fields = 'ca.id, ca.name, group_concat(ca2.id) as children';

        return $this
            ->alias('ca')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca2', 'ca2.pid=ca.id', 'left')
            ->group('ca.id')
            ->select();
    }

    /**
     * 分类统计(Fg)
     * @throws \think\exception\DbException
     */
    public function getStats()
    {
        $map['ca.delete'] = 0;
        $fields = 'ca.id, ca.name, ca.pid, ca2.name as pname, count(ar.id) as article_number';
        $sub_sql = $this->alias('ca')
            ->field($fields)
            ->where($map)
            ->join('bs_article ar', 'ar.category_id=ca.id and ar.delete=0 and ar.release=1', 'left')
            ->join('bs_category ca2', 'ca2.id=ca.pid and ca2.delete=0', 'left')
            ->group('ca.id')
            ->select(false);
        // 根据英文字母A-Z排序
        return $this->query('select ta.* from (' . $sub_sql . ') ta  order by convert(ta.name using gbk)');
    }

}