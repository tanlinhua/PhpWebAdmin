# composer已添加记录:👇

> [composer require swoole/ide-helper:@dev](https://www.cnblogs.com/houdj/p/7730147.html)

> composer require topthink/think-captcha=1.*

> composer require firebase/php-jwt

> composer require "phpgangsta/googleauthenticator:dev-master"

> [composer require topthink/think-queue=2.*](https://www.cnblogs.com/gyfluck/p/14024580.html)

# 一些可能有用的扩展:👇

> **Pay** [一个PHP文件搞定支付宝支付系列](https://github.com/dedemao/alipay)

> **Pay** [一个PHP文件搞定微信支付系列](https://github.com/dedemao/weixinPay)

> **支付扩展包** [composer require yansongda/pay -vvv](https://github.com/yansongda/pay)

> **Email** [composer require phpmailer/phpmailer](https://packagist.org/packages/phpmailer/phpmailer)

> **PHP Curl** [composer require php-curl-class/php-curl-class](https://github.com/php-curl-class/php-curl-class)

> **简单易用的HTTP请求库** [composer require mashape/unirest-php](https://github.com/Kong/unirest-php)

> **功能强大的HTTP请求库** [composer require guzzlehttp/guzzle](https://blog.csdn.net/weixin_43967933/article/details/89094935)

> **Workman** [composer require topthink/think-worker](https://www.kancloud.cn/manual/thinkphp5/235128)

> **Workman** [composer require workerman/workerman-for-win](http://doc.workerman.net/install/install.html)

> **阿里云短信** [composer require alibabacloud/dysmsapi-20170525](https://help.aliyun.com/document_detail/215762.html?spm=a2c4g.11186623.6.661.8bdb40cdR45lKi)

> **Redis** [composer require predis/predis](http://packagist.p2hp.com/packages/predis/predis)

> **ip地址定位库** [composer require zoujingli/ip2region](https://github.com/zoujingli/ip2region)

> **注解** [composer require doctrine/annotations](https://hyperf.wiki/2.1/#/zh-cn/annotation)

> **日期时间** [composer require nesbot/carbon](https://www.cnblogs.com/qinsilandiao/p/10871551.html)

> **二维码** [composer require bacon/bacon-qr-code](https://github.com/Bacon/BaconQrCode)

> **字符串处理** [composer require awssat/str-helper](https://github.com/awssat/str-helper)

> **PHP Enum** [composer require myclabs/php-enum](https://github.com/myclabs/php-enum)

> **PHP Humanizer** [composer require coduo/php-humanizer](https://github.com/coduo/php-humanizer)

> **EasySMS** [composer require overtrue/easy-sms](https://github.com/overtrue/easy-sms)

> **微信SDK** [composer require overtrue/wechat](https://github.com/overtrue/wechat)

> **电子表格** [composer require phpoffice/phpspreadsheet](https://github.com/phpoffice/phpspreadsheet)

> **kafka客户端** [composer require nmred/kafka-php](https://github.com/weiboad/kafka-php)

> **NSQ** [composer require nsq/nsq](https://github.com/nsqphp/nsqphp)

> **日志插件** [composer require monolog/monolog](https://www.cnblogs.com/jiqing9006/p/9233417.html)

> **TG SDK** [composer require longman/telegram-bot](https://github.com/php-telegram-bot/core)

# [Swoole框架](https://www.swoole.com/)

> [easyswoole](https://www.easyswoole.com/)
> [Hyperf](https://www.hyperf.io/)

# [命令行](https://www.kancloud.cn/manual/thinkphp5/122951)

> 生成类库映射文件,提高系统自动加载的性能   -> php think optimize:autoload

> 生成路由缓存,提高系统的路由检测的性能     -> php think optimize:route

> 生成数据表字段缓存,提升数据库查询的性能   -> php think optimize:schema

# 性能调试

```php
debug('begin');
// ...其他代码段
debug('end');
// ...也许这里还有其他代码
// 进行统计区间
echo debug('begin','end').'s';      // 默认的统计精度是小数点后4位 (0.0056s)
echo debug('begin','end',6).'s';    // 设置时间精度 (0.005587s)
echo debug('begin','end','m');      // 内存占用情况 (0.838KB)
```

# 漏洞
### 修复记录
```php
thinkphp\library\think\process\pipes\Windows.php
/**
 * 删除临时文件
 */
private function removeFiles()
{
    foreach ($this->files as $filename) {
        // 开始
        if (is_object($filename)) {
            continue;
        }
        // 结束
        if (file_exists($filename)) {
            @unlink($filename);
        }
    }
    $this->files = [];
}
```

### ThinkPHP < 5.0.24 远程代码执行高危漏洞
- https://www.freebuf.com/vuls/194127.html
- https://www.zhangweijiang.com/article/3.html
- https://xz.aliyun.com/t/6106