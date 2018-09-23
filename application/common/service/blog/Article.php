<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Article as ArticleModel;


class Article
{
    /**
     * @var ArticleModel
     */
    public $ArticleModel;

    /**
     * Article constructor
     */
    public function __construct()
    {

    }

    /**
     * getArticleModel
     */
    public function getArticleModel()
    {
        if(empty($this->ArticleModel)) {
            $this->ArticleModel = new ArticleModel();
        }
        return $this->ArticleModel;
    }

    /**
     * @param $id
     * @param $title
     * @param $category_id
     * @param $label_ids
     * @param $release
     * @param $content_md
     * @param $content_html
     * @return bool|false|int|mixed
     */
    public function save($id,
                         $title,
                         $category_id,
                         $label_ids,
                         $release,
                         $content_md,
                         $content_html)
    {
        $data['title']        = $title;
        $data['category_id']  = $category_id;
        $data['label_ids']    = $label_ids ?: '';
        $data['release']      = $release;
        $data['content_md']   = $content_md;
        $data['content_html'] = $content_html;
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getArticleModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getArticleModel()->addOneData($data);
        }
    }

    /**
     * 获取记录
     * @param $id
     * @param $page_no
     * @param $page_size
     * @return false|mixed
     * @throws \think\exception\DbException
     */
    public function get($id, $page_no, $page_size)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getArticleModel()->getOneData(['id' => $id]);
            $result['label_ids'] = explode(',',  $result['label_ids']);
            array_walk($result['label_ids'], function(&$val) {
                $val = (int)$val;
            });
        } else {
            $list  = $this->getArticleModel()->getArticleList($page_no, $page_size);
            $count = $this->getArticleModel()->getDataCount(['delete'=>0]);

            $result = [
                'list' => $list ?: [],
                'count' => $count ?: 0
            ];
        }
        return $result;
    }

    /**
     * 删除记录
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $map['id'] = ['in', $id];
        $data['delete'] = 1;
        $data['edit_time'] = time();
        return $this->getArticleModel()->updateData($map, $data);
    }

    /**
     * 修改文章发布状态
     * @param $id
     * @param $release
     * @return bool|false|int
     */
    public function changeReleaseStatus($id, $release)
    {
        $map['id'] = $id;
        $data['release'] = $release;
        $data['edit_time'] = time();
        return $this->getArticleModel()->updateData($map, $data);
    }

}