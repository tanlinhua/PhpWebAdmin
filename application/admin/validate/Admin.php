<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    protected $rule =   [
        'id|ID'            => 'require|number',
        'user_name|用户名'  => 'require|length:5,30',
        'password|密码'     => 'require|min:6',
        'role|角色'         => 'require|number',
        'status|状态'       => 'require|in:0,1',
        'page|页码'         => 'require|number|>:0',
        'limit|分页数量'    => 'require|number|>:0',
    ];

    protected $message  =   [
        'status.in'     => '状态码错误',
    ];

    protected $scene = [
        'add'       =>  ['user_name', 'password', 'role', 'status'],
        'del'       =>  ['id'],
        'update'    =>  ['id', 'password' => 'min:6', 'role' => 'number', 'status' => 'in:0,1'],
        'get'       =>  ['page', 'limit'],
    ];
}
