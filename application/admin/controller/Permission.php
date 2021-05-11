<?php

namespace app\admin\controller;

class Permission extends Base
{
    // view
    public function index()
    {
        return view();
    }

    // read
    public function get()
    {
        $vResult = $this->validate(input('get.'), 'Permission.get');
        if (true !== $vResult) {
            return error($vResult);
        }

        $page   = trim(input('page'));      //分页
        $limits = trim(input('limit'));     //分页数量
        $search = trim(input("search"));    //检索

        $db = db('permission');
        if (!empty($search)) {
            $db = $db->where('name', 'LIKE', "%$search%");
        }

        $result = $db->paginate($limits, false, ['page'  => $page]);
        return success('success', $result->total(), $result->items());
    }

    // 获取树形菜单数据
    public function tree()
    {
        return error();
    }
}
