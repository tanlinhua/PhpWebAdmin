<?php

namespace app\admin\controller;

use app\admin\model\AdminLog as ModelAdminLog;

/**
 * 后台用户操作日志
 */
class AdminLog extends Base
{
    private $model;

    public function _initialize()
    {
        parent::_initialize();

        $this->model = new ModelAdminLog;
    }

    public function index()
    {
        return view("system/admin_log");
    }

    // 检索获取操作日志
    // 代码好看,但性能堪忧 (hasWhere?)
    public function get()
    {
        $admId = $this->getAdminId();
        list($page, $limit, $title, $name, $ip, $t1, $t2) = $this->getParams(['title', 'name', 'ip', 't1', 't2']);

        $result = $this->model
            ->authData($admId)      // 权限
            ->title($title)         // 标题搜索
            ->userName($name)       // 用户名搜索
            ->ip($ip)               // IP搜索
            ->createdAt($t1, $t2)   // 时间搜索
            ->orderId()             // 排序
            ->paginate($limit, false, ['page'  => $page]); // 分页获取数据

        return success('success', $result->total(), $result->items());
    }
}
