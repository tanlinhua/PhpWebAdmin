<?php

// 应用公共文件

if (!function_exists('success')) {
    /**
     * 响应成功的json数据
     *
     * @param string $msg
     * @param int $count 数据总数 -> for layui
     * @param array $data
     * @return  think\response\Json
     */
    function success(string $msg = 'success', int $count = 0, array $data = array()): \think\response\Json
    {
        $data = array('code' => 0, 'msg' => $msg, 'count' => $count, 'data' => $data);
        return json($data);
    }
}

if (!function_exists('error')) {
    /**
     * 响应失败的json数据
     *
     * @param string $msg
     * @param int $code
     * @return think\response\Json
     */
    function error(string $msg = 'fail', int $code = -1): \think\response\Json
    {
        $data = array('code' => $code, 'msg' => $msg, 'count' => 0, 'data' => null);
        return json($data);
    }
}

if (!function_exists('encrypt_string')) {
    /**
     * 加密方法:aes-128-cbc转base64字符串
     * aes-128-cbc.key = md5(key)前16位
     * aes-128-cbc.iv = md5(iv)前16位
     * 
     * @param string $str   原始字符串
     * @param string $key   字符串KEY
     * @param string $iv    字符串IV
     * @return string
     */
    function encrypt_string(string $str, string $key = "ak47", string $iv = "m416"): string
    {
        return base64_encode(openssl_encrypt($str, 'aes-128-cbc', substr(md5($key), 0, 16), true, substr(md5($iv), 0, 16)));
    }
}

if (!function_exists('decrypt_string')) {
    /**
     * 解密:base64字符串解密后aes-128-cbc解密
     * aes-128-cbc.key = md5(key)前16位
     * aes-128-cbc.iv = md5(iv)前16位
     * 
     * @param string $encryptedText 加密字符串
     * @param string $key   字符串KEY
     * @param string $iv    字符串IV
     * @return String
     */
    function decrypt_string(string $encryptedText, string $key = "ak47", string $iv = "m416"): string
    {
        return openssl_decrypt(base64_decode($encryptedText), 'aes-128-cbc', substr(md5($key), 0, 16), true, substr(md5($iv), 0, 16));
    }
}

if (!function_exists('is_empty')) {
    /**
     * 判断空
     */
    function is_empty($var): bool
    {
        if (is_null($var)) {
            return true;
        } else if (is_string($var)) {
            return trim($var) === '';
        } else if (is_array($var)) {
            return empty($var);
        } else if (is_object($var)) {
            try {
                if (method_exists($var, 'isEmpty')) { // isEmpty
                    return $var->isEmpty();
                } else if (method_exists($var, 'toArray')) { // toArray
                    return empty($var->toArray());
                } else { // Conversion to Array
                    return 0 === count((array) $var);
                }
            } catch (\Exception $e) { // PHP 5.x
                return false;
            } catch (\Throwable $e) { // PHP 7.x
                return false;
            }
        }
        return false;
    }
}

if (!function_exists('get_client_ip')) {
    /**
     * 获取IP
     *
     * @return string
     */
    function get_client_ip(): string
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
        $cip = $cips[0] ?? 'unknown';
        unset($cips);

        return $cip;
    }
}

if (!function_exists('get_curr_date_time')) {
    /**
     * 获取当前时间
     * 
     * @return false|string
     */
    function get_curr_date_time()
    {
        return date("Y-m-d H:i:s", time());
    }
}

if (!function_exists('is_phone_china')) {
    /**
     * 验证是否手机号
     * 
     * @param string $phone
     * @return boolean
     */
    function is_phone_china(string $phone): bool
    {
        $search = '/^0?1[3|4|5|6|7|8][0-9]\d{8}$/';
        if (preg_match($search, $phone)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('make_random_string')) {
    /**
     * 生成随机字符串
     *
     * @param int $length
     * @return string
     */
    function make_random_string(int $length = 8): string
    {
        $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
        $randStr = str_shuffle($str); //打乱字符串
        return substr($randStr, 0, $length); //substr(string,start,length);返回字符串的一部分
    }
}

if (!function_exists('make_order_number')) {
    /**
     * 生成唯一订单号
     * 
     * @return string
     */
    function make_order_number(): string
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%04d', rand(0, 9999));
        return $orderSn . time();
    }
}

if (!function_exists('get_sys_params_value')) {
    /**
     * 获取系统配置表的value值
     *
     * @param string $key
     * @return string
     */
    function get_sys_params_value(string $key): string
    {
        $value = db("sys_params")->where("key", "{$key}")->value('value');
        $value = stripslashes($value);
        return htmlspecialchars_decode($value);
    }
}

if (!function_exists('csv_input')) {
    /**
     * 导入CSV数据
     *
     * @param string $filePath -> $filePath = 'uploads' . DS . $info->getSaveName();
     * @return array
     */
    function csv_input(string $filePath): array
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
}

if (!function_exists('csv_output')) {
    /**
     * 导出csv数据
     *
     * @param string $filename
     * @param array $data
     * @return void
     */
    function csv_output(string $filename, array $data)
    {
        $filename = $filename . '-' . date("YmdHis", time()) . '-导出.csv'; //文件名
        header("Content-type:text/csv");
        header("Content-Disposition:attachment;filename=" . $filename);
        header('Cache-Control:must-revalidate,post-check=0,pre-check=0');
        header('Expires:0');
        header('Pragma:public');
        echo $data;
    }
}

if (!function_exists('do_curl')) {
    /**
     * CURL发送网络请求
     *
     * @param  string       $url
     * @param  string|array $params json string | array
     * @param  string       $method GET|POST
     * @param  string       $type   FORM|JSON
     * @param  boolean      $https  true or false
     * @param  array        $header $header=array('x-api-key:1', 'b:2');
     * @return array        $response
     */
    function do_curl($url, $params, $method = 'POST', $type = "FORM", $https = true, $header = [])
    {
        $response     = array("result" => true, "msg" => "ok", "data" => null);
        $curl         = curl_init();
        $query_string = is_array($params) ? http_build_query($params) : $params;

        // 设置 http head
        if ($type == 'FORM') {
            $tmp = array('Content-Type:application/x-www-form-urlencoded;charset=UTF-8');
        } else if ($type == 'JSON') {
            $tmp = array("Content-Type:application/json;charset=UTF-8");
        }
        $headers = array_merge($tmp, $header);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        // 设置 http method
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
        // 设置 https
        if ($https) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检查
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0); // 从证书中检查SSL加密算法是否存在
        }
        // 其他配置
        curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']); // 模拟用户使用的浏览器
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                         // 自动设置Referer
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);                            // 设置超时限制防止死循环
        curl_setopt($curl, CURLOPT_HEADER, 0);                              // 显示返回的Header区域内容
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);                      // 获取的信息以文件流的形式返回
        // 执行请求
        $data = curl_exec($curl);
        // 处理响应
        $err = curl_error($curl);
        if (false === $data || !empty($err)) {
            $errno = curl_errno($curl);
            trace("do_curl.url=$url,errno=$errno,err=$err", "error");
            $response['result'] = false;
            $response['msg'] = $errno . ':' . $err;
        }
        curl_close($curl);
        $response['data'] = $data;
        return $response;
    }
}

if (!function_exists('array_filter_empty_string')) {
    /**
     * 过滤数组空字符串值(删除空值key)
     * @param array $arr
     * @return array $allowArr
     */
    function array_filter_empty_string(array $arr): array
    {
        $allowArr = [];

        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                if ((is_string($v) && '' !== $v) || !is_string($v)) {
                    $allowArr[$k] = $v;
                }
            }
        }
        return $allowArr;
    }
}

if (!function_exists('check_api_sign')) {
    /**
     * 接口校验
     *
     * @param array $param
     * @return bool
     */
    function check_api_sign(array $param = []): bool
    {
        $signKey = "FUCK"; //接口验证key
        $result = false;
        $signStr = '';

        if (!isset($param['sign'])) {
            return $result;
        }
        $sign = $param['sign'];
        unset($param['sign']);
        ksort($param);

        if (is_array($param)) {
            foreach ($param as $key => $value) {
                if ($value == '') {
                    continue;
                }
                $signStr .= $key . '=' . $value . '&';
            }
            // $signKey = rtrim($signKey, '&');
        }
        $signStr .= "key=$signKey";
        $newSign = md5($signStr);

        if (strcmp($sign, $newSign) == 0) {
            $result = true;
        }

        return $result;
    }
}

if (!function_exists('save_upload_file')) {
    /**
     * 保存上传文件并返回本地存储路径
     * @param \think\File $file   [request()->file('img')]
     * @param string $ext    文件后缀，多个用逗号分割或者数组
     * @param string $type   文件MIME类型，多个用逗号分割或者数组
     * @return  string      $uri    存储路径
     */
    function save_upload_file(\think\File $file, string $ext = 'jpg,png,gif,bmp,jpeg', string $type = 'image/png,image/jpeg,image/gif,image/bmp')
    {
        $uri = '';
        $folder = 'uploads';
        $info = $file->validate(['ext' => $ext, 'type' => $type])->move(ROOT_PATH . 'public' . DS . $folder);

        if ($info) {
            $uri = $folder . DS . $info->getSaveName();
        } else {
            $error = $file->getError();
            trace('saveUploadFile.Error=' . $error, 'error');
            return null;
        }
        return $uri;
    }
}

if (!function_exists('emoji_filter')) {
    /**
     * 过滤掉emoji表情
     *
     * @param string $source
     * @return  string $str
     */
    function emoji_filter(string $source): string
    {
        return preg_replace_callback('/./u', function (array $match) {
            return strlen($match[0]) >= 4 ? '' : $match[0];
        }, $source);
    }
}

if (!function_exists('xss_clean')) {
    /**
     * 清理XSS
     */
    function xss_clean($content, $is_image = false)
    {
        return \lib\Security::instance()->xss_clean($content, $is_image);
    }
}

if (!function_exists('http_host')) {
    /**
     * 获取当前域名,包含端口
     *
     * @return string
     */
    function http_host(): string
    {
        $http_type = (
            (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on')
            || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
            || ($_SERVER['SERVER_PORT'] == 443)) ? 'https://' : 'http://';

        return $http_type . $_SERVER['HTTP_HOST'];
    }
}

if (!function_exists('http_host')) {
    /**
     * 生成uuid
     */
    function uuid(): string
    {
        $chars = md5(uniqid(mt_rand(), true));
        return substr($chars, 0, 8) . '-'
            . substr($chars, 8, 4) . '-'
            . substr($chars, 12, 4) . '-'
            . substr($chars, 16, 4) . '-'
            . substr($chars, 20, 12);
    }
}
