<?php

namespace app\admin\controller;

/**
 * 后台用户管理
 */
class Admin extends Base
{
    // view
    public function index()
    {
        return view('adm/index');
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
        $page   = trim(input('page'));      //分页
        $limits = trim(input('limit'));     //分页数量
        $search = trim(input("search"));    //检索

        $whereSearch = " 1=1 ";
        if (!empty($search)) {
            $whereSearch = " `user_name` LIKE '%$search%' ";
        }

        $result = db('admin')->alias('a')->join('role r', 'a.role=r.id', 'left')
            ->where('a.role', 'NEQ', 0)->order('a.id asc')
            ->field('a.id,role,user_name,role_name,created_at,updated_at,last_login_time,last_login_ip,status')
            ->where($whereSearch)->paginate($limits, false, ['page'  => $page]); // 如果用model,一句sql搞不定,怎么破?

        return success('success', $result->total(), $result->items());
    }
}
