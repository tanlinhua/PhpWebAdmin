<?php

namespace app\api\controller;

use think\Cache;

class Test extends Base
{
    public function hello()
    {
        return 'api.test.hello';
    }

    /**
     * 发送手机验证码
     * GET api/test/sms?phone=手机号&time=时间戳&sign=md5(phone=手机号&time=时间戳&key=FUCK)[md5的字符串接是:参数按照键名进行升序排序]
     * @return json
     */
    public function sms()
    {
        //安全验证
        $result = check_api_sign(request()->param());
        if (!$result) {
            return error("fuck u");
        }

        //单IP一小时内只能访问10次
        $ip = get_client_ip();
        $count = Cache::get($ip, 0);
        if ($count >= 10) {
            return error("exit");
        }
        Cache::set($ip, $count + 1, 3600); //过期时间1小时

    }
}
