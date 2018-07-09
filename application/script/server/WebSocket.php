<?php
/**
 * Created by PhpStorm.
 * User: qiangluo
 * Date: 2018/7/7
 * Time: 下午11:07
 */

namespace app\script\server;

use app\common\tools\RedisClient;


class WebSocket
{
    /**
     * @var swoole_websocket_server
     */
    public $serv;

    /**
     * @var redis
     */
    public $redis;

    /**
     * webSocket constructor
     */
    public function __construct()
    {
        $this->serv = new \swoole_websocket_server("192.168.2.249", 9501);
        $this->serv->set([
            'daemonize' => true,
            'log_file' => '/mnt/dev/log/websocket.log',
            'heartbeat_check_interval' => 300,
            'heartbeat_idle_time' => 6000,
        ]);
        $this->serv->on('Open', [$this, 'onOpen']);
        $this->serv->on('Message', array($this, 'onMessage'));
        $this->serv->on('Close', array($this, 'onClose'));
        // redis
        $this->redis = new RedisClient();
    }

    /**
     * @param \swoole_websocket_server $server
     * @param $request
     */
    public function onOpen(\swoole_websocket_server $server, $request)
    {
        echo "server: handshake success with fd{$request->fd}\n";
        $this->redis->sAdd('websocket_fds', $request->fd);
    }

    /**
     * @param \swoole_websocket_server $server
     * @param $frame
     */
    public function onMessage(\swoole_websocket_server $server, $frame)
    {
        echo "receive from {$frame->fd}:{$frame->data}, opcode:{$frame->opcode}, fin:{$frame->finish}\n";
        $server->push($frame->fd, "this is server");

        $redis = $this->redis;
        $fds = $this->redis->sMembers('websocket_fds');
        echo json_encode_unescape($fds) . PHP_EOL;
        $server->tick(1000, function() use($server, $frame, $redis, $fds) {
            $result = $redis->lPop('queue:socket_log');
            if($result) {
                foreach ($fds as $fd) {
                    $server->push($fd, "$result" . date('Y-m-d H:i'));
                }
            }
        });
    }

    /**
     * @param \swoole_websocket_server $server
     * @param $fd
     */
    public function onClose(\swoole_websocket_server $server, $fd)
    {
        echo "client {$fd} closed\n";
        $this->redis->sRem('websocket_fds', $fd);

    }

}
