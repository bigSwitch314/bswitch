<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 上午10:47
 */

namespace app\common\model\blog;

use app\common\model\Common;


class ArticleLabel extends Common
{
    /**
     * 根据文章ID查出标签
     * @param $article_ids
     * @return false
     * @throws \think\exception\DbException
     */
    public function getLabelName($article_ids)
    {
        $map['al.article_id'] = ['in', $article_ids];
        $fields = 'al.article_id, group_concat(la.name) as label_name';

        return $this
            ->alias('al')
            ->where($map)
            ->field($fields)
            ->join('bs_label la', "la.id=al.label_id and la.delete=0", 'left')
            ->group('al.article_id')
            ->select();
    }

}