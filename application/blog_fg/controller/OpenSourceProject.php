<?php
namespace app\blog_fg\controller;

use app\common\controller\CommonNotToken;
use app\common\service\blog\OpenSourceProject as OpenSourceProjectService;


class OpenSourceProject extends CommonNotToken
{
    /**
     * OpenSourceProject constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取记录
     */
    public function get()
    {
        try {
            $param      = $this->param;
            $id         = $param['id'];
            $page_no    = $param['page_no'];
            $page_size  = $param['page_size'];
            $name       = $param['name'];
            $begin_time = $param['begin_time'];
            $end_time   = $param['end_time'];
            $time_type  = $param['time_type'];

            check_number([$id, $page_no, $page_size], false);
            check_date([$begin_time, $end_time], false);
            check_string([$name], false);
            check_number_range($time_type, [1, 2], false);

            $result = (new OpenSourceProjectService())->get(
                $id,
                $page_no,
                $page_size,
                $name,
                $begin_time,
                $end_time,
                $time_type);

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
     * 获取记录
     */
    public function getUpdateLog()
    {
        try {
            $param     = $this->param;
            $id        = $param['id'];
            $osp_id    = $param['osp_id'];
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $osp_id, $page_no, $page_size], false);
            check_has_one($id, $osp_id);

            $result = (new OpenSourceProjectService())->getUpdateLog(
                $id,
                $osp_id,
                $page_no,
                $page_size);

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

}



