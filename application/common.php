<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use Firebase\JWT\JWT;
use think\Cache;

/**
 * 响应成功的json数据
 *
 * @param  string $msg
 * @param  string $data
 * @return json
 */
function success($msg = '', $data = '')
{
    $data = array('code' => 1, 'msg' => $msg, 'data' => $data);
    return json($data);
}

/**
 * 响应失败的json数据
 *
 * @param  string $str
 * @return json
 */
function error($str = '')
{
    $data = array('code' => 0, 'msg' => $str);
    return json($data);
}

/**
 * 获取IP
 *
 * @return string
 */
function getClientIp()
{
    if (!empty($_SERVER["HTTP_CLIENT_IP"])) {
        $cip = $_SERVER["HTTP_CLIENT_IP"];
    } else if (!empty($_SERVER["HTTP_X_FORWARDED_FOR"])) {
        $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
    } else if (!empty($_SERVER["REMOTE_ADDR"])) {
        $cip = $_SERVER["REMOTE_ADDR"];
    } else {
        $cip = '';
    }
    preg_match("/[\d\.]{7,15}/", $cip, $cips);
    $cip = isset($cips[0]) ? $cips[0] : 'unknown';
    unset($cips);

    return $cip;
}

/**
 * 获取当前时间
 * 
 * @return dateTime
 */
function getCurrDateTime()
{
    return date("Y-m-d H:i:s", time());
}

/**
 * 验证是否手机号
 * 
 * @param string $phone
 * @return boolean
 */
function isPhone($phone = '')
{
    $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
    if (preg_match($search, $phone)) {
        return (true);
    } else {
        return (false);
    }
}

/**
 * 生成随机字符串
 *
 * @param int $length
 * @return string
 */
function makeRandomString($length = 8)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str); //打乱字符串
    $rands = substr($randStr, 0, $length); //substr(string,start,length);返回字符串的一部分
    return $rands;
}

/**
 * 生成JWT
 * @param  string $data
 * @return jwt
 */
function makeJWT($data = '')
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
 * 生成唯一订单号
 * 
 * @return 订单编号
 */
function makeOrderNo()
{
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d', rand(0, 9999));
    $orderSn = $orderSn . time();
    return $orderSn;
}

/**
 * 获取系统配置表的value值
 *
 * @param  string   $key
 * @return string
 */
function getSysParamsValue($key)
{
    $value = db("sys_params")->where("key", "{$key}")->value('value');
    return $value;
}

/**
 * 导入CSV数据
 *
 * @param string $filePath -> $filePath = 'uploads' . DS . $info->getSaveName();
 * @return array
 */
function csvGet($filePath)
{
    $handle = fopen($filePath, 'r');

    $out = array();
    $n = 0;
    while ($data = fgetcsv($handle, 10000)) {
        $num = count($data);
        for ($i = 0; $i < $num; $i++) {
            $out[$n][$i] = $data[$i];
        }
        $n++;
    }
    return $out;
}

/**
 * 导出csv数据
 *
 * @param string $filename
 * @param array $data
 * @return void
 */
function csvOut($filename, $data)
{
    $filename = $filename . '-' . date("YmdHis", time()) . '-导出.csv'; //文件名
    header("Content-type:text/csv");
    header("Content-Disposition:attachment;filename=" . $filename);
    header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
    header('Expires:0');
    header('Pragma:public');
    echo $data;
}

/**
 * 加密
 * 
 * @param string $str 原始字符串
 * @param string md5($key)
 * @param string md5($iv)
 * @return string
 */
function encryptString($str, $key = "ak47", $iv = "m416")
{
    $base = base64_encode(openssl_encrypt($str, 'aes-128-cbc', substr(md5($key), 0, 16), true, substr(md5($iv), 0, 16)));
    return $base;
}

/**
 * 解密
 * 
 * @param string $encryptedText 加密字符串
 * @param string md5($key)
 * @param string md5($iv)
 * @return String
 */
function decryptString($encryptedText,  $key = "ak47", $iv = "m416")
{
    $str = openssl_decrypt(base64_decode($encryptedText), 'aes-128-cbc', substr(md5($key), 0, 16), true, substr(md5($iv), 0, 16));
    return $str;
}

/**
 * 将任务数据加入到 redis list
 *
 * @param string $taskId
 * @param array $datas
 * @return void
 */
function setRedisList($taskId, $datas)
{
    $redis  = Cache::getHandler();
    $key    = "Task" . $taskId;
    foreach ($datas as $phone) {
        $result = $redis->rPush($key, $phone);
    }
    trace("新增RedisList:$key,length=$result", 'notice');
}

/**
 * 获取redis list中的的值(删除并返回队列中的头元素)
 *
 * @param string $taskId
 * @return string
 */
function getRedisList($taskId)
{
    $redis      = Cache::getHandler();
    $redisKey   = "Task" . $taskId;
    $value      = $redis->lPop($redisKey);
    return $value;
}

/**
 * 清空 redis list 数据
 *
 * @param string $taskId
 * @return void
 */
function cleanRedisList($taskId)
{
    $redis  = Cache::getHandler();
    $key    = "Task" . $taskId;
    $result = $redis->lTrim($key);
    if ($result) {
        trace("删除RedisList:$key 成功", 'notice');
    } else {
        trace("删除RedisList:$key 失败", 'notice');
    }
}

/**
 * 发送网络请求
 *
 * @param  string  $url
 * @param  string  or        array $params
 * @param  string  $method
 * @param  string  $head
 * @param  boolean $https
 * @return array
 */
function do_curl($url, $params, $method = 'POST', $head = "FORM", $https = true)
{
    $query_string = is_array($params) ? http_build_query($params) : $params;
    $curl         = curl_init();

    if ($head == 'FORM') {
        $headers = array('Content-Type:application/x-www-form-urlencoded');
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    } else

    if ($head == 'JSON') {
        $headers = array("Content-Type:application/json;charset=UTF-8");
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    if ('GET' == $method) {
        $geturl = $query_string ? $url . (stripos($url, "?") !== false ? "&" : "?") . $query_string : $url;
        curl_setopt($curl, CURLOPT_URL, $geturl);
    } else {

        if ($method == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
        } else {
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $query_string);
    }

    if ($https) {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
    }

    curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                         // 自动设置Referer
    curl_setopt($curl, CURLOPT_TIMEOUT, 30);                            // 设置超时限制防止死循环
    curl_setopt($curl, CURLOPT_HEADER, 0);                              // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);                      // 获取的信息以文件流的形式返回

    $ret = curl_exec($curl);
    $err = curl_error($curl);

    if (false === $ret || !empty($err)) {
        $errno = curl_errno($curl);
        curl_close($curl);
        trace('do_curl.err=' . $err, 'error');
        return ['ret' => false, 'msg' => $errno . ':' . $err];
    }

    curl_close($curl);
    return ['ret' => true, 'data' => $ret];
}