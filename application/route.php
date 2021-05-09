<?php

use think\Route;

// Route::miss("/miss");
// Route::get('miss', 'index/Index/miss');

// 根域名
Route::get('/', 'index/Index/index');

// ADMIN
Route::group('admin', [
    //后台登录校验
    'login/check'   => ['admin/Login/check', ['method' => 'post']],
    //后台退出登录
    'login/quit'    => ['admin/Login/quit', ['method' => 'get']],
    //生成谷歌身份认证信息
    'login/google'  => ['admin/Login/createGoogleAuth', ['method' => 'get']],
    //后台登录页面
    'login'         => ['admin/Login/index', ['method' => 'get']],

    //修改密码
    'cpw'           => ['admin/Main/doCPW', ['method' => 'post']],
    //控制台
    'console'       => ['admin/Main/console', ['method' => 'get']],
    //后台首页
    'main'          => ['admin/Main/main', ['method' => 'get']],
]);

// Index
Route::group('index', [
    'abc'   => ['index/Index/index', ['method' => 'get']],
    'hello'   => ['index/Index/hello', ['method' => 'post']],
]);

// 注意：要先application/config.php 开启 域名部署(url_domain_deploy => true)
// true开启混合模式路由,false关闭路由   'url_route_on' => true,
// 强制路由模式 'url_route_must'=>  true,
// 路由配置文件（默认route，支持配置多个） 'route_config_file'      => ['route','route_api'],
// Route::domain('api', 'api'); //绑定前端模块
// Route::domain('admin', 'admin'); //绑定后端模块
// /*APP路由*/
// Route::domain('m', function () {
//     //资源路由
//     Route::resource('testabcd', 'app/test'); //别名(别名，模块/控制器)
//     //快捷路由(除了index方法，其它方法前面都以get为前缀命名)
//     Route::controller('app/test', 'app/test'); //控制器路由(模块/控制器)
//     //路由分组
//     Route::group('testabc', function () {
//         //常用路由(get,post,any,put,delete...)
//         Route::get('', 'test/sendmsg'); //别名 (控制器/方法)
//         Route::alias('d', 'app/test/sendmsg'); //别名路由（别名，模块/控制器/方法)
//         Route::rule('q', 'app/test/sendmsg'); //别名路由（别名，模块/控制器/方法)
//         Route::any('s', 'app/test/sendmsg', ['callback' => 'checkRoute']);
//         Route::group(['middleware' => 'AccessMiddleware'], function () {
//         });
//     });
// });