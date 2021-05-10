<?php

namespace app\admin\controller;

class Permission extends Base
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
            $whereSearch = " `name` LIKE '%$search%' ";
        }

        $total = db('permission')->where($whereSearch)->count();

        $result = db('permission')->where($whereSearch)->limit($page, $limits)->select();

        return success('success', $total, $result);
    }
}
