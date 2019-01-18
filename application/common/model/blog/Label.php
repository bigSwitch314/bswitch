<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class Label extends Common
{
    /**
     * 根据标签查文章
     * @param $id
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleByLabel($id, $page_no, $page_size) {
        $map = [
            'la.id'  => $id,
            'la.delete' => 0,
            'ar.release' => 1,
            'ar.delete' => 0,
        ];
        $fields = 'ar.id, ar.title, from_unixtime(ar.create_time, \'%m-%d\') as create_time';
        $order  = 'ar.create_time desc';

        $list = $this
            ->alias('la')
            ->field($fields)
            ->where($map)
            ->join('bs_article_label al', "al.label_id=la.id", 'left')
            ->join('bs_article ar', "ar.id=al.article_id", 'left')
            ->order($order)
            ->page($page_no, $page_size)
            ->select();

        $count = $this
            ->alias('la')
            ->where($map)
            ->join('bs_article_label al', "al.label_id=la.id", 'left')
            ->join('bs_article ar', "ar.id=al.article_id", 'left')
            ->order($order)
            ->count();

        return [
            'list'  => $list,
            'count' => $count,
        ];
    }

}