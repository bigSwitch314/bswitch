<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class OspUpdateLog extends Common
{
    /**
     * 文章详情（后台）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getArticleDetail($id)
    {
        $map['ta.id']     = $id;
        $map['ta.delete'] = 0;
        $fields = 'ta.id, ta.title, ta.author, ta.link, ta.release, tac.content_md, from_unixtime(ta.create_time, \'%Y-%m-%d\') as create_time,
                   if(ta.edit_time, from_unixtime(ta.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';

        return $this
            ->alias('ta')
            ->where($map)
            ->field($fields)
            ->join('bs_transshipment_article_content tac', "ta.transshipment_article_content_id=tac.id", 'left')
            ->find();
    }

    /**
     * 转载文章列表（后台）
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleList($map, $page_no, $page_size)
    {
        $fields = 'tr.id, tr.title, tr.author, tr.link, tr.release, from_unixtime(tr.create_time, \'%Y-%m-%d %H:%i\') as create_time,
                   if(tr.edit_time, from_unixtime(tr.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
        $order  = 'tr.create_time desc';

        $count = $this
            ->alias('tr')
            ->where($map)
            ->count();

        $list = $this
            ->alias('tr')
            ->where($map)
            ->field($fields)
            ->order($order)
            ->page($page_no, $page_size)
            ->select();

        return [
            'count' => $count,
            'list'  => $list
        ];
    }

    /**
     * 文章详情（前台）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getDetail($id)
    {
        $map['tr.id'] = $id;
        $fields = 'tr.id, tr.title, tr.category_id, ca.name as category_name, group_concat(la.id, \'-\', la.name) as label, tr.content_html, tr.read_number, 
                   from_unixtime(tr.create_time, \'%Y-%m-%d\') as create_time';

        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_article_label al', "al.article_id=tr.id", 'left')
            ->join('bs_label la', "la.id=al.label_id", 'left')
            ->join('bs_category ca', "ca.id=tr.category_id", 'left')
            ->group('tr.id')
            ->find();
    }

}