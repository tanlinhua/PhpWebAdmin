<?php

namespace app\admin\controller;

class Main extends Base
{
    /*
     * welcome
     */
    public function index()
    {
        $time1 = trim(input("time1"));
        $time2 = trim(input("time2"));
        if (empty($time1) && empty($time2)) {
            $time1 = date("Y-m-d 00:00:00");
            $time2 = date("Y-m-d 23:59:59");
        }

        return view('index', compact(
            'time1',
            'time2',
        ));
    }

    /*
     * 修改密码
     */
    public function cpw()
    {
        return view();
    }

    public function doCPW()
    {
        $password_cur = input('password_cur');
        $password_new1 = input('password_new1');
        $password_new2 = input('password_new2');

        if (empty($password_cur) || empty($password_new1) || empty($password_new2)) {
            return error("Sorry,请检查输入");
        }
        if ($password_cur == $password_new1) {
            return error("Sorry,新旧密码一致");
        }
        if ($password_new1 != $password_new2) {
            return error("Sorry,确认密码不正确");
        }
        if (strlen($password_new1) < 6) {
            return error("Sorry,密码长度小于6位数");
        }
        $id = $this->getAdminId();

        $find = db("admin")->where('role', '1')->where('id', $id)
            ->where('password', md5($password_cur))->find();

        if (!$find) {
            return error("Sorry,旧密码错误");
        }

        $data['password'] = md5($password_new1);
        $data["update_at"] = date("Y-m-d H:i:s", time());
        $ret = db("admin")->where('role', '1')->where("id", "=", $id)->update($data);
        if ($ret) {
            return success("恭喜,修改成功");
        } else {
            return error("Sorry,修改失败");
        }
    }
}
