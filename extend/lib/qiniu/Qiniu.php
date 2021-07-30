<?php

namespace lib\qiniu;

use Qiniu\Auth;
use Qiniu\Config;
use Qiniu\Storage\BucketManager;

/**
 * 七牛云
 * composer require qiniu/php-sdk
 */
class Qiniu
{
    private $accessKey; //AK
    private $secretKey; //SK
    private $bucketName; //对象存储-空间名称
    private $ossHost; //存储空间绑定的域名

    private $auth;
    private $bucketManager;

    public function __construct()
    {
        $this->accessKey = config('qiniu.accessKey');
        $this->secretKey = config('qiniu.secretKey');
        $this->bucketName = config('qiniu.bucketName');
        $this->ossHost = config('qiniu.ossHost');

        $this->auth = new Auth($this->accessKey, $this->secretKey);
        $config = new Config();
        $this->bucketManager = new BucketManager($this->auth, $config);
    }

    /**
     * 删除存储空间中指定的文件
     * @param string 文件名
     * @return boolean true or false
     */
    public function deleteFile($fileName = '')
    {
        $err = $this->bucketManager->delete($this->bucketName, $fileName); //成功返回空，失败返回object
        if (empty($err)) {
            return true;
        } else {
            trace($err, 'notice');
            return false;
        }
    }

    /**
     * 批量删除文件
     * @param array $fileNames 每次最多不能超过1000个
     * @return int $count 成功删除多少个文件
     */
    public function deleteFileBatch($fileNames = '')
    {
        $count = 0;

        if (empty($fileNames)) {
            return $count;
        }
        $ops = $this->bucketManager->buildBatchDelete($this->bucketName, $fileNames);
        $result = $this->bucketManager->batch($ops);
        $ret = $result[0];
        foreach ($ret as $item) {
            if ($item['code'] == 200) {
                $count++;
            }
        }
        if ($count == 0) {
            trace($result, 'notice');
        }
        return $count;
    }

    /**
     * 获取七牛OSS文件预览链接
     */
    public function getFileUrl($fileName = '')
    {
        if (empty($fileName)) {
            return null;
        }
        $url = $this->ossHost . $fileName;
        return $this->auth->privateDownloadUrl($url, 10800);
    }

    /**
     * 获取7牛OSS上传Token
     */
    public function getUploadToken()
    {
        return $this->auth->uploadToken($this->bucketName);
    }
}
