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
     * @param $type
     * @param $release
     * @param $content_md
     * @param $content_html
     * @return bool|false|int|mixed
     */
    public function save($id,
                         $title,
                         $category_id,
                         $label_ids,
                         $type,
                         $release,
                         $content_md,
                         $content_html)
    {
        // 文章数据
        $data['title']        = $title;
        $data['category_id']  = $category_id;
        $data['label_ids']    = $label_ids ?: '';
        $data['type']         = $type;
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
            } else {
                $this->getArticleLabelModel()->deleteData(['article_id'=>$id]);
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
     * @param $type
     * @param $time_type
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
                        $category_id,
                        $label_ids,
                        $type,
                        $time_type,
                        $back_ground)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getArticleModel()->getArticleDetail($id);
            if ($result['label_ids']) {
                $result['label_ids'] = explode(',',  $result['label_ids']);
                array_walk($result['label_ids'], function(&$val) {
                    $val = (int)$val;
                });
            } else {
                $result['label_ids'] = [];
            }
        } else {
            $map['ar.delete'] = 0;
            if ($title)              $map['ar.title']       = ['like', "%$title%"];
            if ($label_ids)          $map['al.label_id']    = ['in', $label_ids];
            if ($type)               $map['type']           = $type;
            if ($category_id)        $map['ar.category_id'] = $category_id;
            if (empty($back_ground)) $map['ar.release']     = 1;

            if ($begin_time && $end_time) {
                $begin_time = strtotime($begin_time);
                $end_time   = strtotime($end_time) + 24*60*60 -1;
                $time_key = $time_type == 1 ? 'ar.create_time' : 'ar.edit_time';
                $map[$time_key] = [['gt', $begin_time], ['lt', $end_time]];
            }

            $articles  = $this->getArticleModel()->getArticleList($map, $page_no, $page_size);

            // 标签搜索，则重写列表中的label_name
            $article_ids = array_column((array)$articles['list'], 'id');
            if ($article_ids && $label_ids) {
                $label = $this->getArticleLabelModel()->getLabelName($article_ids);
                $label = array_column((array)$label, null, 'article_id');
                array_walk($articles['list'], function(&$value) use($label) {
                    $value['label_name'] = $label[$value['id']]['label_name'];
                    // 文字内容标签
                    $value['content'] = strip_tags($value['content']);
                });
            }

            // 文字内容过滤标点
            array_walk($articles['list'], function(&$value) {
                $value['content'] = strip_tags($value['content']);
                // 文字大于100个字符，去掉末尾标点，再在后面添加省略号
                if (100 <= mb_strlen($value['content'], 'utf8')) {
                    $char = ['、', '，', ',', '：', '。', ':', '!', '！', '?', '？','(', ')', '（', '）', '{', '}', '【', '】', '[', ']'];
                    $last_char = mb_substr(trim($value['content']), mb_strlen($value['content'], 'utf8')-1, 1, 'utf8');
                    if (in_array($last_char, $char)) {
                        $value['content'] = mb_substr(trim($value['content']), 0, mb_strlen($value['content'], 'utf8')-1 ,'utf8');
                    }
                    $value['content'] = $value['content'] . ' ...';
                }
                // 标签逗号分隔加空隔
                $value['label_name'] = str_replace(',', ', ', $value['label_name']);
            });

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

    /**
     * 文章详情（前台）
     * @param $id
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function getDetial($id)
    {
        $article = $this->getArticleModel()->getDetail($id);
        if ($article['label']) {
            $label = explode(',', $article['label']);
            foreach ($label as $value) {
                $item = explode('-', $value);
                $label_new[] = [
                    'id' => $item[0],
                    'name' => $item[1],
                ];
            }
            $article['label'] = isset($label_new) ? $label_new : [];
        }

        // 获取上一篇、下一篇文章
        $pre_next = $this->getArticleModel()->getPreNextArticle($id);
        foreach ($pre_next as $value) {
            if (1 == $value['type']) $pre  = $value;
            if (2 == $value['type']) $next = $value;
        }

        return [
            'article' => $article,
            'pre'     => isset($pre)  ? $pre  : '',
            'next'    => isset($next) ? $next : '',
        ];
    }

    /**
     * 文章归档（前台）
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArchive($page_no, $page_size) {
        $map = [
            'delete'  => 0,
            'release' => 1,
        ];
        $fields = 'id, title, from_unixtime(create_time, \'%m-%d\') as date, from_unixtime(create_time, \'%Y\') as year';
        $order  = 'create_time desc';

        $list = $this->getArticleModel()->getMultiData($map,
            $fields,
            $order,
            $page_no,
            $page_size);
        $count = $this->getArticleModel()->getDataCount($map);

        $list[0]['isDisplayYear'] = 1;
        $year = (int)$list[0]['year'];
        foreach ($list as $key => $value) {
            if ($value['isDisplayYear'] === 1) continue;
            if ((int)($value['year']) < $year) {
                $list[$key]['isDisplayYear'] = 1;
                $year = (int)($value['year']);
            } else {
                $list[$key]['isDisplayYear'] = 0;
            }
        }

        return [
            'list'  => $list  ?: [],
            'count' => $count ?: 0,
        ];
    }

    /**
     * 根据分类统计文章
     *
     * @param string $type
     * @return array
     * @throws \think\exception\DbException
     */
    public function getStatByCategory($type='list')
    {
        $result = $this->getArticleModel()->getStatByCategory();
        $temp = $result;
        foreach ($result as $key => $value) {
            foreach ($temp as $k => $v) {
                if ($value['category_id'] == $v['category_pid']) {
                    $result[$key]['article_number'] += $v['article_number'];
                    unset($temp[$k]);
                }
            }
        }

        if ($type == 'tree') {
            // 字段名称修改
            foreach ($result as $key => $value) {
                $result[$key] = [
                    'id' => $value['category_id'],
                    'pid' => $value['category_pid'],
                    'name' => $value['category_name'],
                    'article_number' => $value['article_number'],
                ];
            }

            // 树转换
            return generate_tree($result);
        }

        return array_column((array)$result, null, 'category_id');
    }

    /**
     * 根据标签统计文章
     *
     * @throws \think\exception\DbException
     */
    public function getStatByLabel()
    {
        $result = $this->getArticleModel()->getStatByLabel();

        $label_ids = [];
        foreach ($result as $value) {
            if ($value) {
                $label_ids_arr  = explode(',', $value['label_ids']);
                $label_ids = array_merge($label_ids, $label_ids_arr);
            }
        }

        return array_count_values($label_ids);
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
     * @param $type
     * @param $time_type
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function getFg($id,
                        $page_no,
                        $page_size,
                        $title,
                        $begin_time,
                        $end_time,
                        $category_id,
                        $label_ids,
                        $type,
                        $time_type)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getArticleModel()->getArticleDetailFg($id);
            if ($result['label_ids']) {
                $result['label_ids'] = explode(',',  $result['label_ids']);
                array_walk($result['label_ids'], function(&$val) {
                    $val = (int)$val;
                });
            } else {
                $result['label_ids'] = [];
            }

            // 获取上一篇、下一篇文章
            $pre_next = $this->getArticleModel()->getPreNextArticle($id);
            foreach ($pre_next as $value) {
                if (1 == $value['type']) $pre  = $value;
                if (2 == $value['type']) $next = $value;
            }
            $result['pre']  = isset($pre)  ? $pre  : '';
            $result['next'] = isset($next)  ? $next  : '';

        } else {
            $map['ar.delete']  = 0;
            $map['ar.release'] = 1;
            if ($title)              $map['ar.title']       = ['like', "%$title%"];
            if ($label_ids)          $map['al.label_id']    = ['in', $label_ids];
            if ($type)               $map['type']           = $type;
            if ($category_id) {
                $all_chd_id = $this->getArticleModel()->getAllChdId($category_id);
                $map['ar.category_id'] = ['in', $all_chd_id];
            }

            if ($begin_time && $end_time) {
                $begin_time = strtotime($begin_time);
                $end_time   = strtotime($end_time) + 24*60*60 -1;
                $time_key = $time_type == 1 ? 'ar.create_time' : 'ar.edit_time';
                $map[$time_key] = [['gt', $begin_time], ['lt', $end_time]];
            }

            $articles  = $this->getArticleModel()->getArticleListFg($map, $page_no, $page_size);

            // 标签搜索，则重写列表中的label_name
            $article_ids = array_column((array)$articles['list'], 'id');
            if ($article_ids) {
                $label = $this->getArticleLabelModel()->getLabelName($article_ids);
                $label = array_column((array)$label, null, 'article_id');
                array_walk($articles['list'], function(&$value) use($label) {
                    $value['label_name'] = $label[$value['id']]['label_name'];
                    // 文字内容标签
                    $value['content'] = strip_tags($value['content']);
                });
            }

            // 列表处理
            array_walk($articles['list'], function(&$value) {
                $value['content'] = strip_tags($value['content']);
                // 文字大于100个字符，去掉末尾标点，再在后面添加省略号
                if (120 <= mb_strlen($value['content'], 'utf8')) {
                    $char = ['、', '，', ',', '：', '。', ':', '!', '！', '?', '？','(', ')', '（', '）', '{', '}', '【', '】', '[', ']'];
                    $last_char = mb_substr(trim($value['content']), mb_strlen($value['content'], 'utf8')-1, 1, 'utf8');
                    if (in_array($last_char, $char)) {
                        $value['content'] = mb_substr(trim($value['content']), 0, mb_strlen($value['content'], 'utf8')-1 ,'utf8');
                    }
                    $value['content'] = $value['content'] . ' ...';
                }
                // 标签逗号分隔加空隔
                $value['label_name'] = str_replace(',', ', ', $value['label_name']);
            });

            $result = [
                'list'  => $articles['list']  ?: [],
                'count' => $articles['count'] ?: 0
            ];
        }
        return $result;
    }

}