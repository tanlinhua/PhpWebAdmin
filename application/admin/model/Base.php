<?php

namespace app\admin\model;

use think\Model;

class Base extends Model
{
    /**
     * ID排序, 默认倒序
     */
    public function scopeOrderId($query, $value = null)
    {
        $order = !empty($value) ? $value : input('get.order');
        if (!empty($order)) {
            if ('desc' == $order) {
                $query->order('id desc');
            } else {
                $query->order('id asc');
            }
        } else {
            $query->order('id desc');
        }
    }

    /**
     * 创建时间查询
     */
    protected function scopeCreatedAt($query,  $beginTime = null, $endTime = null)
    {
        $beginTime  = !empty($beginTime) ? $beginTime : input('get.beginTime');
        $endTime    = !empty($endTime) ? $endTime : input('get.endTime');

        if (!empty($beginTime) && !empty($endTime)) {
            $query->whereTime('created_at', 'between', [$beginTime, $endTime]);
        } else {
            if (!empty($beginTime)) {
                $query->whereTime('created_at', '>', $beginTime);
            }
            if (!empty($endTime)) {
                $query->whereTime('created_at', '<', $endTime);
            }
        }
    }
}
