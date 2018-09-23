<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Article extends Common
{
    /**
     * 查询文章列表
     * @param $page_no
     * @param $page_size
     * @return false|\PDOStatement
     * @throws \think\exception\DbException
     */
    public function getArticleList($page_no, $page_size)
    {
        $map['ar.delete'] = 0;
        $fields = 'ar.id, ar.title, ca.name as category_name , ifnull(group_concat(la.name), "—") as label_name, ar.content_md, ar.content_html, ar.read_number, ar.release, 
                   from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
        $order  = 'ar.create_time desc';
        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca', 'ca.id=ar.category_id and ca.delete=0', 'left')
            ->join('bs_label la', "find_in_set(la.id, ar.label_ids) and la.delete=0", 'left')
            ->order($order)
            ->group('ar.id')
            ->page($page_no, $page_size)
            ->select();
    }

}