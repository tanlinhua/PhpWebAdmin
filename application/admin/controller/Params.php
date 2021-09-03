<?php

namespace app\admin\controller;

/**
 * 系统参数(sys_params)
 */
class Params extends Base
{
    public function index()
    {
        return view('system/params');
    }

    public function add()
    {
        return error('暂不支持后台添加系统配置参数');
    }

    public function del()
    {
        return error('暂不支持后台删除系统配置参数');
    }

    public function update($id, $value)
    {
        $value = stripslashes($value);
        $result = db('sys_params')->where('id', $id)->update(['value' => $value]);
        if ($result) {
            return success();
        }
        return error();
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
            $whereSearch = " `key` LIKE '%$search%' ";
        }

        $total = db('sys_params')->where($whereSearch)->count();

        $result = db('sys_params')->where($whereSearch)->where('type', 1)->limit($page, $limits)->select();

        return success('success', $total, $result);
    }
}
