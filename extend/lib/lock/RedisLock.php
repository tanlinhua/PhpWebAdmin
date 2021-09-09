<?php

namespace lib\lock;

use lib\Redis;

class RedisLock
{
    private $redis;

    public function __construct()
    {
        $this->redis = new Redis();
    }

    /**
     * 获取锁
     * @param  string  $key    锁标识
     * @param  int     $expire 锁过期时间
     * @param  int     $num    重试次数
     * @return bool
     */
    public function lock($key, $expire = 5, $num = 0)
    {
        $is_lock = $this->redis->setnx($key, time() + $expire);

        if (!$is_lock) {
            //获取锁失败则重试{$num}次
            for ($i = 0; $i < $num; $i++) {
                $is_lock = $this->redis->setnx($key, time() + $expire);
                if ($is_lock) {
                    break;
                }
                usleep(100);
            }
        }

        // 不能获取锁
        if (!$is_lock) {
            // 判断锁是否过期
            $lock_time = $this->redis->get($key);
            // 锁已过期，删除锁，重新获取
            if (time() > $lock_time) {
                $this->unlock($key);
                $is_lock = $this->redis->setnx($key, time() + $expire);
            }
        }

        return $is_lock ? true : false;
    }

    /**
     * 释放锁
     * @param  string  $key 锁标识
     * @return bool
     */
    public function unlock($key)
    {
        return $this->redis->del($key);
    }
}

/*
Demo:

$lockobj = new RedisLock();
if ($lock = $lockObj->set('storage', 10)) {
    $sql = "select `number` from storage where id=1 limit 1";
    $res = $pdo->query($sql)->fetch();
    $number = $res['number'];
    if ($number > 0) {
        $sql = "insert into `order` VALUES (null,$number)";
        $order_id = $pdo->query($sql);
        if ($order_id) {
            $sql = "update storage set `number`=`number`-1 WHERE id=1";
            $pdo->query($sql);
        }
    }
    //解锁
    $lockObj->del('storage');
} else {
    //加锁不成功执行其他操作。
}
*/