<?php

namespace app\admin\behavior;

use app\admin\model\AdminLog as ModelAdminLog;

class AdminLog
{
    public function run(&$params)
    {
        // post & config
        if (request()->isPost() && config('admin.log')) {
            ModelAdminLog::record();
        }
    }
}
