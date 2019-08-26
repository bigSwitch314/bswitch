<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\blog;

use app\common\model\blog\OpenSourceProject as OpenSourceProjectModel;
use app\common\model\blog\OspUpdateLog as OspUpdateLogModel;
use think\Db;


class OpenSourceProject
{
    /**
     * @var OpenSourceProjectModel
     */
    public $OpenSourceProjectModel;

    /**
     * @var OpenSourceProjectModel
     */
    public $OspUpdateLogModel;

    /**
     * Article constructor
     */
    public function __construct()
    {

    }

    /**
     * getOpenSourceProjectModel
     */
    public function getOpenSourceProjectModel()
    {
        if(empty($this->OpenSourceProjectModel)) {
            $this->OpenSourceProjectModel = new OpenSourceProjectModel();
        }
        return $this->OpenSourceProjectModel;
    }

    /**
     * getArticleTransshipmentContentModel
     */
    public function getOspUpdateLogModel()
    {
        if(empty($this->OspUpdateLogModel)) {
            $this->OspUpdateLogModel = new OspUpdateLogModel();
        }
        return $this->OspUpdateLogModel;
    }

    /**
     * 新增/修改记录
     * 
     * @param int $id
     * @param $name
     * @param $level
     * @param $url
     * @param $version
     * @param $release
     * @return bool
     */
    public function save($id=0,
                         $name,
                         $level,
                         $url,
                         $version,
                         $release)
    {
        // 入库数据
        $data['name']    = $name;
        $data['level']   = $level;
        $data['url']     = $url;
        $data['version'] = $version;
        $data['release'] = $release;

        // 使用事务闭包
        Db::transaction(function() use($id, $data) {
            if ($id) {
                $map['id'] = $id;
                $data['edit_time'] = time();
                $this->getOpenSourceProjectModel()->updateData($map, $data);
            } else {
                $data['create_time'] = time();
                $this->getOpenSourceProjectModel()->addOneData($data);
            }
        });

        return true;
    }

    /**
     * 获取记录
     *
     * @param $id
     * @param $page_no
     * @param $page_size
     * @param $name
     * @param $begin_time
     * @param $end_time
     * @param $time_type
     * @return array|false
     * @throws \think\exception\DbException
     */
    public function get($id,
                        $page_no,
                        $page_size,
                        $name,
                        $begin_time,
                        $end_time,
                        $time_type)
    {
        if ($id) {
            $result = $this->getOpenSourceProjectModel()->getArticleDetail($id);
        } else {
            $xx_time = $time_type == 1 ? 'osp.create_time' : 'osp.edit_time';
            if ($begin_time) $map[$xx_time]   = ['gt', $begin_time];
            if ($end_time)   $map[$xx_time]   = ['gt', $end_time];
            if ($name)       $map['osp.name'] = ['like', "%name%"];
            $map['osp.delete'] = 0;
            $articles  = $this->getOpenSourceProjectModel()->getList($map, $page_no, $page_size);

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
        return $this->getOpenSourceProjectModel()->updateData($map, $data);
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
        return $this->getOpenSourceProjectModel()->updateData($map, $data);
    }

}