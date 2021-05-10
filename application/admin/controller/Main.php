<?php

namespace app\admin\controller;

class Main extends Base
{
    /*
     * 后台首页
     */
    public function main()
    {
        // $testData = `[{"id":1,"title":"主页","uri":"/admin/main","icon":"xe68e;","checked":false,"spread":true,"children":[{"id":2,"title":"控制台","uri":"/admin/console","icon":"","checked":false,"spread":true,"children":[{"id":3,"title":"修改密码","uri":"/admin/cpw","icon":"","checked":true,"spread":false,"children":null}]}]},{"id":4,"title":"权限配置","uri":"","icon":"xe672;","checked":false,"spread":true,"children":[{"id":5,"title":"用户管理","uri":"/admin/adm/view","icon":"","checked":false,"spread":true,"children":[{"id":6,"title":"增加用户","uri":"/admin/adm/add","icon":"","checked":true,"spread":false,"children":null},{"id":7,"title":"删除用户","uri":"/admin/adm/del","icon":"","checked":true,"spread":false,"children":null},{"id":8,"title":"修改用户","uri":"/admin/adm/update","icon":"","checked":true,"spread":false,"children":null},{"id":9,"title":"查询用户","uri":"/admin/adm/get","icon":"","checked":true,"spread":false,"children":null}]},{"id":10,"title":"角色管理","uri":"/admin/role/view","icon":"","checked":false,"spread":true,"children":[{"id":11,"title":"增加角色","uri":"/admin/role/add","icon":"","checked":true,"spread":false,"children":null},{"id":12,"title":"删除角色","uri":"/admin/role/del","icon":"","checked":true,"spread":false,"children":null},{"id":13,"title":"修改角色","uri":"/admin/role/update","icon":"","checked":true,"spread":false,"children":null},{"id":14,"title":"查询角色","uri":"/admin/role/get","icon":"","checked":true,"spread":false,"children":null}]},{"id":15,"title":"权限管理","uri":"/admin/per/view","icon":"","checked":false,"spread":true,"children":[{"id":16,"title":"查询权限","uri":"/admin/per/get","icon":"","checked":true,"spread":false,"children":null}]}]},{"id":17,"title":"系统配置","uri":"","icon":"xe716;","checked":false,"spread":true,"children":[{"id":18,"title":"系统参数","uri":"/admin/params/view","icon":"","checked":false,"spread":true,"children":[{"id":19,"title":"增加参数","uri":"/admin/params/add","icon":"","checked":true,"spread":false,"children":null},{"id":20,"title":"删除参数","uri":"/admin/params/del","icon":"","checked":true,"spread":false,"children":null},{"id":21,"title":"修改参数","uri":"/admin/params/update","icon":"","checked":true,"spread":false,"children":null},{"id":22,"title":"查询参数","uri":"/admin/params/get","icon":"","checked":true,"spread":false,"children":null}]}]},{"id":24,"title":"用户管理","uri":"test","icon":"xe770;","checked":false,"spread":true,"children":[{"id":25,"title":"用户列表","uri":"/admin/user/view","icon":"test","checked":false,"spread":true,"children":[{"id":26,"title":"查询用户","uri":"/admin/user/get","icon":"test","checked":true,"spread":false,"children":null},{"id":27,"title":"删除用户","uri":"/admin/user/del","icon":"test","checked":true,"spread":false,"children":null}]}]}]`;
        //根据角色ID获取后台菜单tree data,考虑是否用model
        // $this->assign('menuTree', $testData);


        $this->assign("adminName", session("admin_username"));
        return view();
    }
    /*
    {foreach $menuTree as $item}
    {eq name=$item.checked value="true"}
    <li class="layui-nav-item">
        <a href="javascript:;">
            <i class="layui-icon">&#{{ $item.icon }}</i>
            <em>{{ $item.name }}</em>
        </a>
        <dl class="layui-nav-child">
            {foreach $item.children as $tmp}
            <dd><a href="{$item.uri}">{{$item.name}}</a></dd>
            {/foreach}
        </dl>
    </li>
    {/eq}
    {/foreach}
    */

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
