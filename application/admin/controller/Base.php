<?php

namespace app\admin\controller;

use think\Controller;
use think\Request;

class Base extends Controller
{
    private $mTimeOutFlag = true; //false：无权限控制，true：启用超时·权限控制

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

        // 1. 校验登录是否超时
        $nowTime = time();
        $loginTime = session('admin_loginTime');
        $timeOut = 3600 * 24; // 登录超时时间: 小时 * N
        $calc = $nowTime - $loginTime;
        if ($calc > $timeOut && $this->mTimeOutFlag) {
            session("admin_loginTime", null);
            session("admin_id", null);
            session("admin_username", null);
            $this->error('登录超时', URL('/admin/login'));
        } else {
            session('admin_loginTime', $nowTime);
        }

        $admId = $this->getAdminId();

        if ($admId != config('admin.id')) {
            $dbAdm = db('admin')->where('id', $admId)->field('role,status')->find();

            // 2.校验后台操作权限
            $check = $this->checkPermission($dbAdm['role']);
            if (!$check) {
                exit('{"code":401,"msg":"暂无权限"}');
            }

            // 3.校验admin表用户状态
            if (0 == $dbAdm['status']) {
                exit('{"code":401,"msg":"账户已封禁"}');
            }
        }
    }

    //检测权限
    protected function checkPermission($role_id)
    {
        $uri = '/' . request()->path();
        $method = request()->method();

        //获取角色ids
        $ids = db('role')->where('id', $role_id)->value('per_id');
        if (empty($ids)) {
            return false;
        }
        $ids = explode(',', $ids);
        //获取权限ID
        $pid = db('permission')->where('uri', $uri)->where('method', $method)->value('id');
        if (in_array($pid, $ids)) {
            return true;
        }
        return false;
    }

    //获取登录的管理员ID
    protected function getAdminId()
    {
        $adminId = session('admin_id');
        if (empty($adminId)) {
            $this->error('登录超时', URL('/admin/login'));
        }
        return $adminId;
    }
}
