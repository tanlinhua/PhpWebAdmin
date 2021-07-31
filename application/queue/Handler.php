<?php

namespace app\queue;

use think\Queue;

/**
 * 监听任务并执行
 * php think queue:listen
 * php think queue:work --daemon（不加--daemon为执行单个任务）
 * 两种，具体的可选参数可以输入命令加 --help 查看
 * 可配合supervisor使用，保证进程常驻
 * Test -> nohup php think queue:listen --queue MyJobs &
 */
class Handler
{
    /**
     * 发送队列消息
     */
    public static function add($data = [])
    {
        // 1.当前任务将由哪个类来负责处理。
        //   当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法
        $jobHandlerClassName  = 'app\queue\jobs\Jobs1';

        // 2.当前任务归属的队列名称，如果为新队列，会自动创建
        $jobQueueName  = "MyJobs";

        // 3.当前任务所需的业务数据 . 不能为 resource 类型，其他类型最终将转化为json形式的字符串
        //   ( jobData 为对象时，存储其public属性的键值对 )
        $jobData = ['type' => 1, 'data_id' => 12, 'ts' => time()];

        // 4.将该任务推送到消息队列，等待对应的消费者去执行
        $isPushed = Queue::push($jobHandlerClassName, $jobData, $jobQueueName);

        if ($isPushed !== false) {
            return '消息已发出';
        } else {
            return '消息发送出错';
        }
    }
}
