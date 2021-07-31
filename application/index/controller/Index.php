<?php

namespace app\index\controller;

use app\queue\Handler;
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
            $ret = Handler::add();
            halt($ret);
        }
        return 'index.Index.test';
    }
}
