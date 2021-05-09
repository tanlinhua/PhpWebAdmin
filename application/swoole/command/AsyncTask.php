<?php

namespace app\swoole\command;

use app\common\MailBit;
use app\common\SmsMkt;
use think\console\Command;
use think\console\Input;
use think\console\Output;
use think\Db;

class AsyncTask extends Command
{
    /*
    配置Task进程的数量,最大值不得超过 swoole_cpu_num() * 1000
    计算方法
    单个task的处理耗时，如100ms，那一个进程1秒就可以处理1/0.1=10个task
    task投递的速度，如每秒产生2000个task
    2000/10=200，需要设置task_worker_num => 200，启用200个task进程
     */
    private $task_worker_num = 4;


    protected function configure()
    {
        $this->setName('swoole:task')->setDescription('swoole async task');
    }

    protected function execute(Input $input, Output $output)
    {
        $output->writeln("StartSwooleTask...");


        $serv = new \Swoole\Server('0.0.0.0', 9501);

        $cpuNum = swoole_cpu_num();
        $this->task_worker_num = $cpuNum * 100;
        $output->writeln('cpu:' . $cpuNum);
        $output->writeln('task_worker_num:' . $this->task_worker_num);

        $serv->set(array('task_worker_num' => $this->task_worker_num));

        // 客户端连接
        $serv->on('connect', function ($serv, $fd) {
            echo "客户端$fd 建立连接." . PHP_EOL;
        });

        // 接收客户端请求
        $serv->on('receive', function ($serv, $fd, $from_id, $data) {
            $task_id = $serv->task($data);
            echo "开始投递异步任务 id=$task_id" . PHP_EOL;
        });

        // 处理客户端请求
        $serv->on('task', function ($serv, $task_id, $from_id, $data) {
            echo "接收异步任务[id=$task_id]" . PHP_EOL;

            $this->handler($data); // 业务处理

            $serv->finish("$data -> OK");
        });

        // 完成请求
        $serv->on('finish', function ($serv, $task_id, $data) {
            echo "异步任务[id=$task_id]完成" . PHP_EOL;
        });

        // 开启服务
        $serv->start();
    }

    protected function handler($data)
    {
        $data = json_decode($data, true);

        $id         = $data['id'];
        $platform   = $data['platform'];
        $phone      = $data['phone'];
        $content    = $data['content'];
        $pkinfo     = $data['pkinfo'];
        $key        = json_decode($pkinfo, true);

        switch ($platform) {
            case 'smsmkt':
                $ret = SmsMkt::send_sms($phone, $content, $key['sender'], $key['api_key'], $key['secret_key']);
                break;
            case 'mailbit':
                $ret = MailBit::send_sms($phone, $content, $key['from'], $key['username'], $key['password']);
                break;
                // other
            default:
                trace("is null,platform=$platform", "error");
                break;
        }

        $status = $ret == true ? 1 : 2;
        Db::execute("UPDATE `tools_sms_phone` SET `status`=? WHERE `task_id` = ?  AND `phone` = ?", [$status, $id, $phone]);

        echo "sms.send.msg:db.update.status=$status" . PHP_EOL;
    }
}
