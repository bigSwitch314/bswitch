<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\Category as CategoryModel;
use app\common\service\blog\Article as ArticleService;


class Category
{
    /**
     * @var CategoryModel
     */
    public $CategoryModel;

    /**
     * @var ArticleService
     */
    public $ArticleService;

    /**
     * Category constructor
     */
    public function __construct()
    {

    }

    /**
     * getCategoryModel
     */
    public function getCategoryModel()
    {
        if(empty($this->CategoryModel)) {
            $this->CategoryModel = new CategoryModel();
        }
        return $this->CategoryModel;
    }

    /**
     * getArticleService
     */
    public function getArticleService()
    {
        if(empty($this->ArticleService)) {
            $this->ArticleService = new ArticleService();
        }
        return $this->ArticleService;
    }

    /**
     * 添加/修改记录
     * @param $id
     * @param $name
     * @param $pid
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id, $name, $pid)
    {
        // 名称不能重名
        if ($id) $map['id'] = ['neq', $id];
        $map['name'] = $name;
        $map['delete'] = 0;
        $result = $this->getCategoryModel()->getOneData($map);
        if ($result) {
            throw new \Exception('标签名重复！', FAIL);
        }
        // 添加/修改
        $data['name'] = $name;
        $data['pid']  = $pid;
        if ($id) {
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getCategoryModel()->updateData($map, $data);
        } else {
            $data['create_time'] = time();
            return $this->getCategoryModel()->addOneData($data);
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
            $result = $this->getCategoryModel()->getOneData(['id' => $id]);
        } else {
            $map['ca.delete'] = 0;
            $category_result = $this->getCategoryModel()->getCategoryList($map, $page_no, $page_size);

            $stat = $this->getArticleService()->getStatByCategory();
            array_walk($category_result['list'], function(&$value) use($stat) {
                $value['article_number'] = 0;
                if(array_key_exists($value['id'], $stat)) {
                    $value['article_number'] = $stat[$value['id']]['article_number'];
                }
            });

            $result = [
                'list'  => $category_result['list']  ?: [],
                'count' => $category_result['count'] ?: 0
            ];
        }

        return $result;
    }

    /**
     * 删除记录
     *
     * @param $id
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function delete($id)
    {
        $status = true;
        $names = [];
        $category_children = $this->getCategoryModel()->getCategoryChildren($id);
        if ($category_children) {
            $ids = array_column((array)$category_children, 'id');
            $names = array_column((array)$category_children, 'name');
            $id = array_diff($id, $ids);
        }

        if ($id) {
            $map['id'] = ['in', $id];
            $data['delete'] = 1;
            $data['edit_time'] = time();
            $status = $this->getCategoryModel()->updateData($map, $data);
        }

        return [
            'status' => $status,
            'not_delete_category'  => $names,
        ];
    }

    /**
     * 获取一级分类
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function getLevelOneCategory()
    {
        $map['pid']    = ['eq', 0];
        $map['delete'] = 0;
        $fields = 'id, name';
        $result = $this->getCategoryModel()->getMultiData($map, $fields);
        return [
            'list'  => $result,
            'count' => count((array)$result),
        ];
    }

    /**
     * 根据分类查文章
     * @param $id
     * @param $page_no
     * @param $page_size
     * @return array
     * @throws \think\exception\DbException
     */
    public function getArticleByCategory($id, $page_no, $page_size)
    {
        $map = [
            'category_id' => $id,
            'release'     => 1,
            'delete'      => 0,
        ];
        $table  = 'bs_article';
        $fields = 'id, title, from_unixtime(create_time, \'%m-%d\') as create_time';
        $order  = 'create_time desc';

        $list = $this->getCategoryModel()->getTableMultiData($table,
            $map,
            $fields,
            $order,
            $page_no,
            $page_size);

        $count = $this->getCategoryModel()->getTableDataCount($table, $map);

        return [
            'list'  => $list,
            'count' => $count,
        ];
    }

    /**
     * 分类统计(Fg)
     *
     * @return array
     * @throws \think\exception\DbException
     */
    public function getStat()
    {
        $result = $this->getCategoryModel()->getStats();
        $temp = $result;
        foreach ($result as $key => $value) {
            foreach ($temp as $k => $v) {
                if ($value['id'] == $v['pid']) {
                    $result[$key]['article_number'] += $v['article_number'];
                    unset($temp[$k]);
                }
            }
        }

        return generate_tree($result);
    }
}