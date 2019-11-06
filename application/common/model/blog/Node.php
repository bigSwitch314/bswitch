<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Node extends Common
{
    /**
     * 节点列表
     *
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getList($map, $page_no, $page_size)
    {
        $fields = 'n.id, n.name, n.node, n.status, n.menu, n.menu_id, n.group_id, n.pid, ifnull(n2.name, \'顶级\') as pname, ifnull(m.name, \'无\') as group_name';
        $order  = 'n.create_time desc';

        $count = $this
            ->alias('n')
            ->where($map)
            ->where('n.pid=0')
            ->count();

        $list = $this
            ->alias('n')
            ->where($map)
            ->where('n.pid=0')
            ->field($fields)
            ->join('bs_node n2', 'n2.delete = 0 and n2.id=n.pid', 'left')
            ->join('bs_menu m', 'm.id = n.group_id', 'left')
            ->order($order)
            ->page($page_no, $page_size)
            ->select();

        $pids = array_column($list, 'id');
        $map2['n.pid'] = ['in', $pids];
        $children = $this
            ->alias('n')
            ->where($map)
            ->where($map2)
            ->field($fields)
            ->join('bs_node n2', 'n2.delete = 0 and n2.id=n.pid', 'left')
            ->join('bs_menu m', 'm.id = n.group_id', 'left')
            ->select();

        return [
            'count' => $count,
            'list'  => array_merge($list, $children),
        ];
    }

}