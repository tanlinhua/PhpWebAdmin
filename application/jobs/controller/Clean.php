<?php

namespace app\jobs\controller;

class Clean
{
    /**
     * 定时任务,每日凌晨执行一次
     * jobs/clean?key=ak47
     */
    public function index($key = '')
    {
        if ('ak47' != $key) {
            return error('do something');
        }
        $ms1 = getCurrMsTime();

        $result1 = db('user')->where('id', '>', 0)->update(['task_today_ing' => 0]); //每日凌晨清理发送中数量
        $result2 = db('user')->where('id', '>', 0)->update(['task_success_today' => 0]); //每日凌晨清理发送成功数量
        $result3 = db('data')->where('status', 1)->update(['status' => 2]); //发送中的号码统一设置成发送失败

        $ms2 = getCurrMsTime();
        $runTime = "运行时间(ms)=" . ($ms2 - $ms1);
        $response =  "今日发送中清理数:$result1;今日成功清理数:$result2;发送中设置失败数:$result3;$runTime\r\n";
        trace($response, 'notice');
        return $response;
    }

    /**
     * 清理7天前的sms_log记录
     * jobs/clean/log?key=ak47
     */
    public function log($key = '')
    {
        if ('ak47' != $key) {
            return error('do something');
        }
        $ms1 = getCurrMsTime();

        $cleanDate = date("Y-m-d H:i:s", strtotime("-7 day"));
        $result = db('log')->where('created_at', '<', $cleanDate)->delete();

        $ms2 = getCurrMsTime();
        $runTime = "运行时间(ms)=" . ($ms2 - $ms1);
        $response =  "clean.sms_log.result=$result;$runTime\r\n";
        trace($response, 'notice');
        return $response;
    }
}
