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

> **kafka客户端.swoole** [composer require longlang/phpkafka](https://github.com/swoole/phpkafka)

> **NSQ** [composer require nsq/nsq](https://github.com/nsqphp/nsqphp)

> **日志插件** [composer require monolog/monolog](https://www.cnblogs.com/jiqing9006/p/9233417.html)

> **TG SDK** [composer require longman/telegram-bot](https://github.com/php-telegram-bot/core)

> **PHP测试框架**[composer require --dev phpunit/phpunit](http://www.phpunit.cn/)

# [PHP](https://www.runoob.com/php/php-tutorial.html)

> [Array 函数](https://www.runoob.com/php/php-ref-array.html)

> [Date/Time 函数](https://www.runoob.com/php/php-ref-date.html)

> [String 函数](https://www.runoob.com/php/php-ref-string.html)

# PHP魔术
```php
一、魔术常量
概念：所谓的魔术常量就是PHP预定义的一些常量，这些常量会随着所在的位置而变化。
1、__LINE__  获取文件中的当前行号。
2、__FILE__  获取文件的完整路径和文件名。
3、__DIR__   获取文件所在目录。
4、__FUNCTION__  获取函数名称（PHP 4.3.0 新加）。
5、__CLASS__    获取类的名称（PHP 4.3.0 新加）。
6、__METHOD__  获取类的方法名（PHP 5.0.0 新加）。
7、__NAMESPACE__ 当前命名空间的名称（区分大小写）。
8、__TRAIT__  Trait 的名字（PHP 5.4.0 新加）。

二、超全局变量（9个）
1、$GLOBALS  ：储存全局作用域中的变量
2、$_SERVER  ：获取服务器相关信息
3、$_REQUEST ：获取POST和GET请求的参数
4、$_POST ： 获取表单的POST请求参数
5、$_GET： 获取表单的GET请求参数
6、$_FILES ：获取上传文件的的变量
7、$_ENV ： 获取服务器端环境变量的数组
8、$_COOKIE：获取浏览器的cookie
9、$_SESSION ： 获取session

三、魔术方法
__construct()，类的构造函数
__destruct()，类的析构函数
__call()，在对象中调用一个不可访问方法时调用
__callStatic()，用静态方式中调用一个不可访问方法时调用
__get()，获得一个类的成员变量时调用
__set()，设置一个类的成员变量时调用
__isset()，当对不可访问属性调用isset()或empty()时调用
__unset()，当对不可访问属性调用unset()时被调用。
__sleep()，执行serialize()时，先会调用这个函数
__wakeup()，执行unserialize()时，先会调用这个函数
__toString()，类被当成字符串时的回应方法
__invoke()，调用函数的方式调用一个对象时的回应方法
__set_state()，调用var_export()导出类时，此静态方法会被调用。
__clone()，当对象复制完成时调用
__autoload()，尝试加载未定义的类
__debugInfo()，打印所需调试信息

https://segmentfault.com/a/1190000007250604
```

# [Swoole框架](https://www.swoole.com/)

> [imi](https://www.imiphp.com/)
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