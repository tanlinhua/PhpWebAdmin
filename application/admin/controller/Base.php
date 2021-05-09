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

        $nowTime = time();
        $loginTime = session('admin_loginTime');
        $timeOut = 3600 * 24; // 登录超时时间: 小时 * N
        $calc = $nowTime - $loginTime;

        if ($calc > $timeOut && $this->mTimeOutFlag) {
            session("admin_loginTime", null);
            session("admin_id", null);
            session("admin_username", null);
            $this->error('登录超时', URL('admin/login/index?key=98k'));
        } else {
            session('admin_loginTime', $nowTime);
        }
        $this->assign("nickName", session("admin_username"));
    }

    public function getAdminId()
    {
        $adminId = session('admin_id');
        if (empty($adminId)) {
            $this->error('登录超时', URL('admin/login/index?key=98k'));
        }
        return $adminId;
    }
}
