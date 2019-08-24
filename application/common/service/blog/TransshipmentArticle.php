<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\TransshipmentArticle as TransshipmentArticleModel;
use app\common\model\blog\TransshipmentArticleContent as TransshipmentArticleContentModel;
use think\Db;


class TransshipmentArticle
{
    /**
     * @var TransshipmentArticleModel
     */
    public $TransshipmentArticleModel;

    /**
     * @var TransshipmentArticleModel
     */
    public $TransshipmentArticleContentModel;

    /**
     * Article constructor
     */
    public function __construct()
    {

    }

    /**
     * getArticleTransshipmentModel
     */
    public function getArticleTransshipmentModel()
    {
        if(empty($this->TransshipmentArticleModel)) {
            $this->TransshipmentArticleModel = new TransshipmentArticleModel();
        }
        return $this->TransshipmentArticleModel;
    }

    /**
     * getArticleTransshipmentContentModel
     */
    public function getTransshipmentArticleContentModel()
    {
        if(empty($this->TransshipmentArticleContentModel)) {
            $this->TransshipmentArticleContentModel = new TransshipmentArticleContentModel();
        }
        return $this->TransshipmentArticleContentModel;
    }

    /**
     * 新增/修改记录
     *
     * @param int $id
     * @param $title
     * @param $author
     * @param $link
     * @param $release
     * @param $content_md
     * @return bool
     */
    public function save($id=0,
                         $title,
                         $author,
                         $link,
                         $release,
                         $content_md)
    {
        // 文章数据
        $data['title']   = $title;
        $data['author']  = $author;
        $data['link']    = $link;
        $data['release'] = $release;

        // 使用事务闭包
        Db::transaction(function() use($id, $data, $content_md) {
            if ($id) {
                $map['id'] = $id;
                $data['edit_time'] = time();
                $this->getArticleTransshipmentModel()->updateData($map, $data);

                $field = 'transshipment_article_content_id';
                $content_id = $this->getArticleTransshipmentModel()->getDataField($map, $field);
                $map['id'] = $content_id;
                $c_data['content_md'] = $content_md;
                $c_data['edit_time'] = time();
                $this->getTransshipmentArticleContentModel()->updateData($map, $c_data);
            } else {
                $c_data['content_md'] = $content_md;
                $c_data['create_time'] = time();
                $id = $this->getTransshipmentArticleContentModel()->addOneData($c_data);

                $data['create_time'] = time();
                $data['transshipment_article_content_id'] = $id;
                $this->getArticleTransshipmentModel()->addOneData($data);
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
     * @param $back_ground
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function get($id,
                        $page_no,
                        $page_size,
                        $title,
                        $begin_time,
                        $end_time,
                        $back_ground)
    {
        if ($id) {
            $result = $this->getArticleTransshipmentModel()->getArticleDetail($id);
        } else {
            if ($title)              $map['tr.title']       = ['like', "%$title%"];
            if ($begin_time)         $map['tr.create_time'] = ['gt', $begin_time];
            if ($end_time)           $map['tr.create_time'] = ['gt', $end_time];
            // if (empty($back_ground)) $map['tr.release']     = 1;
            $map['tr.delete'] = 0;
            $articles  = $this->getArticleTransshipmentModel()->getArticleList($map, $page_no, $page_size);

            // 文字内容过滤标点
//            array_walk($articles['list'], function(&$value) {
//                $value['content'] = strip_tags($value['content']);
//                // 文字大于100个字符，去掉末尾标点，再在后面添加省略号
//                if (100 <= mb_strlen($value['content'], 'utf8')) {
//                    $char = ['、', '，', ',', '：', '。', ':', '!', '！', '?', '？','(', ')', '（', '）', '{', '}', '【', '】', '[', ']'];
//                    $last_char = mb_substr(trim($value['content']), mb_strlen($value['content'], 'utf8')-1, 1, 'utf8');
//                    if (in_array($last_char, $char)) {
//                        $value['content'] = mb_substr(trim($value['content']), 0, mb_strlen($value['content'], 'utf8')-1 ,'utf8');
//                    }
//                    $value['content'] = $value['content'] . ' ...';
//                }
//            });

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
        return $this->getArticleTransshipmentModel()->updateData($map, $data);
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
        return $this->getArticleTransshipmentModel()->updateData($map, $data);
    }

    /**
     * 文章详情
     *
     * @param $id
     * @return false
     * @throws \think\exception\DbException
     */
    public function getArticleDetail($id)
    {
        return $this->getArticleTransshipmentModel()->getArticleDetail($id);

    }

}