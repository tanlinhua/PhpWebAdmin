<?php

namespace app\admin\controller;

use app\admin\model\Role as ModelRole;

class Role extends Base
{
    protected $roleModel;

    public function __construct()
    {
        parent::__construct();
        $this->roleModel = new ModelRole();
    }

    public function index()
    {
        return view();
    }

    public function add()
    {
        $data = input('post.');
        $vResult = $this->validate($data, 'Role.add');
        if (true !== $vResult) {
            return error($vResult);
        }

        $result = $this->roleModel->isUpdate(false)->data($data, true)->save();
        if ($result > 0) {
            return success();
        }
        return error();
    }

    public function del()
    {
        $id = input('get.id');

        $result = $this->roleModel->destroy(['id' => $id]);
        if ($result > 0) {
            return success();
        }
        return error();
    }

    public function update()
    {
        $data = input('post.');
        $vResult = $this->validate($data, 'Role.update');
        if (true !== $vResult) {
            return error($vResult);
        }
        $data = array_filter_empty_string($data);
        $result = $this->roleModel->isUpdate(true)->data($data, true)->save();
        if ($result > 0) {
            return success();
        }
        return error();
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
