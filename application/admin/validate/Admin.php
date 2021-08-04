<?php

namespace app\admin\validate;

use think\Validate;

class Admin extends Validate
{
    // 正则表达式
    protected $regex = [
        'user_name' => '/^(?=[a-zA-Z])([a-zA-Z0-9_])*$/i',   // 由字母,数字,下划线组成,并且必须以字母开头
        'nick_name' => '/^(?!\d)([^[:punct:]])*$/i',         // 不能包含标点符号和空格, 并且不能以数字开头
        'real_name' => '/^([^[:punct:]\d]|\s|\.)*$/i',       // 允许包含空格和小数点, 但不能包含其他标点符号和数字
        'password'  => '/^([[:punct:]\w\d])*$/i',            // 由字母,数字,标点组成
        'ip'        => '/^([\d[:punct:]])*$/',               // 由数字,标点组成
    ];

    protected $rule =   [
        'id|ID'            => 'require|number',
        'user_name|用户名'  => 'require|length:5,30|regex:user_name',
        'password|密码'     => 'require|min:6|regex:password',
        'role|角色'         => 'require|number',
        'pid|上级ID'        => 'number',
        'status|状态'       => 'require|in:0,1',
        'page|页码'         => 'number|>:0',
        'limit|分页数量'    => 'number|>:0',
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
