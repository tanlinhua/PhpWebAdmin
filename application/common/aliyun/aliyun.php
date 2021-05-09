<?php

namespace app\common\aliyun;

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

/**
 * 阿里云
 * composer require alibabacloud/client
 * https://api.aliyun.com  检索产品:Short Message Service/Alibaba Content Security Service
 */
class Aliyun
{
    private $accessKey;
    private $accessSecret;
    private $TemplateCode;
    private $SignName;
    private $seed;

    public function __construct()
    {
        $this->accessKey = config('aliyun.accessKey');
        $this->accessSecret = config('aliyun.accessSecret');
        $this->TemplateCode = config('aliyun.TemplateCode');
        $this->SignName = config('aliyun.SignName');
        $this->seed = config('aliyun.seed');
    }

    /**
     * 发送【阿里云】短信验证码
     * @param string $phone
     * @param int $code
     * @return boolean
     */
    public function sendSms($phone, $code)
    {
        if (empty($code)) {
            return false;
        }
        if (empty($phone)) {
            return false;
        }
        AlibabaCloud::accessKeyClient($this->accessKey, $this->accessSecret)->regionId('cn-hangzhou')->asDefaultClient();

        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => $phone,
                        'SignName' => $this->SignName,
                        'TemplateCode' => $this->TemplateCode,
                        'TemplateParam' => '{"code":"' . $code . '"}',
                    ],
                ])->request();

            if ($result->toArray()['Code'] == 'OK') {
                return true;
            } else {
                trace($result->toArray(), 'error');
                return false;
            }
        } catch (ClientException $e) {
            trace($e->getErrorMessage(), 'error');
            return false;
        } catch (ServerException $e) {
            trace($e->getErrorMessage(), 'error');
            return false;
        }
    }

    /**
     * 视频内容检测
     * @param string $url
     * @return string or bool 成功返回taskid，否则返回false
     */
    public function scanVideo($url = '')
    {
        $callback = 'http://' . $_SERVER['HTTP_HOST'] . '/api/scan/notify';

        $task = array('url' => $url, 'interval' => 3);

        $body = array(
            "tasks"     =>  array($task),
            "scenes"    =>  array("porn"),
            'callback'  =>  $callback,
            'seed'      =>  $this->seed
        );
        $body = json_encode($body);

        AlibabaCloud::accessKeyClient($this->accessKey, $this->accessSecret)->regionId('cn-hangzhou')->asDefaultClient();
        try {
            $result = AlibabaCloud::roa()
                ->product('Green')
                ->version('2018-05-09')
                ->pathPattern('/green/video/asyncscan')
                ->method('POST')
                ->options(['query' => [],])
                ->body($body)
                ->request();

            $resultArr = $result->toArray();
            if ($resultArr['code'] == 200) {
                $taskId = array_column($resultArr['data'], 'taskId');
                return $taskId[0];
            } else {
                trace('AliCloud.asyncscan.code!=200', 'error');
                trace($result->toArray(), 'error');
                return false;
            }
        } catch (ClientException $e) {
            trace($e->getErrorMessage(), 'error');
            return false;
        } catch (ServerException $e) {
            trace($e->getErrorMessage(), 'error');
            return false;
        }
    }
}
