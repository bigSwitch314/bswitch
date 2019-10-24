<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Menu extends Common
{
    public function getList()
    {
        $map['m.delete'] = 0;
        $fields = 'm.id, m.name, m.sort, m.pid, m.create_time, ifnull(m2.name, \'顶级\') as pName';

        return $this
            ->alias('m')
            ->where($map)
            ->field($fields)
            ->join('bs_menu m2', "m2.id=m.pid", 'left')
            ->select();
    }

}