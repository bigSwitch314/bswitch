<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\abace;

use app\common\model\abace\Customer as CustomerModel;
use app\common\tools\SphinxClient;


class Customer
{
    /**
     * @var CustomerModel
     */
    public $CustomerModel;

    /**
     * Customer constructor
     */
    public function __construct()
    {

    }

    /**
     * getCustomerModel
     */
    public function getCustomerModel()
    {
        if(empty($this->CustomerModel)) {
            $this->CustomerModel = new CustomerModel();
        }
        return $this->CustomerModel;
    }

    /**
     * 添加模拟数据
     */
    public function getTestData()
    {
        echo 'begin_time: ' . date('Y-m-d H:i:s', time()) . PHP_EOL;

        set_time_limit(24 * 60 * 60);
        ini_set('memory_limit', '2G');

        $first_name_arr = ['Arthur', 'Michelle', 'Juanita', 'Marvin', 'Kevin', 'Lindsay', 'Richard', 'Elana', 'William', 'Eugene', 'Mary', 'Margalit', 'Edward', 'Meryle', 'Christine', 'Howard', 'Linda', 'Herbert', 'Jessica', 'Alicia', 'Carolyn', 'Marisa', 'Karen', 'Doreen'];
        $middle_name_arr = ['H.', 'S.', 'R.', 'A.', 'L.', 'E.', 'D.', 'I.', 'null', 'null', 'null', 'null', 'null','null', 'null','null','null','null','null','null', 'null','null', 'null','null','null','null','null','null', 'null','null', 'null','null','null','null','null','null'];
        $last_name_arr = ['Pammenter', 'Bebb', 'Patterson', 'Berenson', 'Park', 'Benedict', 'Lieberman', 'Hamovitch', 'Fealk', 'Larson', 'Mathan', 'Castner', 'Gellman', 'Evans', 'Askins', 'Brinkman', 'Weiner', 'Divento', 'Neill', 'Newberry', 'Perry', 'Nakai', 'Kushida', 'Hatch', 'Yen', 'Mathews', 'Walker', 'Mendonsa', 'Chavez'];
        $title_arr = ['Psychiatry, M.D.', 'Staff Psychologist', 'Psychologist', 'Instructor Psychology', 'Director of Psychiatric Services', 'Psychiatric Staff Nurse', 'Education Psychology Admin and Couns Instructor', 'Chairman Department of Psychiatry', 'Medical Director, Behavioral Health Services', 'Instructor Psychology-Psychology and Education'];

        $generateData = function($id, $start_num, $end_num) use($first_name_arr, $middle_name_arr, $last_name_arr, $title_arr) {
            $i = $start_num;
            while ($i++ <= $end_num) {
                $num  = str_pad($i-1,8,'0',STR_PAD_LEFT );
                $num_2  = str_pad((int)($i-1)/20000,8,'0',STR_PAD_LEFT );
                $data = [
                    'id'          => $id++,
                    'cat'         => 'cat-' . $num,
                    'first_name'  => $first_name_arr[array_rand($first_name_arr, 1)],
                    'middle_name' => $middle_name_arr[array_rand($middle_name_arr, 1)],
                    'last_name'   => $last_name_arr[array_rand($last_name_arr, 1)],
                    'name'        => 'null',
                    'title'       => $title_arr[array_rand($title_arr, 1)],
                    'company'     => 'company-' . $num_2,
                    'mailing_address' => 'address' . $num,
                    'phone'       => 'phone-' . $num,
                    'tag'         => 'tag-' . $num_2,
                    'industry'    => 'null',
                    'delete'      => 0,
                    'edit_time'   => 0,
                    'create_time' => time()
                ];

                $data_new = $data['id'] . "\t" . $data['cat'] . "\t" . $data['first_name'] . "\t" . $data['middle_name'] . "\t"  . $data['last_name'] . "\t" .
                            $data['name'] . "\t" . $data['title'] . "\t" . $data['company'] . "\t"  . $data['mailing_address'] . "\t" .
                            $data['phone'] . "\t"  . $data['industry'] . $data['tag'] . "\t" . "\t"  . $data['delete'] . "\t". $data['edit_time'] . "\t".$data['create_time'] . "\t". "\n" ;

                file_put_contents('/home/www/_6data.txt', $data_new, FILE_APPEND);
            }
        };

        $generateData(10000001, 10000001, 11000000);

        echo 'end_time: ' . date('Y-m-d H:i:s', time()) . PHP_EOL;

        $memory = round(memory_get_usage() / pow(1024, 2), 2) . 'mb';
        echo 'memory: ' . $memory;

        exit;
    }

    /**
     * 获取Sphinx查询结果
     * @param $key
     * @return string
     */
    public function getSphinxQueryIds($key)
    {
        $Sphinx = SphinxClient::getInstance(); // 单例模式
        $Sphinx->setMatchMode(SPH_MATCH_EXTENDED2);
        $Sphinx->SetLimits(0, 1000);
        $result = $Sphinx->query($key, 'customer');

        $ids = '';
        if (isset($result['matches'])) {
            $ids = implode(',',array_keys($result['matches']));
        }

        return $ids;
    }

    /**
     * 添加/修改记录
     * @param $id
     * @param $cat
     * @param $first_name
     * @param $middle_name
     * @param $last_name
     * @param $name
     * @param $title
     * @param $company
     * @param $mailing_address
     * @param $phone
     * @param $industry
     * @param $tag
     * @return bool|false|int|mixed
     * @throws \Exception
     */
    public function save($id,
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
                         $tag)
    {
        $data['cat']             = $cat;
        $data['first_name']      = $first_name      ?: '';
        $data['middle_name']     = $middle_name     ?: '';
        $data['last_name']       = $last_name       ?: '';
        $data['name']            = $name            ?: '';
        $data['title']           = $title           ?: '';
        $data['company']         = $company         ?: '';
        $data['mailing_address'] = $mailing_address ?: '';
        $data['phone']           = $phone           ?: '';
        $data['industry']        = $industry        ?: '';
        $data['tag']             = $tag             ?: '';
        $key = '@cat ' . '*' . $cat . '*' ;

        if ($id) {
            // cat不能重复
            $result = $this->getSphinxQueryIds($key);
            if ($result && $result !== $id) {
                throw new \Exception('cat名不能重复！');
            }
            unset($map);
            $map['id'] = $id;
            $data['edit_time'] = time();
            return $this->getCustomerModel()->updateData($map, $data);
        } else {
            // cat不能重复
            $result = $this->getSphinxQueryIds($key);
            if ($result) {
                throw new \Exception('cat名不能重复！');
            }
            $data['create_time'] = time();
            return $this->getCustomerModel()->addOneData($data);
        }
    }

    /**
     * 获取记录
     * @param $id
     * @param $type
     * @param $keyword
     * @param $page_no
     * @param $page_size
     * @return array|mixed
     * @throws \think\exception\DbException
     */
    public function get($id,
                        $type,
                        $keyword,
                        $page_no,
                        $page_size)
    {
        if ($id) {
            $map['id'] = $id;
            $map['delete'] = 0;
            $result = $this->getCustomerModel()->getOneData(['id' => $id]);

        } else {

            switch ($type) {
                case 1:
                    $key = '@cat ' . '*'. $keyword . '*';
                    break;
                case 2:
                    $key = '@title ' . '*'. $keyword . '*';
                    break;
                case 3:
                    $key = '@industry ' . '*'. $keyword . '*';
                    break;
                case 4:
                    $key = '@tag ' . '*'. $keyword . '*';
                    break;
            }
            $ids = $this->getSphinxQueryIds($key);

            if ($ids) {
                $map['delete'] = 0;
                $map['id'] = ['in', $ids];
                $fields    = 'id, cat, first_name, middle_name, last_name, name, title, company, mailing_address as address, phone, ifnull(industry, \'-\') as industry, tag, ifnull(from_unixtime(create_time, \'%Y-%m-%d\'), \'-\') as create_time';
                $order     = 'id desc';
                $page_no   = $page_no ?: 1;
                $page_size = $page_size ?: 10;
                $list = $this->getCustomerModel()->getMultiData($map,
                    $fields,
                    $order,
                    $page_no,
                    $page_size);
                $count = $this->getCustomerModel()->getDataCount($map);
            }

            $result = [
                'count' => $count ?: 0,
                'list'  => $list ?: []
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
        return $this->getCustomerModel()->updateData($map, $data);
    }

}