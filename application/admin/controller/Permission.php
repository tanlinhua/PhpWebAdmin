<?php

namespace app\admin\controller;

class Permission extends Base
{
    // view
    public function index()
    {
        return view();
    }

    // read
    public function get()
    {
        $vResult = $this->validate(input('get.'), 'Permission.get');
        if (true !== $vResult) {
            return error($vResult);
        }

        $page   = trim(input('page'));      //分页
        $limits = trim(input('limit'));     //分页数量
        $search = trim(input("search"));    //检索

        $db = db('permission');
        if (!empty($search)) {
            $db = $db->where('name', 'LIKE', "%$search%");
        }

        $result = $db->paginate($limits, false, ['page'  => $page]);
        return success('success', $result->total(), $result->items());
    }

    // 获取树形菜单数据1
    public function tree($roleid = 0)
    {
        $tree = $this->getTreeData($roleid);
        return success('success', 0, $tree);
    }

    // 获取树形菜单数据2
    public function getTreeData($roleid = 0)
    {
        $ids = db('role')->where('id', $roleid)->value('per_id');
        $ids = explode(',', $ids);

        $root = db('permission')->select();
        $lowLevel = db('permission')->max('level'); //最小子菜单级别表示

        $tree = $this->getTreeMenu($root, $ids, $lowLevel);
        return $tree;
    }

    // 将权限表数据递归分级
    protected function getTreeMenu($data, $ids = array(), $lowLevel, $pid = 0, $deep = 0)
    {
        $tree = array();
        foreach ($data as $row) {
            // 针对layui进行处理 👇
            $row['title'] = $row['name'];
            $row['checked'] = false;
            $row['spread'] = true;
            if ($row['level'] == $lowLevel) {
                if (in_array($row['id'] . '', $ids)) {
                    $row['checked'] = true; //有权限则选择
                }
            }
            // 处理子菜单
            if ($row['pid'] == $pid) {
                $row['children'] = $this->getTreeMenu($data, $ids, $lowLevel, $row['id'], $deep + 1);
                $tree[] = $row;
            }
        }
        return $tree;
    }
}
