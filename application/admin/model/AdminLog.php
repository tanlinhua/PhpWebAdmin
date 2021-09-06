<?php

namespace app\admin\model;

class AdminLog extends Base
{
    // 初始化处理
    // protected static function init() { }

    // 写入管理后台操作日志
    public static function record()
    {
        token();
        $uid = session("admin_id");
        $uri = request()->url();
        $body = request()->param('', null, 'trim,strip_tags,htmlspecialchars');

        $data = [
            'uid'   => $uid ? $uid : 0,
            'uri'   => $uri,
            'title' => self::getAdminLogTitle($uri),
            'body'  => json_encode($body),
            'ip'    => request()->ip(),
        ];
        self::create($data);
    }

    // 根据uri获取title
    private static function getAdminLogTitle($uri)
    {
        if (strstr($uri, "/login/check")) {
            return "登录后台";
        }
        if (strstr($uri, "/admin/cpw")) {
            return "修改登录密码";
        }

        $action = "action";
        if (strstr($uri, "add")) {
            $action = "添加";
        } else if (strstr($uri, "update")) {
            $action = "修改";
        } else if (strstr($uri, "del")) {
            $action = "删除";
        }

        $model = "model";
        if (strstr($uri, "/params/")) {
            $model = "系统参数";
        } else if (strstr($uri, "/role/")) {
            $model = "角色";
        } else if (strstr($uri, "/adm/")) {
            $model = "用户";
        }

        return "$action-$model";
    }

    // 相对关联
    public function admin()
    {
        return $this->belongsTo('Admin', 'uid')->setEagerlyType(0);
    }

    // Uid 获取器
    public function getUidAttr($value, $data)
    {
        $uid = $data['uid'];
        if (empty($uid)) {
            return '';
        }
        $user = Admin::get($uid);
        return $user->user_name;
    }

    // IP搜索
    protected function scopeIp($query, $ip)
    {
        $ip = !empty($ip) ? $ip : input('get.ip');
        if (!empty($ip)) {
            $query->where('ip', $ip);
        }
    }

    // 标题搜索
    protected function scopeTitle($query, $title)
    {
        $title = !empty($title) ? $title : input('get.title');
        if (!empty($title)) {
            $query->where('title', 'like', "%$title%");
        }
    }

    // 用户名搜索
    protected function scopeUserName($query, $name)
    {
        $name = !empty($name) ? $name : input('get.name');
        if (!empty($name)) {
            $uid = Admin::where(['user_name' => $name])->value('id');
            if (!empty($uid)) {
                $query->where('uid', $uid);
            } else {
                $query->where('0=1');
            }
        }
    }

    // 权限数据
    protected function scopeAuthData($query, $admin_id)
    {
        if ($admin_id != config('admin.id')) {
            $ids = Admin::where('pid', $admin_id)->column('id');
            array_push($ids, $admin_id);
            $query->where('uid', 'in', $ids);
        }
    }
}
