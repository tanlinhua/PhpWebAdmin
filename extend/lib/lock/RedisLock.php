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
