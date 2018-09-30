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
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getArticleDetail($id)
    {
        $map['ar.id']     = $id;
        $map['ar.delete'] = 0;
        $fields = 'ar.id, ar.title, ar.category_id, group_concat(al.label_id) as label_ids, ar.content_md, ar.content_html, ar.read_number, ar.release, 
                   from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';

        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_article_label al', "al.article_id=ar.id", 'left')
            ->group('ar.id')
            ->find();
    }

    /**
     * 查询文章列表
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleList($map, $page_no, $page_size)
    {
        $fields = 'ar.id, ar.title, ca.name as category_name , ifnull(group_concat(la.name), "—") as label_name, ar.read_number, ar.release, 
                   from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
        $order  = 'ar.create_time desc';

        $count = $this
            ->alias('ar')
            ->where($map)
            ->join('bs_category ca', 'ca.id=ar.category_id and ca.delete=0', 'left')
            ->join('bs_article_label al', "al.article_id=ar.id", 'left')
            ->join('bs_label la', "la.id=al.label_id and la.delete=0", 'left')
            ->group('ar.id')
            ->count();

        $list = $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca', 'ca.id=ar.category_id and ca.delete=0', 'left')
            ->join('bs_article_label al', "al.article_id=ar.id", 'left')
            ->join('bs_label la', "la.id=al.label_id and la.delete=0", 'left')
            ->order($order)
            ->group('ar.id')
            ->page($page_no, $page_size)
            ->select();

        return [
            'count' => $count,
            'list'  => $list
        ];
    }

}