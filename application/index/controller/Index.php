<?php

namespace app\index\controller;

use app\queue\controller\Queuetest;
use think\Controller;

class Index extends Controller
{
    public function index()
    {
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

    public function hello()
    {
        $id = input('get.id');
        if (1 == $id) {
            $q = new Queuetest();
            $ret = $q->index();
            halt($ret);
        }
        return 'index.index.hello';
    }
}
