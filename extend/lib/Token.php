<?php

namespace lib;

use Firebase\JWT\JWT;

class Token
{
    /**
     * 生成JWT
     * @param  string $data
     * @return string
     */
    public static function make_jwt($data = '')
    {
        $key     = config('jwt.key');
        $time    = time();
        $timeOut = config('jwt.time_out');
        $token   = [
            "iss"  => "jwt",            //签发者,可以为空
            "aud"  => "",               //面象的用户，可以为空
            "iat"  => $time,            //签发时间
            "exp"  => $time + $timeOut, //token 过期时间
            "data" => $data,            //记录的userid的信息，这里是自已添加上去的，如果有其它信息，可以再添加数组的键值对
        ];
        $jwt = JWT::encode($token, $key);
        return $jwt;
    }

    /**
     * 解密JWT
     *
     * @param string $token
     * @return string
     */
    public static function decode($token)
    {
        $info = JWT::decode($token, config('jwt.key'), ['HS256']);
        return $info->data;
    }
}
