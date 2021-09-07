<?php

namespace app\api\controller;

use Exception;
use lib\Token;
use think\Controller;
use think\Request;

/**
 * api接口基础类
 */
class Base extends Controller
{
    protected $user_id = 0;

    /**
     * 校验token
     * @param Request $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        // return; // j.test

        if (empty($request)) {
            exit('{"code":0,"msg":"request is null"}');
        }
        $token = $request->header('token');
        if (empty($token)) {
            exit('{"code":0,"msg":"token is null"}');
        }

        try {
            $this->user_id = Token::decode($token);

            $find = db('user')->where('id', $this->user_id)->field('status')->find();
            if ($find) {
                if ($find['status'] == 0) {
                    exit('{"code":0,"msg":"statusError"}'); //用户被封禁
                } else {
                    db('user')->where('id', $this->user_id)->update(['updated_at' => get_curr_date_time()]);
                }
            }
        } catch (Exception $e) {
            $msg = '{"code":404,"msg":"' . $e->getMessage() . '"}'; // Token失效：{"code": 0, "msg": "Expired token"}
            exit($msg);
        }
    }
}
