<?php

namespace app\admin\controller;

class Main extends Base
{
    /*
     * 后台首页
     */
    public function main()
    {
        return view();
    }

    /*
     * 修改密码
     */
    public function doCPW()
    {
        $postData = input();
        trace($postData);
        $check = $this->validate($postData, [
            'pwd1|原密码'   => 'require|min:6',
            'pwd2|新密码'   => 'require|min:6|different:pwd1',
            'pwd3|确认密码' => 'require|confirm:pwd2',
        ]);
        trace($check);
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
}
