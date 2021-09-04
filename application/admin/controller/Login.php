<?php

namespace app\admin\controller;

use PHPGangsta_GoogleAuthenticator;
use think\Controller;
use think\Request;
use think\Validate;

class Login extends Controller
{
    private $google;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->google = config("admin.google");
    }

    // 创建谷歌认证并记录密钥和二维码地址
    public function createGoogleAuth()
    {
        if (!$this->google) {
            return 'Not Supported';
        }
        $exist  = db('sys_params')->where('key', 'GoogleAuthenticator')->value('value');
        if ($exist) {
            return 'exist';
        }

        $name      = "MyAdminAuth";
        $ga        = new PHPGangsta_GoogleAuthenticator();
        $secret    = $ga->createSecret();                                    //账号密钥
        $qrCodeUrl = $ga->getQRCodeGoogleUrl($name, $secret);                //密钥二维码
        $data      = array('secret' => $secret, 'qrCodeUrl' => $qrCodeUrl);

        $result     = db('sys_params')->insert([
            'key' => 'GoogleAuthenticator',
            'value' => json_encode($data), 'remarks' => 'Google身份验证器'
        ]);

        if ($result) {
            return "success";
        }
        return "fail";
    }

    /**
     * Google身份验证器校验
     *
     * @param string $code
     * @return bool
     */
    private function verifyGoogleAuth($code = '')
    {
        $ga          = new PHPGangsta_GoogleAuthenticator();
        $data        = json_decode(get_sys_params_value('GoogleAuthenticator'), true);
        $checkResult = $ga->verifyCode($data['secret'], $code, 2); // 2 = 2*30sec clock tolerance

        if ($checkResult) {
            return true;
        }
        return false;
    }

    /**
     * 登录页面
     *
     * @return view
     */
    public function index()
    {
        $this->assign('google', $this->google ? "true" : "false");
        return view('main/login');
    }

    /*
     * 登陆校验
     */
    public function check()
    {
        $userName = trim(input("user_name"));
        $password = trim(input("password"));
        $code     = trim(input("code"));
        $token    = trim(input("__token__"));
        $g_code   = trim(input("g_code"));

        if ($this->google == true) {
            if (!$this->verifyGoogleAuth($g_code)) {
                return error('安全码错误!');
            }
        }

        $rules = [
            'user_name|用户名' => 'require',
            'password|密码'   => 'require',
            'code|验证码'      => 'require|captcha',
            '__token__|令牌'  => 'require|token',
        ];
        $datas = [
            'user_name' => $userName,
            'password'  => $password,
            'code'      => $code,
            '__token__' => $token,
        ];

        $validate = new Validate($rules);
        $result = $validate->check($datas);
        if (!$result) {
            return error($validate->getError());
        }
        // if (!captcha_check($code)) {
        //     return error("验证码错误.");
        // }

        $admin = db("admin")->where("user_name", $userName)->find();

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
        $data["last_login_ip"] = get_client_ip();
        db("admin")->where("id", $admin["id"])->update($data);
        return success('登录成功');
    }

    /*
     * 退出登陆
     */
    public function quit()
    {
        session("admin_loginTime", null);
        session("admin_id", null);
        session("admin_username", null);
        $this->success("退出成功", "/admin/login");
    }
}
