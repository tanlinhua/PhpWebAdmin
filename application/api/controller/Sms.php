<?php

namespace app\api\controller;

use think\Cache;

/**
 * 短信
 */
class Sms
{
    /**
     * 发送手机验证码
     * GET api/sms/send?phone=手机号&time=时间戳&sign=md5(phone=手机号&time=时间戳&key=FUCK) [md5的字符串接是:参数按照键名进行升序排序]
     * @return \think\response\Json
     */
    public function send()
    {
        // 接口安全验证
        $result = check_api_sign(request()->param());
        if (!$result) {
            trace("checkSign Error", "error");
            return error("error");
        }

        // IP限制,一小时内只能访问10次
        $ip = get_client_ip();
        $count = Cache::get($ip, 0);
        if ($count >= 10) {
            return error("exit");
        }
        Cache::set($ip, $count + 1, 3600); //过期时间1小时

        // 校验号码
        $phone = request()->param('phone');
        if (empty($phone)) {
            return error(lang('wrong number'));
        }
        // $phone = preg_replace('/^0*/', '', $phone); //去0
        if (!is_phone_china($phone)) {
            return error(lang('wrong number'));
        }

        // 发送内容
        $code = rand(10000, 99999);
        $content = $this->getCodeContent($code);
        if (empty($content)) {
            return error('content null');
        }

        //执行发送
        $result = $this->sendSms($phone, $content);

        if (!$result) {
            return error(lang('fail'));
        }
        Cache::set("sms{$phone}", $code, 300);
        return success(lang('success'));
    }

    // 获取短信内容
    private function getCodeContent($code): string
    {
        return "验证码:$code,5分钟有效期";
    }

    // 发送
    private function sendSms($phone, $content): bool
    {
        $sms_code_channel = get_sys_params_value('sms_code_channel'); //后台配置短信验证码通道
        //根据配置通道调用指定func
        return false;
    }
}
