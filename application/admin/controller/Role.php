<?php

namespace app\admin\controller;

class Role extends Base
{
    public function index()
    {
        return view();
    }

    public function add()
    {
    }

    public function del()
    {
    }

    public function update()
    {
    }

    public function get()
    {
        $page   = trim(input('page'));      //分页
        $limit  = trim(input('limit'));     //分页数量
        $search = trim(input("search"));    //检索

        $whereSearch = " 1=1 ";
        if (!empty($search)) {
            $whereSearch = " `role_name` LIKE '%$search%' ";
        }

        $result = db('role')->where($whereSearch)->paginate($limit, false, ['page'  => $page]);
        return success('success', $result->total(), $result->items());
    }
}
