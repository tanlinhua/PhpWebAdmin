<?php

namespace app\queue\controller;

use think\Queue\Job;

class Queuejob
{
    /**
     * fire方法是消息队列默认调用的方法
     * @param Job $job 当前的任务对象
     * @param $data 发布任务时自定义的数据
     * @return int
     */
    public function fire(Job $job, $data)
    {
        trace($data, 'error');
        //这里$data定义格式为：$data = [ 'type'=>1, 'data_id' => 123,'ts' => time()]
        if (empty($data)) {
            return 0;
        }

        if (is_array($data) && isset($data['type'])) {
            $type = $data['type'];
            if ($type == 1) {
                //执行发送邮件业务
                $isJobDone = $this->sendEmail($data['data_id']);
            } else if ($type == 2) {
                //执行APP推送消息业务
                $isJobDone = $this->sendAppMessage($data['data_id']);
            } else if ($type == 3) {
                //执行订单业务
                $isJobDone = $this->orderService($data['data_id']);
            } else {
                return 0;
            }
        } else {
            return 0;
        }
        if ($isJobDone) {
            // 如果任务执行成功，删除任务
            $job->delete();
        } else {
            if ($job->attempts() > 3) {
                //通过这个方法可以检查这个任务已经重试了几次了
                $job->delete();
                // 也可以重新发布这个任务
                //$job->release(2); //$delay为延迟时间，表示该任务延迟2秒后再执行
            }
        }
    }

    public function failed($data)
    {
        // ...任务达到最大重试次数后，失败了
    }

    //发邮件业务
    private function sendEmail($id)
    {
        trace('sendEmail', 'error');
        return true;
    }

    //发App消息业务
    private function sendAppMessage($id)
    {
        trace('sendAppMessage', 'error');
        return true;
    }

    //处理订单业务
    private function orderService($id)
    {
        trace('orderService', 'error');
        return true;
    }
}
