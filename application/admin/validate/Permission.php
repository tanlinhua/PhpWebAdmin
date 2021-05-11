<?php

namespace app\admin\validate;

use think\Validate;

class Permission extends Validate
{
    protected $rule =   [
        'page|页码'        => 'require|number|>:0',
        'limit|分页数量'    => 'require|number|>:0',
        'roleid|角色ID'     => 'require|number|>:0',
    ];

    protected $message  =   [];

    protected $scene = [
        'get'   =>  ['page', 'limit'],
        'tree'  =>  ['roleid'],
    ];
}
