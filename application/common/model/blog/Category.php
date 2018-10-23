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
     * 所有分类统计
     * @throws \think\exception\DbException
     */
    public function getAllCategoryStats()
    {
        $map['ca.delete'] = 0;
        $fields = 'ca.id, ca.name, count(ar.id) as article_number';
        $sub_sql = $this->alias('ca')
            ->field($fields)
            ->where($map)
            ->join('bs_article ar', 'ar.category_id=ca.id and ar.delete=0 and ar.release=1', 'left')
            ->group('ca.id')
            ->select(false);
        // 根据英文字母A-Z排序
        return $this->query('select ta.* from (' . $sub_sql . ') ta  order by convert(ta.name using gbk)');
    }

}