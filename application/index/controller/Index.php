<?php

namespace app\index\controller;

use app\common\library\Redis;
use app\queue\Handler as QueueHandler;
use app\swoole\Handler as SwooleHandler;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return json(['code' => '404', 'msg' => 'not found']);
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
     * /index/test?t=n
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
        } else if (3 == $t) {
            $this->redisStore();
        }
        return 'index.Index.test';
    }

    private function redisStore()
    {
        $rdb = new Redis();

        // 1.string
        $rdb->set("string_key", "string_value", 0);
        $rdb->set("user:token:1", "token_value_1", 0);
        $rdb->set("user:token:2", "token_value_2", 0);

        // 2.hash
        $rdb->hashSet("redis_key", "hash_key_1", "hash_value_1");
        $rdb->hashSetArray("redis_key", array("hash_key_2" => "hash_value_2"));

        $rdb->hashSet("user:id:1", "name", "jay");
        $rdb->hashSet("user:id:1", "age", "18");
        $rdb->hashSet("user:id:2", "name", "jason");
        $rdb->hashSet("user:id:2", "age", "30");

        // 3.list
        $rdb->listAdd("task_1", "1234561");
        $rdb->listAdd("task_1", "1234562");
        $rdb->listAdd("task_1", "1234563");
        $rdb->listAdd("task_1", "1234564");

        // 4.set
        $rdb->setAdd("setName", "130");
        $rdb->setAdd("setName", "130");
        $rdb->setAdd("setName", "131");
        $rdb->setAdd("setName", "132");

        // 5.sorted set
        $rdb->setAdd("s_setName", "130", "1");
        $rdb->setAdd("s_setName", "130", "2");
        $rdb->setAdd("s_setName", "131", "3");
        $rdb->setAdd("s_setName", "132", "4");
    }
}
