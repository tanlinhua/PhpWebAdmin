<?php

namespace app\common\library;

use Exception;
use think\Cache;

/**
 * Redis工具类 
 * [字符串,列表,哈希,集合,有序集合]
 * 当TP框架的Cache无法满足需求的补充
 * 未封装的命令可通过
 * $redis = new Redis();
 * $redis->命令 进行使用
 * https://www.runoob.com/redis
 * createTime: 2021/8/17
 * 检索: Tag.
 */
class Redis
{
    private $_redis;                // redis对象
    private $_transcation = null;   // 事务对象

    /**
     * 构造函数
     * 
     * @param string $conn
     * @return object
     */
    public function __construct($conn = 'tp')
    {
        try {
            if ('tp' == $conn) {
                $this->_redis = Cache::store('redis')->handler(); // TP框架连接
            } else {
                $cfg = config('cache.redis');

                $this->_redis = new \Redis();
                $this->_redis->connect($cfg['host'], $cfg['port']);

                if (isset($cfg['password']) && '' != $cfg['password']) {
                    $this->_redis->auth($cfg['password']);
                }
                if (isset($cfg['select']) && 0 != $cfg['select']) {
                    $this->_redis->select($cfg['select']);
                }
            }
        } catch (Exception $e) {
            halt("Redis连接失败:" . $e->getMessage());
        }
    }

    //----------------------------------------------------------------------
    // Tag.字符串 (string)
    //----------------------------------------------------------------------

    /**
     * 写入缓存
     * @access public
     * @param string        $key 缓存变量名
     * @param mixed         $value  存储数据
     * @param integer       $expire  有效时间（秒）, 0->永不过期
     * @return boolean
     */
    public function set($key, $value, $expire)
    {
        if ($expire) {
            $result = $this->_redis->setex($key, $expire, $value);
        } else {
            $result = $this->_redis->set($key, $value);
        }
        return $result;
    }

    /**
     * 如果不存在则设置，如果存在了，则不做变动
     *
     * @param string $key
     * @param string $value
     * @return bool 
     */
    public function setnx($key, $value)
    {
        return $this->_redis->setnx($key, $value);
    }

    /**
     * 同时设置一个或多个 key-value 对
     *
     * @param array $datas array('key0'=>'value0','key1'=>'value1')
     * @return void
     */
    public function mset($datas = array())
    {
        return $this->_redis->mset($datas);
    }

    /**
     * 读取缓存
     * @param string $key 缓存变量名
     * @param mixed  $default 默认值
     * @return mixed
     */
    public function get($key, $default = false)
    {
        $value = $this->_redis->get($key);
        if (is_null($value) || false === $value) {
            return $default;
        }
        return $value;
    }

    /**
     * 自增缓存（针对数值缓存）
     * @access public
     * @param  string    $key 缓存变量名
     * @param  int       $step 步长
     * @return false|int
     */
    public function inc($key, $step = 1)
    {
        return $this->_redis->incrby($key, $step);
    }

    /**
     * 自减缓存（针对数值缓存）
     * @access public
     * @param  string    $key 缓存变量名
     * @param  int       $step 步长
     * @return false|int
     */
    public function dec($key, $step = 1)
    {
        return $this->_redis->decrby($key, $step);
    }

    //----------------------------------------------------------------------
    // Tag.列表 (list)
    //----------------------------------------------------------------------

    /**
     * 在队列尾部插入一个元素
     * 
     * @param   string  $name   队列名称
     * @param   string  $data   值
     * @return  int     $length 队列长度
     */
    public function listPush($name, $data)
    {
        $length = $this->_redis->rPush($name, $data);
        return $length;
    }

    /**
     * 删除并返回队列中的头元素
     * 
     * @param   string  $name       队列名称
     * @param   bool    $wait       是否进行阻塞等待
     * @param   int     $timeout    超时时间
     * @return  string  $value
     */
    public function listPop($name, $wait = false, $timeout = 60)
    {
        if ($wait) {
            $value = $this->_redis->BLPop($name, $timeout); //反之 BRPop
        } else {
            $value = $this->_redis->lPop($name); //反之 rPop
        }
        return $value;
    }

    /**
     * 获取列表长度
     *
     * @param   string  $name 队列名称
     * @return  int     长度
     */
    public function listLen($name)
    {
        return $this->_redis->lLen($name);
    }

    /**
     * 清空队列
     *
     * @param   string $name    队列名称
     * @return  string "ok"
     */
    public function listClean($name)
    {
        return $this->_redis->lTrim($name, 1, 0);
    }

    //----------------------------------------------------------------------
    // Tag.哈希 (hash)
    //----------------------------------------------------------------------
    /**
     * 将key->value写入表中
     * @param string    $hash  哈希表名
     * @param array     $data  要写入的数据 array('key'=>'value')
     * @return bool
     */
    public function hashSet($hash, $data)
    {
        $result = false;
        if (is_array($data) && !empty($data)) {
            $result = $this->_redis->hMset($hash, $data);
        }
        return $result;
    }

    /**
     * 获取hash表的数据
     * @param string    $hash   哈希表名
     * @param mixed     $key    表中要存储的key名 默认为null 返回所有key>value
     * @param int       $type   要获取的数据类型 0:返回所有key 1:返回所有value 2:返回所有key->value
     */
    public function hashGet($hash, $key = array(), $type = 0)
    {
        $result = null;

        if ($key) {
            if (is_array($key) && !empty($key)) {
                $result = $this->_redis->hMGet($hash, $key);
            } else {
                $result = $this->_redis->hGet($hash, $key);
            }
        } else {
            switch ($type) {
                case 0:
                    $result = $this->_redis->hKeys($hash);
                    break;
                case 1:
                    $result = $this->_redis->hVals($hash);
                    break;
                case 2:
                    $result = $this->_redis->hGetAll($hash);
                    break;
                default:
                    $result = null;
                    break;
            }
        }
        return $result;
    }

    /**
     * 获取hash表中元素个数
     * 
     * @param string $hash  哈希表名
     */
    public function hashLen($hash)
    {
        return $this->_redis->hLen($hash);
    }

    /**
     * 删除hash表中的key
     * 
     * @param string    $hash   哈希表名
     * @param mixed     $key    表中存储的key名
     */
    public function hashDel($hash, $key)
    {
        return $this->_redis->hDel($hash, $key);
    }

    /**
     * 查询hash表中某个key是否存在
     * 
     * @param string $hash 哈希表名
     * @param mixed $key 表中存储的key名
     */
    public function hashExists($hash, $key)
    {
        return $this->_redis->hExists($hash, $key);
    }

    /**
     * 自增hash表中某个key的值
     * 
     * @param string    $hash   哈希表名
     * @param mixed     $key    表中存储的key名
     * @param int       $inc    要增加的值
     */
    public function hashInc($hash, $key, $inc = 1)
    {
        return $this->_redis->hIncrBy($hash, $key, $inc);
    }


    //----------------------------------------------------------------------
    // Tag.集合 (set)
    //----------------------------------------------------------------------

    //----------------------------------------------------------------------
    // Tag.有序集合 (sorted set)
    //----------------------------------------------------------------------


    //----------------------------------------------------------------------
    // Tag.Redis键 (key)
    //----------------------------------------------------------------------

    /**
     * 验证指定的键是否存在
     *
     * @param string $key
     * @return bool 存在返回:true; 不存在返回:false
     */
    public function exists($key)
    {
        return $this->_redis->exists($key);
    }

    /**
     * 删除到期的key
     * @param string $key
     */
    public function persist($key)
    {
        return $this->_redis->persist($key);
    }

    /**
     * 删除指定的键
     *
     * @param string $key
     * @return int 删除的项数
     */
    public function del($key)
    {
        return $this->_redis->del($key);
    }


    //----------------------------------------------------------------------
    // Tag.事务操作 [保证单个客户端的多个操作是原子的]
    //----------------------------------------------------------------------

    /**
     * 开始进入事务操作
     */
    public function tranStart()
    {
        $this->_transcation = $this->_REDIS->multi();
    }

    /**
     * 执行所有事务块内的命令。
     */
    public function tranExec()
    {
        return $this->_transcation->exec();
    }

    /**
     * 取消事务，放弃执行事务块内的所有命令。
     */
    public function tranDiscard()
    {
        return $this->_transcation->discard();
    }


    //----------------------------------------------------------------------
    // Tag.脚本
    //----------------------------------------------------------------------

    /**
     * 执行脚本
     *
     * @param string $lua   脚本代码
     * @param array $args   参数数组
     * @return mixed
     */
    public function eval($lua, $args = array())
    {
        $this->_redis->eval($lua, $args, count($args));
    }


    //----------------------------------------------------------------------
    // Tag.redis.opt
    //----------------------------------------------------------------------

    /**
     * 清空当前数据库中的所有 key
     */
    public function flush()
    {
        return $this->_redis->flushDB();
    }

    /**
     * 选择数据库
     *
     * @param int $db 0 ~ 15
     * @return bool
     */
    public function select($db)
    {
        return $this->_redis->select($db);
    }

    /**
     * 查看redis连接
     *
     * @return boolean
     */
    public function ping()
    {
        return $this->_redis->ping();
    }

    /**
     * 查看redis详情
     */
    public function info()
    {
        return $this->_redis->info();
    }
}
