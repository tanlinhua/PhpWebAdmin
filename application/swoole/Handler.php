<?php

namespace app\swoole;

// 调用👇
// $taskData = array('id' => $taskId, 'platform' => $platform, 'phone' => $phone, 'content' => $tmpContent, 'pkinfo' => $smsKeyInfo);
// $lenght = Handler::add(json_encode($taskData));

// swoole服务备忘录👇
// https://wiki.swoole.com/wiki/page/699.html
// 终端后台运行swoole task,工程目录运行 : nohup php think swoole:task >> /www/wwwroot/nohup.output.`date +%Y-%m-%d`.log 2>&1 &
// 进程id : 4113
// 查看进程 : jobs -l 或者 ps -ef 查看 php think swoole 最小的进程pid是多少
// 终止进程 : kill -9 进程号

class Handler
{
    /**
     * 投递swoole异步任务
     *
     * @param string $data json数据
     * @return void
     */
    public static function add($data)
    {
        if (empty($data)) {
            trace("app\swoole\Handler.data is empty", 'notice');
            return false;
        }

        $client = new \Swoole\Client(SWOOLE_SOCK_TCP, SWOOLE_SOCK_SYNC);
        $ret = $client->connect("localhost", 9501);
        if ($ret) {
            $res = $client->send($data);
            return $res;
        }
        trace('error!connect to swoole_server failed', 'error');
        return $ret;
    }
}
