<?php

namespace app\admin\controller;

class Main extends Base
{
    /*
     * 后台首页
     */
    public function main()
    {
        $per    = new Permission();
        $tree   = $per->getTreeData($this->getRoleId()); //获取当前角色ID的treeData
        $tree   = $this->getNewTree($tree);
        $this->assign("menuTree", $tree);
        $this->assign("adminName", session("admin_username"));
        return view();
    }

    // fool
    private function getNewTree($tree = array())
    {
        $superId = config('admin.id');
        $adminId = $this->getAdminId();
        for ($j = 0; $j < count($tree); $j++) {
            if (isset($tree[$j]['children'])) {
                for ($k = 0; $k < count($tree[$j]['children']); $k++) {
                    if (isset($tree[$j]['children'][$k]['children'])) {
                        foreach ($tree[$j]['children'][$k]['children'] as $row) {
                            if ($row['checked'] == true || $superId == $adminId) {
                                $tree[$j]['checked'] = true;
                                $tree[$j]['children'][$k]['checked'] = true;
                            }
                        }
                    }
                }
            }
        }
        return $tree;
    }

    /**
     * 控制台视图
     *
     * @return view
     */
    public function console()
    {
        return view();
    }

    /*
     * 修改密码
     */
    public function doCPW()
    {
        $postData = input();

        $check = $this->validate($postData, [
            'pwd1|原密码'   => 'require|min:6',
            'pwd2|新密码'   => 'require|min:6|different:pwd1',
            'pwd3|确认密码' => 'require|confirm:pwd2',
        ]);

        if (true !== $check) {
            return error($check);
        }

        $id = $this->getAdminId();

        $find = db("admin")->where('id', $id)->where('password', md5($postData['pwd1']))->find();

        if (!$find) {
            return error("原密码错误");
        }

        $ret = db("admin")->where("id", $id)->update(['password' => md5($postData['pwd2'])]);
        if ($ret) {
            return success("恭喜,修改成功");
        } else {
            return error("Sorry,修改失败");
        }
    }

    /**
     * 获取公告
     */
    public function getMessage()
    {
        $result['msg'] = db('sys_params')->where('key', 'admin_message')->value('value');
        return success("success", 1, $result);
    }
}
