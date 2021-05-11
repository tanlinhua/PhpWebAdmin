<?php

use think\Route;

// 注意：要先application/config.php 
// true开启混合模式路由,false关闭路由   'url_route_on' => true,
// 强制路由模式 'url_route_must'=>  true,

// 开启 域名部署(url_domain_deploy => true)
// Route::domain('api', 'api'); //绑定前端模块
// Route::domain('admin', 'admin'); //绑定后端模块

// 生成路由缓存 > php think optimize:route

// Miss路由
Route::miss("/miss");
Route::get('miss', 'index/Index/miss');

// 根
Route::get('/', 'index/Index/index');

// ADMIN
Route::group('admin', [
    //登录相关
    'login/check'   => ['admin/Login/check', ['method' => 'post']], //后台登录校验
    'login/quit'    => ['admin/Login/quit', ['method' => 'get']], //后台退出登录
    'login/google'  => ['admin/Login/createGoogleAuth', ['method' => 'get']], //生成谷歌身份认证信息
    'login'         => ['admin/Login/index', ['method' => 'get']], //后台登录页面

    //后台首页
    'main'          => ['admin/Main/main', ['method' => 'get']],
    'console'       => ['admin/Main/console', ['method' => 'get']], //控制台
    'cpw'           => ['admin/Main/doCPW', ['method' => 'post']], //修改密码

    //用户管理
    'adm/view'      => ['admin/Admin/index', ['method' => 'get']],
    'adm/add'       => ['admin/Admin/add', ['method' => 'post']], //增
    'adm/del'       => ['admin/Admin/del', ['method' => 'get']], //删
    'adm/update'    => ['admin/Admin/update', ['method' => 'post']], //改
    'adm/get'       => ['admin/Admin/get', ['method' => 'get']], //查

    //角色管理
    'role/view'      => ['admin/Role/index', ['method' => 'get']],
    'role/add'       => ['admin/Role/add', ['method' => 'post']], //增
    'role/del'       => ['admin/Role/del', ['method' => 'get']], //删
    'role/update'    => ['admin/Role/update', ['method' => 'post']], //改
    'role/get'       => ['admin/Role/get', ['method' => 'get']], //查

    //权限管理
    'per/view'      => ['admin/Permission/index', ['method' => 'get']],
    'per/get'       => ['admin/Permission/get', ['method' => 'get']], //查

    //参数配置
    'params/view'      => ['admin/Params/index', ['method' => 'get']],
    'params/add'       => ['admin/Params/add', ['method' => 'post']], //增
    'params/del'       => ['admin/Params/del', ['method' => 'get']], //删
    'params/update'    => ['admin/Params/update', ['method' => 'post']], //改
    'params/get'       => ['admin/Params/get', ['method' => 'get']], //查
]);

// Api
Route::group('api', [
    'test'   => ['api/Test/hello', ['method' => 'get']],
]);

// Index
Route::group('index', [
    'test'   => ['index/Index/hello', ['method' => 'get']],
]);
