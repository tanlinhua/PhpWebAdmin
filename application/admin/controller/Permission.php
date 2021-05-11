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
        $roleid = trim(input('roleid'));    //角色ID
        $page   = trim(input('page'));      //分页
        $limit  = trim(input('limit'));     //分页数量
        $search = trim(input("search"));    //检索

        if (!empty($roleid)) {
            return $this->tree();
        }

        $whereSearch = " 1=1 ";
        if (!empty($search)) {
            $whereSearch = " `name` LIKE '%$search%' ";
        }

        $result = db('permission')->where($whereSearch)->paginate($limit, false, ['page'  => $page]);
        return success('success', $result->total(), $result->items());
    }

    private function tree()
    {
        return success('success', 0, null);
    }
}
