<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/6/28
 * Time: 下午11:37
 */

namespace app\common\model;

class UserBus extends Common
{
    public function stringConditionQuery()
    {
        $map['user_id'] = ['gt', 10];
        $string = 'bus_id=1 and marketers=0';
        return $this->where($map)
            ->where($string)
            ->field('bus_id, user_id, username, marketers')
            ->fetchSql()
            ->select();
    }

}