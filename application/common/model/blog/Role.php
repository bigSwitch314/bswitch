<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Role extends Common
{
     public function getAdminByRoleIds($role_ids)
     {
         $map['ar.role_id'] = ['in', $role_ids];
         $map['a.delete'] = 0;
         $field = 'ar.role_id, ar.admin_id, a.username';
         return $this
             ->table('bs_account_role')
             ->alias('ar')
             ->where($map)
             ->field($field)
             ->join('bs_admin a', 'a.id = ar.admin_id', 'left')
             ->select();
     }

    /**
     * 查询二级节点
     *
     * @throws \think\exception\DbException
     */
     public function getNodeLevel1()
     {
         $map['n.delete'] = 0;
         $map['n.pid'] = 0;
         $field = 'n.id, n.name, -1*n.group_id as pid, ifnull(m.sort, 1000) as sort';

         return $this
             ->table('bs_node')
             ->alias('n')
             ->where($map)
             ->field($field)
             ->join('bs_menu m', 'm.id = n.group_id', 'left')
             ->select();
     }

}