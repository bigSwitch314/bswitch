<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/7
 * Time: 下午11:37
 */

namespace app\script\server;


class Swoole
{
    public $serv;

    public function __construct()
    {
        $this->serv = new swoole_server("127.0.0.1", 9501, SWOOLE_PROCESS, SWOOLE_SOCK_TCP);
        $this->serv->set(array(
            'reactor_num' => 2,
            'worker_num' => 4,
            'task_worker_num' => 8,
            'daemonize' => true,
            'log_file' => '/usr/local/var/log/swoole.log',
            'heartbeat_check_interval' => 30,
            'heartbeat_idle_time' => 600,
            'dispatch_mode' => 2
        ));
        $this->serv->on('Start', array($this, 'onStart'));
        $this->serv->on('Connect', array($this, 'onConnect'));
        $this->serv->on('Receive', array($this, 'onReceive'));
        $this->serv->on('Task', array($this, 'onTask'));
        $this->serv->on('Finish', array($this, 'onFinish'));
        $this->serv->on('Close', array($this, 'onClose'));
    }

    public function onStart($serv)
    {
        swoole_set_process_name("swoole_server_tcp"); //主进程命名
        echo '[' . date('Y-m-d H:i:s') . '] SwooleServer Starting' . PHP_EOL . PHP_EOL;
    }

    public function onConnect($serv, $fd, $from_id)
    {
        $serv->send($fd, "Hello {$fd}!");
        echo '[' . date('Y-m-d H:i:s') . '] [Server]Connecting fd=' . $fd . ' from_id=' . $from_id . PHP_EOL . PHP_EOL;
    }

    public function onReceive($serv, $fd, $from_id, $data)
    {
        //投递异步任务
        $task_id = $serv->task($data);
        echo "Dispath AsyncTask: id=$task_id\n";
        //$serv->send($fd, $data);
        //echo '['.date('Y-m-d H:i:s').'] [Server]Receiveing, Get Message From Client'. "{$fd}:{$data}".PHP_EOL.PHP_EOL;
    }

    //处理异步任务
    public function onTask($serv, $task_id, $from_id, $data)
    {
        echo "New AsyncTask[id=$task_id]" . PHP_EOL;
        //返回任务执行的结果
        $serv->finish("$data -> OK");
    }

    //处理异步任务的结果
    public function onFinish($serv, $task_id, $data)
    {
        echo "AsyncTask[$task_id] Finish: $data" . PHP_EOL;
    }

    public function onClose($serv, $fd, $from_id)
    {
        echo '[' . date('Y-m-d H:i:s') . "] [Server]Closing, Client {$fd} close connection" . PHP_EOL . PHP_EOL;
    }
}


// 启动服务器
$server = new Swoole();
$server->serv->start();