<?php

namespace app\index\controller;

use app\queue\Handler as QueueHandler;
use app\swoole\Handler as SwooleHandler;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return '404';
        $this->redirect('/app', 302);
    }

    /**
     * 路由miss方法
     *
     * @return json string
     */
    public function miss()
    {
        return error("您请求的资源不存在", 404);
    }

    /**
     * 便于各种临时测试
     */
    public function test()
    {
        $t = input('get.t');
        if (1 == $t) {
            echo "queue<br>";
            $ret = QueueHandler::add();
            halt($ret);
        } else if (2 == $t) {
            echo "swoole<br>";
            $taskData = array('id' => 1, 'platform' => 'test', 'phone' => "138", 'content' => "test", 'pkinfo' => '{"k":"v"}');
            $lenght = SwooleHandler::add(json_encode($taskData));
            halt($lenght);
        }
        return 'index.Index.test';
    }
}
