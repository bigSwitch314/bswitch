<?php
namespace app\test\controller;

use think\config;
class Index
{
    public function index()
    {
        $states = [
            [
                'state'  => 'IN',
                'city'   => 'Indianapolis',
                'object' => 'School bus',
            ],
            [
                'state'  => 'IN',
                'city'   => 'Indianapolis',
                'object' => 'Manhole',
            ],
            [
                'state'  => 'IN',
                'city'   => 'Plainfield',
                'object' => 'Basketball',
            ],
            [
                'state'  => 'CA',
                'city'   => 'San Diego',
                'object' => 'Light bulb',
            ],
            [
                'state'  => 'CA',
                'city'   => 'Mountain View',
                'object' => 'Space pen',
            ],
        ];

        dump(array_group($states, 'state', 'city'));die;
        echo get_env();
        return 'Hello world!';
    }

    public function getHostByHash($key='wshhaua33', $n=2)
    {
        if($n<2) return 0;
        $id = sprintf("%u", crc32($key));
        $m = base_convert(intval(fmod($id, $n)), 10, $n);
        dump($id);
        dump(intval(fmod($id, $n)));
        dump($m);
        die;
        return $m{0};
    }
}
