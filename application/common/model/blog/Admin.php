<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Admin extends Common
{

    public function getRoleByAdminIds($admin_ids)
    {
        $map['ar.admin_id'] = ['in', $admin_ids];
        $map['r.delete'] = 0;
        $field = 'ar.role_id, ar.admin_id, r.name';
        return $this
            ->table('bs_account_role')
            ->alias('ar')
            ->where($map)
            ->field($field)
            ->join('bs_role r', 'r.id = ar.role_id', 'left')
            ->select();
    }

}