<?php

namespace app\admin\validate;

use think\Validate;

class Role extends Validate
{
    protected $rule =   [
        'id|ID'                => 'require|number',
        'role_name|角色名称'    => 'require|length:2,40',
        'role_desc|角色描述'    => 'require|length:2,40',
        'per_id|权限'           => 'require|min:1',
    ];

    protected $message  =   [];

    protected $scene = [
        'add'       =>  ['role_name', 'role_desc', 'per_id'],
        'update'    =>  ['id', 'role_name', 'role_desc', 'per_id'],
    ];
}
