# composer已添加记录:👇

> [composer require swoole/ide-helper:@dev](https://www.cnblogs.com/houdj/p/7730147.html)

> composer require topthink/think-captcha=1.*

> composer require firebase/php-jwt

> composer require "phpgangsta/googleauthenticator:dev-master"

> [composer require topthink/think-queue=2.*](https://www.cnblogs.com/gyfluck/p/14024580.html)

# 一些可能有用的扩展:👇

> [一个PHP文件搞定支付宝支付系列](https://github.com/dedemao/alipay)

> [一个PHP文件搞定微信支付系列](https://github.com/dedemao/weixinPay)

> [composer require yansongda/pay -vvv](https://github.com/yansongda/pay)

> [composer require phpmailer/phpmailer](https://packagist.org/packages/phpmailer/phpmailer)

> [composer require guzzlehttp/guzzle](https://blog.csdn.net/weixin_43967933/article/details/89094935)

> [composer require topthink/think-worker](https://www.kancloud.cn/manual/thinkphp5/235128)

> [composer require workerman/workerman-for-win](http://doc.workerman.net/install/install.html)

> [composer require alibabacloud/dysmsapi-20170525](https://help.aliyun.com/document_detail/215762.html?spm=a2c4g.11186623.6.661.8bdb40cdR45lKi)

> [composer require predis/predis](http://packagist.p2hp.com/packages/predis/predis)

> [composer require zoujingli/ip2region](https://github.com/zoujingli/ip2region)

> [composer require doctrine/annotations](https://hyperf.wiki/2.1/#/zh-cn/annotation)

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

# 漏洞记录
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

# TODO:

> 整理以往一些有用的控件及函数->admin Demo模块