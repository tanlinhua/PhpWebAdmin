<?php

namespace app\api\controller;

use think\Cache;
use think\Validate;

/**
 * 用户
 */
class User
{
    /**
     * 用户注册
     * @method POST api/user/reg
     * @param DATA phone=手机&password=密码&code=短信验证码&device_type=设备类型:1安卓2苹果&device_info=设备详情&device_key=设备ID
     * @return json
     */
    public function reg()
    {
        $data = request()->param();

        $rule = [
            'phone'         =>  'require',
            'password'      =>  'require|min:6|max:32',
            'code'          =>  'require|number',
            'device_type'   =>  'require|in:1,2',
            'device_info'   =>  'require|max:255',
            'device_key'    =>  'require|max:255',
        ];
        $validate = new Validate($rule);
        if (!$validate->check($data)) {
            return error($validate->getError());
        }

        $phone = $data['phone'];

        $code = Cache::get("sms{$phone}");
        //$code = '88888'; // j.test
        if (empty($code) || $data['code'] != $code) {
            return error(lang('wrong verification code'));
        }

        $save = [
            'phone'         =>  $phone,
            'password'      =>  md5($data['password']),
            'status'        =>  1,
            'reg_ip'        =>  get_client_ip(),
            'device_type'   =>  $data['device_type'],
            'device_info'   =>  $data['device_info'],
            'device_key'    =>  $data['device_key'],
        ];

        $ret = db('user')->insertGetId($save);
        if ($ret) {
            return success(lang('success'));
        }
        return error(lang('fail'));
    }

    /**
     * 用户登录
     * @method POST api/user/login
     * @param  DATA phone=手机&password=密码(小写MD5值)
     * @return json
     */
    public function login()
    {
        $data = request()->param();

        $rule = [
            'phone'         =>  'require|number',
            'password'      =>  'require|min:6|max:32',
        ];
        $validate = new Validate($rule);
        if (!$validate->check($data)) {
            return error($validate->getError());
        }

        $phone = $data['phone']; //preg_replace('/^0*/', '', $data['phone']);
        if (empty($phone) || empty($data['password'])) {
            return error(lang('phone number or password is required'));
        }

        $query = db('user')->where('phone', $phone)->find();
        if (!empty($query)) {
            if ($query['status'] == 0) {
                return error(lang('status error'));
            }
            if ($data['password'] != $query['password']) {
                return error(lang('the login password is incorrect'));
            }
        } else {
            return error(lang('user does not exist'));
        }

        // 更新最后登录时间及IP
        $update['last_login_time'] = get_curr_date_time();
        $update['last_login_ip'] = get_client_ip();
        db('user')->where('phone', $phone)->update($update);

        return success(lang('login success'), make_jwt($query['id']));
    }

    /**
     * 修改密码
     * POST api/user/cpwd
     * @param DATA phone=手机&password=当前密码&new1=新密码&new2=确认密码
     * @return json
     */
    public function cpwd()
    {
        $data = request()->param();
        $rule = [
            'phone'     =>  'require|number',
            'password'  =>  'require',
            'new1'      =>  'require|min:6|max:32',
            'new2'      =>  'require|confirm:new1',
        ];
        $validate = new Validate($rule);
        if (!$validate->check($data)) {
            return error($validate->getError());
        }

        $password = db('user')->where('phone', $data['phone'])->value('password');
        if (md5($data['password']) != $password) {
            return error('当前密码错误');
        }

        $ret = db('user')->where('phone', $data['phone'])->update(['password' => md5($data['new1'])]);
        if ($ret) {
            return error(lang('success'));
        }
        return error(lang('fail'));
    }

    /**
     * 忘记密码
     * POST api/user/forget
     * @param DATA phone=手机&code=短信验证码&password=新密码
     * @return json
     */
    public function forget()
    {
        $data = request()->param();

        $rule            = [
            'phone'     => 'require|number',
            'code'      => 'require|number',
            'password'  => 'require|min:6',
        ];
        $validate = new Validate($rule);
        if (!$validate->check($data)) {
            return error($validate->getError());
        }

        $phone = $data['phone'];
        // $phone = preg_replace('/^0*/', '', $phone);//去0
        if (!is_phone_china($phone)) {
            return error(lang('wrong number'));
        }

        $code = Cache::get("sms{$phone}");
        // $code = '88888'; // j.test
        if (empty($code) || $data['code'] != $code) {
            return error(lang('wrong verification code'));
        }

        $user_id = db('user')->where('phone', $phone)->value('id');
        if (empty($user_id)) {
            return error(lang('user does not exist'));
        }

        $ret = db('user')->where('phone', $phone)->update(['password' => md5($data['password'])]);
        if ($ret) {
            db('user_track')->insert(['user_id' => $user_id, 'admin_id' => 0, 'content' => '用户通过短信验证码重置新密码:' . $data['password']]);
            return success(lang('success'));
        }
        return error(lang('success'));
    }
}
