<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Article as ArticleModel;
use app\common\model\blog\ArticleLabel as ArticleLabelModel;
use think\Db;


class Article
{
    /**
     * @var ArticleModel
     */
    public $ArticleModel;

    /**
     * @var ArticleLabelModel
     */
    public $ArticleLabelModel;

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
     * getArticleLabelModel
     */
    public function getArticleLabelModel()
    {
        if(empty($this->ArticleLabelModel)) {
            $this->ArticleLabelModel = new ArticleLabelModel();
        }
        return $this->ArticleLabelModel;
    }

    /**
     * 新增/修改记录
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
        // 文章数据
        $data['title']        = $title;
        $data['category_id']  = $category_id;
        $data['label_ids']    = $label_ids ?: '';
        $data['release']      = $release;
        $data['content_md']   = $content_md;
        $data['content_html'] = $content_html;

        // 文章标签关联数据
        $data_al = [];
        if ($label_ids) {
            $label_ids = explode(',', $label_ids);
            array_walk($label_ids, function($value) use(&$data_al, $id) {
                $data_al[] = [
                    'article_id' => $id ?: 0,
                    'label_id'   => $value,
                ];
            });
        }

        // 使用事务闭包
        Db::transaction(function() use($id, $data, $data_al) {
            if ($id) {
                unset($map);
                $map['id'] = $id;
                $data['edit_time'] = time();
                $this->getArticleModel()->updateData($map, $data);
            } else {
                $data['create_time'] = time();
                $id = $this->getArticleModel()->addOneData($data);
            }
            if ($data_al) {
                array_walk($data_al, function(&$value) use($id) {
                    $value['article_id'] = $id;
                });
                $this->getArticleLabelModel()->deleteData(['article_id'=>$id]);
                $this->getArticleLabelModel()->addMultiData($data_al);
            }
        });

        return true;
    }

    /**
     * 获取记录
     * @param $id
     * @param $page_no
     * @param $page_size
     * @param $title
     * @param $begin_time
     * @param $end_time
     * @param $category_id
     * @param $label_ids
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function get($id,
                        $page_no,
                        $page_size,
                        $title,
                        $begin_time,
                        $end_time,
                        $category_id,
                        $label_ids)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getArticleModel()->getArticleDetail($id);
            $result['label_ids'] = explode(',',  $result['label_ids']);
            array_walk($result['label_ids'], function(&$val) {
                $val = (int)$val;
            });
        } else {
            if ($title)       $map['ar.title']       = ['like', "%$title%"];
            if ($begin_time)  $map['ar.create_time'] = ['gt', $begin_time];
            if ($end_time)    $map['ar.create_time'] = ['gt', $end_time];
            if ($label_ids)   $map['al.label_id']    = ['in', $label_ids];
            if ($category_id) $map['ar.category_id'] = $category_id;
            $map['ar.delete'] = 0;
            $articles  = $this->getArticleModel()->getArticleList($map, $page_no, $page_size);

            // 标签搜索，则重写列表中的label_name
            $article_ids = array_column((array)$articles['list'], 'id');
            if ($article_ids && $label_ids) {
                $label = $this->getArticleLabelModel()->getLabelName($article_ids);
                $label = array_column((array)$label, null, 'article_id');
                array_walk($articles['list'], function(&$value) use($label) {
                    $value['label_name'] = $label[$value['id']]['label_name'];
                });
            }

            $result = [
                'list'  => $articles['list']  ?: [],
                'count' => $articles['count'] ?: 0
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