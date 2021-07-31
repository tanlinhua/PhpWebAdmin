<?php

namespace app\cron\controller;

use fcm\Push1;
use fcm\Push2;

/**
 * Fcm.Push
 */
class Push
{
    private $mPushFlag = 1; // 0=>关闭; 1=>单次联网批量用户模式; 2=>批量联网批量用户模式

    /**
     * 定时任务,执行FCM
     * cron/push?key=ak47
     */
    public function index($key = '')
    {
        if ('ak47' != $key) {
            return error('do something');
        }
        debug('push_begin');

        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 60 * 20);

        // 判断当前是否有可执行的任务
        $dataCount = 0;
        $result = db('task')->where('sort', '>', 0)->where('status', 1)->field('id')->select();
        foreach ($result as $task) {
            $count = db('data')->where('tid', $task['id'])->where('status', 0)->count('id');
            $dataCount += $count;
            if ($dataCount > 0) {
                break;
            }
        }
        if ($dataCount <= 0) {
            $this->mPushFlag = 0;
        }

        // 执行fcmPush
        $pushResult = '';
        if (1 == $this->mPushFlag) {
            trace('select 1', 'notice');
            $hanlder = new Push1();
            $pushResult = $hanlder->index();
        } else if (2 == $this->mPushFlag) {
            trace('select 2', 'notice');
            $hanlder = new Push2();
            $pushResult = $hanlder->index();
        } else {
            trace("select $this->mPushFlag", 'notice');
        }

        debug('push_end');
        $runTime = debug('push_begin', 'push_end', 6) . 's';
        $response = "运行时间=" . $runTime . "<br> $pushResult \r\n";
        trace($response, 'notice');
        return $response;
    }
}

/**
 * FCM相关备忘录
 * 参数详情：https://firebase.google.com/docs/cloud-messaging/http-server-ref?authuser=0#device-group-managmement
 * 方法：https://blog.csdn.net/dsbjdq/article/details/79160910
 * 区别：https://www.freesion.com/article/7165572367/
 * 新版：https://blog.csdn.net/eric_twell/article/details/103205990
 * composer require guzzlehttp/guzzle:~6.0
 * composer remove guzzlehttp/guzzle
 */
