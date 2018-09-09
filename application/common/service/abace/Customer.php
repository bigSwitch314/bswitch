<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/13
 * Time: 下午12:00
 */

namespace app\common\service\abace;

use app\common\model\abace\Customer as CustomerModel;


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
                $data = [
                    'id'          => $id++,
                    'cat'         => 'cat-' . $num,
                    'first_name'  => $first_name_arr[array_rand($first_name_arr, 1)],
                    'middle_name' => $middle_name_arr[array_rand($middle_name_arr, 1)],
                    'last_name'   => $last_name_arr[array_rand($last_name_arr, 1)],
                    'name'        => 'null',
                    'title'       => $title_arr[array_rand($title_arr, 1)],
                    'company'     => 'company-' . $num,
                    'mailing_address' => 'address' . $num,
                    'phone'       => 'phone-' . $num,
                    'tag'         => 'tag-' . $num,
                    'industry'    => 'null',
                    'delete'      => 0,
                    'edit_time'   => 0,
                    'create_time' => time()
                ];

                $data_new = $data['id'] . "\t" . $data['cat'] . "\t" . $data['first_name'] . "\t" . $data['middle_name'] . "\t"  . $data['last_name'] . "\t" .
                            $data['name'] . "\t" . $data['title'] . "\t" . $data['company'] . "\t"  . $data['mailing_address'] . "\t" .
                            $data['phone'] . "\t" . $data['tag'] . "\t" . $data['industry'] . "\t"  . $data['delete'] . "\t". $data['edit_time'] . "\t".$data['create_time'] . "\t". "\n" ;

                file_put_contents('/home/www/test_data.txt', $data_new, FILE_APPEND);
            }
        };

        $generateData(10383397, 10000001, 11000000);

        echo 'end_time: ' . date('Y-m-d H:i:s', time()) . PHP_EOL;

        $memory = round(memory_get_usage() / pow(1024, 2), 2) . 'mb';
        echo 'memory: ' . $memory;

        exit;
    }

    /**
     * 添加/修改记录
     * @return bool
     */
    public function save()
    {
       return true;
    }

    /**
     * 获取记录
     * @param $id
     * @param $page_no
     * @param $page_size
     * @return bool
     */
    public function get($id, $page_no, $page_size)
    {
        return true;
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