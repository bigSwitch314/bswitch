<?php
namespace app\abace\controller;

use app\common\controller\Common;
use app\common\service\abace\Customer as CustomerService;
use app\common\tools\SphinxClient;


class Customer extends Common
{
    /**
     * Admin constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 获取模拟数据
     */
    public function getTestData()
    {
        try {


            (new CustomerService())->getTestData();

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }

    }

    /**
     * Sphinx测试
     */
    public function testSphinx()
    {
        try {
            $Sphinx = SphinxClient::getInstance(); // 单例模式
            $Sphinx->setMatchMode(SPH_MATCH_EXTENDED2);
            $Sphinx->SetLimits(0, 1000);
            $result = $Sphinx->query("@cat *cat-100000*", 'customer');
            dump($result);
            dump(implode(',',array_keys($result['matches'])));
            exit;

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }

    }
    
    /**
     * 添加记录
     */
    public function add()
    {
        try {
            $param           = $this->param;
            $cat             = $param['cat'];
            $first_name      = $param['first_name'];
            $middle_name     = $param['middle_name'];
            $last_name       = $param['last_name'];
            $name            = $param['name'];
            $title           = $param['title'];
            $company         = $param['company'];
            $mailing_address = $param['address'];
            $phone           = $param['phone'];
            $industry        = $param['industry'];
            $tag             = $param['tag'];

            check_string($cat);

            $status = (new CustomerService())->save($id=0,
                $cat,
                $first_name,
                $middle_name,
                $last_name,
                $name,
                $title,
                $company,
                $mailing_address,
                $phone,
                $industry,
                $tag);

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
            $param           = $this->param;
            $id              = $param['id'];
            $cat             = $param['cat'];
            $first_name      = $param['first_name'];
            $middle_name     = $param['middle_name'];
            $last_name       = $param['last_name'];
            $name            = $param['name'];
            $title           = $param['title'];
            $company         = $param['company'];
            $mailing_address = $param['address'];
            $phone           = $param['phone'];
            $industry        = $param['industry'];
            $tag             = $param['tag'];

            check_string($cat);

            $status = (new CustomerService())->save($id,
                $cat,
                $first_name,
                $middle_name,
                $last_name,
                $name,
                $title,
                $company,
                $mailing_address,
                $phone,
                $industry,
                $tag);

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
            $param     = $this->param;
            $id        = $param['id'];
            $type      = $param['type'];
            $keyword   = $param['keyword'];
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$id, $page_no, $page_size], false);
            check_string($keyword, false);
            check_number_range($type, [1, 2, 3, 4], false);

            $result = (new CustomerService())->get($id,
                $type,
                $keyword,
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

            $status = (new CustomerService())->delete($id);

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

    /**
     * 获取tag列表
     */
    public function getTagList()
    {
        try {
            $param     = $this->param;
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$page_no, $page_size]);

            $data = (new CustomerService())->getTagList($page_no, $page_size);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

    /**
     * 获取company列表
     */
    public function getCompanyList()
    {
        try {
            $param     = $this->param;
            $page_no   = $param['page_no'];
            $page_size = $param['page_size'];

            check_number([$page_no, $page_size]);

            $data = (new CustomerService())->getCompanyList($page_no, $page_size);

            $this->ajaxReturn([
                'errcode' => SUCCESS,
                'errmsg'  => '获取成功!',
                'data'    => $data ?: [],
            ]);

        } catch (\Exception $e) {
            $this->ajaxReturn([
                'errcode' => $e->getCode(),
                'errmsg'  => $e->getMessage()
            ]);
        }
    }

}



