<?php

namespace app\admin\controller;

use PHPGangsta_GoogleAuthenticator;
use think\Controller;

class Login extends Controller
{
    private $mVerifyType = 1; // 登录验证类型:(1:谷歌验证器/2:图形验证码)

    // PHP: composer require "phpgangsta/googleauthenticator:dev-master"
    // iOS: AppStore搜索Authenticator
    // Android: GooglePlay搜索Google身份验证器或者其他安卓市场下载
    // 创建谷歌认证并记录密钥和二维码地址
    public function createGoogleAuth()
    {
        if ($this->mVerifyType == 2) {
            return 'Not Supported';
        }
        $exist  = db('sys_params')->where('key', 'GoogleAuthenticator')->value('value');
        if ($exist) {
            return 'exist';
        }

        $name       = "MyAdminAuth";
        $ga         = new PHPGangsta_GoogleAuthenticator();
        $secret     = $ga->createSecret(); //账号密钥
        $qrCodeUrl  = $ga->getQRCodeGoogleUrl($name, $secret); //密钥二维码
        $data       = array('secret' => $secret, 'qrCodeUrl' => $qrCodeUrl);

        $result     = db('sys_params')->insert(['key' => 'GoogleAuthenticator', 'value' => json_encode($data)]);
        if ($result) {
            return "success";
        }
        return "fail";
    }

    private function verifyGoogleAuth($code = '')
    {
        $ga             = new PHPGangsta_GoogleAuthenticator();
        $data           = json_decode(getSysParamsValue('GoogleAuthenticator'), true);
        $checkResult    = $ga->verifyCode($data['secret'], $code, 2); // 2 = 2*30sec clock tolerance
        if ($checkResult) {
            return true;
        }
        return false;
    }

    public function index()
    {
        $key = input('key');
        if ($key != '98k') {
            return '404';
        }
        $this->assign('mVerifyType', $this->mVerifyType);
        return view();
    }

    /*
     * 登陆接口
     */
    public function check()
    {
        $userName   = trim(input("user_name"));
        $password   = trim(input("password"));
        $code       = trim(input("code"));

        if (empty($userName) || empty($password) || empty($code)) {
            return error("输入不合法");
        }

        // 验证码
        if ($this->mVerifyType == 1) {
            if (!$this->verifyGoogleAuth($code)) {
                return error('验证码错误!');
            }
        } else {
            if (!captcha_check($code)) {
                return error("验证码错误.");
            }
        }

        $admin = db("admin")->where('role', '1')->where("user_name", $userName)->find();

        if (empty($admin) || $admin["password"] != md5($password)) {
            return error("用户名或密码错误");
        }
        if ($admin['status'] != 1) {
            return error("账户已禁用");
        }

        session("admin_loginTime", time());
        session("admin_id", $admin["id"]);
        session("admin_username", $admin["user_name"]);

        $data["last_login_time"] = date("Y-m-d H:i:s", time());
        $data["last_login_ip"] = getClientIp();
        db("admin")->where("id", $admin["id"])->update($data);
        return success('登陆成功');
    }

    /*
     * 退出登陆
     */
    public function quit()
    {
        session("admin_loginTime", null);
        session("admin_id", null);
        session("admin_username", null);
        $this->redirect("admin/login/index?key=98k");
    }
}
