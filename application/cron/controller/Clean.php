<?php

namespace app\cron\controller;

class Clean
{
    /**
     * 定时任务,每日凌晨执行一次
     * corn/clean?key=ak47
     */
    public function index($key = '')
    {
        if ('ak47' != $key) {
            return error('do some thing');
        }
        debug('clean_begin');

        // do some thing
        sleep(1);

        debug('clean_end');
        $runTime = "运行时间=" . debug('clean_begin', 'clean_end', 6) . 's';

        $trace = "$runTime\r\n";
        trace($trace, 'notice');
        return $trace;
    }
}
