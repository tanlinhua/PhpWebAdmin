<?php

namespace app\admin\validate;

use think\Validate;

class SysParams extends Validate
{
    protected $rule =   [
        'id|ID'            => 'require|number',
        'page|页码'        => 'require|number|>:0',
        'limit|分页数量'    => 'require|number|>:0',
    ];

    protected $message  =   [
        // 'name.require' => '名称必须',
    ];

    protected $scene = [
        'get'  =>  ['page', 'limit'],
        'del'  =>  ['id'],
    ];
}
