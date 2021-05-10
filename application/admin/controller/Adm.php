<?php

namespace app\admin\controller;

/**
 * 后台用户管理
 */
class Adm extends Base
{
    // view
    public function index()
    {
        return view();
    }

    // 增
    public function add()
    {
    }

    // 删
    public function del()
    {
    }

    // 改
    public function update()
    {
    }

    // 查
    public function get()
    {
        $inputPage      = trim(input('page'));      //分页
        $inputLimits    = trim(input('limit'));     //分页数量
        $search         = trim(input("search"));    //检索

        $limits = 10;
        if (!empty($inputLimits)) {
            $limits = $inputLimits;
        }

        $page = 1;
        if (!empty($inputPage)) {
            $page = ($inputPage - 1) * $limits;
        }

        $whereSearch = " 1=1 ";
        if (!empty($search)) {
            $whereSearch = " `user_name` LIKE '%$search%' ";
        }

        $total = db('admin')->where($whereSearch)->count();

        $result = db('admin')->alias('a')->join('role r', 'a.role=r.id', 'left')
            ->where('a.role', 'NEQ', 0)->order('a.id asc')
            ->field('a.id,user_name,role_name,created_at,updated_at,last_login_time,last_login_ip,status')
            ->where($whereSearch)->limit($page, $limits)->select(); // 如果用model,一句sql搞不定,怎么破?

        return success('success', $total, $result);
    }
}
