<?php

namespace app\index\controller;

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
        return error("您请求的资源不存在");
    }

    public function hello()
    {
        return 'hello';
    }
}
