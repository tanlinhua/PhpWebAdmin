<?php

namespace app\admin\controller;

use app\admin\model\Admin as ModelAdmin;

/**
 * 后台用户管理
 */
class Admin extends Base
{
    protected $adminModel;

    // 构造
    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new ModelAdmin();
    }

    // view
    public function index()
    {
        return view('rbac/user');
    }

    // 增
    public function add()
    {
        $data = input('post.');
        $vResult = $this->validate($data, 'Admin.add');
        if (true !== $vResult) {
            return error($vResult);
        }
        $admId = $this->getAdminId();
        if ($admId != config('admin.id')) {
            $data['pid'] = $admId; // 非超级管理员新增的用户的上级ID只能为该用户
        }

        $result = $this->adminModel->isUpdate(false)->data($data, true)->save(); // ->data第二个参数为true的时候才会触发修改器
        if ($result > 0) {
            return success();
        }
        return error();
    }

    // 删
    public function del()
    {
        $data = input('get.');

        $vResult = $this->validate($data, 'Admin.del');
        if (true !== $vResult) {
            return error($vResult);
        }

        $result = $this->adminModel->destroy(['id' => $data['id']]);
        if ($result > 0) {
            return success();
        }
        return error();
    }

    // 改
    public function update()
    {
        $data = input('post.');
        $vResult = $this->validate($data, 'Admin.update');
        if (true !== $vResult) {
            return error($vResult);
        }
        $data = array_filter_empty_string($data);
        $result = $this->adminModel->isUpdate(true)->data($data, true)->save();
        if ($result > 0) {
            return success();
        }
        return error();
    }

    // 查
    public function get()
    {
        $vResult = $this->validate(input('get.'), 'Admin.get');
        if (true !== $vResult) {
            return error($vResult);
        }

        $page   = trim(input('page'));    //分页
        $limits = trim(input('limit'));   //分页数量
        $search = trim(input("search"));  //检索
        $role   = trim(input("role"));    //角色
        $t1     = trim(input("t1"));      //开始时间
        $t2     = trim(input("t2"));      //结束时间

        $db = db('admin')->alias('a')->join('role r', 'a.role=r.id', 'left')
            ->where('a.role', 'NEQ', 0)->order('a.id asc')
            ->field('a.id,role,pid,user_name,role_name,created_at,updated_at,last_login_time,last_login_ip,status');

        if (!empty($search)) {
            $db = $db->where('user_name', 'like', "%$search%");
        }
        if (!empty($role)) {
            $db = $db->where('a.role', '=', $role);
        }
        if (!empty($t1) && !empty($t2)) {
            $db = $db->whereBetween('last_login_time', [$t1, $t2]);
        }

        $admId = $this->getAdminId();
        if ($admId != config('admin.id')) {
            $find = db('admin')->where('pid', $admId)->field('id')->select();
            $ids = array();
            foreach ($find as $item) {
                array_push($ids, $item['id']);
            }
            array_push($ids, $admId);
            $db = $db->whereIn('a.id', $ids);
        }

        $limits = empty($limits) ? 100 : $limits; // 临时解决一下上级id下拉框赋值

        $result = $db->paginate($limits, false, ['page'  => $page]);

        return success('success', $result->total(), $result->items());
    }
}
