<?php
namespace app\blog\controller;

use app\common\controller\Common;
use app\common\service\blog\MetaData as MetaDataService;


class AuthorIntroduction extends Common
{
    /**
     * MetaData constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 添加记录
     */
    public function add()
    {
        try {
            $param      = $this->param;
            $type       = $param['type'];
            $text_data  = $param['text_data'];

            check_number_range($type, range(1, 50));
            check_string($text_data);

            $status = (new MetaDataService())->save($id=0, $type, $text_data, $is_json_data=false);
            if (false === $status) {
                throw new \Exception('添加失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '添加成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 修改记录
     */
    public function edit()
    {
        try {
            $param     = $this->param;
            $id        = $param['id'];
            $type      = $param['type'];
            $text_data = $param['text_data'];

            check_number($id);
            check_number_range($type, range(1, 50));
            check_string($text_data);

            $status = (new MetaDataService())->save($id, $type, $text_data, $is_json_data=false);
            if (false === $status) {
                throw new \Exception('编辑失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '编辑成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 获取记录
     */
    public function get()
    {
        try {
            $param = $this->param;
            $type    = $param['type'];

            check_number_range($type, range(1, 50));

            $result = (new MetaDataService())->get($type);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $result ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 删除记录
     */
    public function delete()
    {
        try {
            $param = $this->param;
            $id    = $param['id'];

            if (false === strpos($id, ',')) {
                check_number($id, true);
            } else {
                $id = array_filter(explode(',', $id));
                check_not_null($id);
            }

            $status = (new MetaDataService())->delete($id);

            if (false === $status) {
                throw new \Exception('删除失败！', FAIL);
            }

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '删除成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

}



