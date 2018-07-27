<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:39
 */

namespace app\common\model\admin;

use app\common\model\Common;


class Menu extends Common
{
    /**
     * 获取菜单导航列表
     */
    public function getMenu()
    {
        $map['me.deleted'] = 0;
        $fields = 'me.id, me.name, me.sort, no.name as no_name, no2.name as no2_name, no3.name as no3_name,
                   no.title as no_title, no.status as no_status, no.menu as no_menu, no.level as no_level, no.sort as no_sort';

        return $this
            ->alias('me')
            ->field($fields)
            ->where($map)
            ->join('node no', 'no.gid=me.id and no.status=1 and no.deleted=0 and no.menu=1', 'left')
            ->join('node no2', 'no2.id=no.pid', 'left')
            ->join('node no3', 'no3.id=no2.pid', 'left')
            ->order('me.sort asc, no.sort asc')
            ->select();
    }

}