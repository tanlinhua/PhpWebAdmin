<?php

namespace app\admin\model;

use think\Model;

class Admin extends Model
{
    // 隐藏字段
    protected $hidden = [
        'password',
    ];

    /**
     * 修改器 -> 设置密码MD5
     */
    protected function setPasswordAttr($value)
    {
        return md5($value);
    }
}
