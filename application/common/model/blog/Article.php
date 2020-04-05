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
     * 文章详情（后台）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getArticleDetail($id)
    {
        $map['ar.id']     = $id;
        $map['ar.delete'] = 0;
        $fields = 'ar.id, ar.title, ar.category_id, group_concat(al.label_id) as label_ids, ar.content_md, ar.content_html, ar.read_number, ar.type, ar.release, 
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
     * 文章列表（后台）
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleList($map, $page_no, $page_size)
    {
        $fields = 'ar.id, ar.title, left(content_html, 130) as content, ar.category_id, ca.name as category_name ,ifnull(group_concat(la.name), "—") as label_name, ar.read_number,
                   ar.type, ar.release,from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
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

    /**
     * 文章详情（前台）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getDetail($id)
    {
        $map['ar.id'] = $id;
        $fields = 'ar.id, ar.title, ar.category_id, ca.name as category_name, group_concat(la.id, \'-\', la.name) as label, ar.content_html, ar.read_number, 
                   from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time';

        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_article_label al', "al.article_id=ar.id", 'left')
            ->join('bs_label la', "la.id=al.label_id", 'left')
            ->join('bs_category ca', "ca.id=ar.category_id", 'left')
            ->group('ar.id')
            ->find();
    }

    /**
     * 查询某篇文章的上一篇、下一篇文章
     * @param $id
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    function getPreNextArticle($id)
    {
        // type标识上一篇、下一篇文章（1上一篇文章，2下一篇文章）
        $sql_nex = "(select `id`,  `title`, 1 type from bs_article where `delete`=0 and `release`=1 and `create_time` > (select `create_time` from bs_article where `id`={$id}) order by `create_time` asc  limit 1)";
        $sql_pre = "(select `id`,  `title`, 2 type from bs_article where `delete`=0 and `release`=1 and `create_time` < (select `create_time` from bs_article where `id`={$id}) order by `create_time` desc limit 1)";
        return $this->query($sql_nex . ' union ' . $sql_pre);
    }

    /**
     * 根据分类统计文章
     *
     * @throws \think\exception\DbException
     */
    public function getStatByCategory()
    {
        $map['ar.delete'] = 0;
        $fields = 'ar.category_id, ca.name as category_name, ca.pid as category_pid, count(ar.id) as article_number';

        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca', 'ca.id=ar.category_id and ca.delete=0', 'left')
            ->group('ar.category_id')
            ->select();
    }

    /**
     * 根据标签统计文章
     *
     * @throws \think\exception\DbException
     */
    public function getStatByLabel()
    {
        $map['delete'] = 0;
        $fields = 'label_id';

        return $this
            ->table('bs_article_label')
            ->alias('al')
            ->where($map)
            ->field($fields)
            ->join('bs_article ar', 'ar.id=al.article_id and ar.delete=0 and ar.release=1', 'left')
            ->select();
    }

    /**
     * 文章详情（前台）
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getArticleDetailFg($id)
    {
        $map['ar.id']     = $id;
        $map['ar.delete'] = 0;
        $fields = 'ar.id, ar.title, ar.category_id, ca.name as category_name, ifnull(ca2.name, "") as parent_category_name, ifnull(ca2.id, "") as parent_category_id, group_concat(al.label_id) as label_ids, 
                   ar.content_md, ar.content_html, ar.read_number, ar.type, ar.release, from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, group_concat(la.name) as label_names, 
                   if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';

        return $this
            ->alias('ar')
            ->where($map)
            ->field($fields)
            ->join('bs_category ca', 'ca.id=ar.category_id and ca.delete=0', 'left')
            ->join('bs_category ca2', 'ca2.id=ca.pid and ca2.delete=0', 'left')
            ->join('bs_article_label al', "al.article_id=ar.id", 'left')
            ->join('bs_label la', "la.id=al.label_id", 'left')
            ->group('ar.id')
            ->find();
    }

    /**
     * 文章列表（前台）
     * @param $map
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleListFg($map, $page_no, $page_size)
    {
        $fields = 'ar.id, ar.title, ar.content_html as content, ar.category_id, ca.name as category_name, ifnull(ca2.name, "") as parent_category_name, ifnull(ca2.id, "") as parent_category_id, ifnull(group_concat(la.name), "—") as label_name,
                   ar.read_number, ar.type, ar.release,from_unixtime(ar.create_time, \'%Y-%m-%d\') as create_time, if(ar.edit_time, from_unixtime(ar.edit_time, \'%Y-%m-%d\'), \'—\') as edit_time';
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
            ->join('bs_category ca2', 'ca2.id=ca.pid and ca2.delete=0', 'left')
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

    /**
     * 用存储过程获取分类下所有子分类id
     *
     * @param $id
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getAllChdId($id)
    {
        $sql = "select id from bs_category where FIND_IN_SET(id, getAllChdID($id))";
        $result = $this->query($sql);
        return array_column($result, 'id');
    }

    /**
     * 统计文章分类标签数量
     *
     * @return mixed
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     */
    public function getAclStat()
    {
        $sql_article = "select count('id') as stat from bs_article where `delete`=0";
        $sql_category = "select count('id') as stat from bs_category where `delete`=0";
        $sql_label = "select count('id') as stat from bs_label where `delete`=0";
        return $this->query($sql_article . ' union ' . $sql_category . ' union ' . $sql_label);
    }

}