<?php

namespace lib\lock;

use lib\Redis;

class RedisMutexLock
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    /**
     * 获取分布式锁（加锁）
     * @param lockKey 锁key
     * @param requestId 客户端请求标识
     * @param expireTime 超期时间,毫秒，默认15s
     * @param isNegtive 是否是悲观锁，默认否
     * @return 是否获取成功
     */
    public function tryGetDistributedLock($lockKey, $requestId, $expireTime = 15000, $isNegtive = false)
    {
        /**
         * 悲观锁 循环阻塞式锁取，阻塞时间为2s
         */
        if ($isNegtive) {
            $endtime = microtime(true) * 1000 + $this->acquireTimeout * 1000;
            //每隔一段时间尝试获取一次锁
            while (microtime(true) * 1000 < $endtime) {
                $acquired = $this->redis->set($lockKey, $requestId, 'PX', $expireTime, 'NX');
                if ($acquired) {
                    return true; //获取锁成功，返回true
                }
                usleep(100);
            }
            //获取锁超时，返回false
            return false;
        }
        /**
         * 乐观锁 只尝试一次，成功返回true,失败返回false
         */
        else {
            $ret = $this->redis->set($lockKey, $requestId, 'PX', $expireTime, 'NX');
            if ($ret) {
                return true;
            }
            return false;
        }
    }

    /**
     * 解锁
     * @param $lockKey 锁key
     * @param $requestId 客户端请求唯一标识
     */
    public function releaseDistributedLock($lockKey, $requestId)
    {
        $luaScript = <<<EOF
            if redis.call("get",KEYS[1]) == ARGV[1]
            then
            return redis.call("del",KEYS[1])
            else
            return 0
            end
            EOF;

        $res = $this->redis->eval($luaScript, 1, $lockKey, $requestId);
        if ($res) {
            return true;
        }
        return false;
    }
}

/*
Demo:

use RedisMutexLock;

public function __construct()
{
    define("REQUEST_ID", md5(uniqid(env('APP_NAME'), true)) . rand(10000, 99999));
    $this->requestId = $_SERVER['x_request_id'] ?? REQUEST_ID;
}

// 抢单
public function addOrder()
{
    // 订单加锁
    $lock = $this->tryGetDistributedLock($this->redisOrderKey, $this->requestId);
    if (!$lock) {
        return ['error' => 1900001];
    }
    try {
        // 处理业务
    } catch (\Exception $e) {
        // 异常处理
    } finally {
        // 处理完释放锁
        $this->releaseDistributedLock($this->redisOrderKey, $this->requestId);
    }
}
*/