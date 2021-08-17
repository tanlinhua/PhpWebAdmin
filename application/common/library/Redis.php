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
 * http://doc.redisfans.com
 * 数据结构使用场景: https://blog.csdn.net/guangzhi0633/article/details/54926645
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
                if (!extension_loaded('redis')) {
                    throw new \BadFunctionCallException('not support: redis');
                }
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
            throw new Exception("Redis连接失败:" . $e->getMessage());
        }
    }

    //----------------------------------------------------------------------
    // KEY命名规则:简洁,高效,可维护; 单词与单词之间以 : 隔开
    // user:token:id => set user:token:id:1 tokenValue
    //----------------------------------------------------------------------

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
                $result = $this->_redis->hMGet($hash, $key); // 获取hash表中多个key的值
            } else {
                $result = $this->_redis->hGet($hash, $key); // 获取hash表中单个key的值
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
                    $result = $this->_redis->hGetAll($hash); // 获取hash表中所有的值
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
    // Tag.列表 (list)
    //----------------------------------------------------------------------

    /**
     * 在队列尾部插入一个元素
     * 
     * @param   string  $name   队列名称
     * @param   string  $data   值
     * @return  int     $length 队列长度
     */
    public function listAdd($name, $data)
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
    public function listGet($name, $wait = false, $timeout = 60)
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
    // Tag.集合 (set)
    //----------------------------------------------------------------------

    /**
     * 将value写入set集合,如果value存在则不写入,返回false
     * 如果是有序集合则根据score值更新该元素的顺序
     * 
     * @param string    $setName    集合名
     * @param mixed     $value      值
     * @param int       $score      元素排序值
     */
    public function setAdd($setName, $value = null, $score = null)
    {
        if ($score !== null) {
            $result = $this->_redis->zAdd($setName, $score, $value);
        } else {
            $result = $this->_redis->sAdd($setName, $value);
        }
        return $result;
    }

    /**
     * 移除set1中的value元素 如果指定了set2 则将该元素写入set2
     * @param string $set1  集合名
     * @param mixed $value  值
     * @param int $stype  集合类型 0:无序集合 1:有序集和 默认0
     * @param string $set2  集合名
     */
    public function setMove($set1, $value = null, $stype = 0, $set2 = null)
    {
        $result = null;
        if ($set2) {
            $result = $this->_redis->sMove($set1, $set2, $value);
        } else {
            if ($stype)
                $result = $this->_redis->zRem($set1, $value);
            else
                $result = $this->_redis->sRem($set1, $value);
        }
        return $result;
    }

    /**
     * 返回set中所有元素
     * @param $set string 集合名
     */
    public function setMembers($set)
    {
        return $this->_redis->sMembers($set);
    }

    /**
     * 查询set中是否有value元素
     * @param string    $set    集合名
     * @param mixed     $value  值
     */
    public function setSearch($set, $value = null)
    {
        return $this->_redis->sIsMember($set, $value);
    }

    /**
     * 随机返回set中一个元素并可选是否删除该元素
     * @param string $set 集合名
     * @param int $isDel 是否删除该元素 0:不删除 1:删除 默认为0
     */
    public function setPop($set, $isDel = 0)
    {
        if ($isDel) {
            $result = $this->_redis->sPop($set);
        } else {
            $result = $this->_redis->sRandMember($set);
        }
        return $result;
    }

    /**
     * 求交集 并可选是否将交集保存到新集合
     * @param array     $set        集合名数组
     * @param string    $newset     要保存到的集合名 默认为null 即不保存交集到新集合
     * @param int       $stype      集合类型 0:无序集合 1:有序集和 默认0
     * @param array     $weight     权重 执行function操作时要指定的每个集合的相同元素所占的权重 默认1
     * @param string    $function   不同集合的相同元素的取值规则函数 SUM:取元素值的和 MAX:取最大值元素 MIN:取最小值元素
     */
    public function setInter($set, $newset = null, $stype = 0, $weight = array(1), $function = 'SUM')
    {
        $result = array();
        if (is_array($set) && !empty($set)) {
            if ($newset) {
                if ($stype)
                    $result = $this->_redis->zInterStore($newset, $set, $weight, $function);
                else
                    $result = $this->_redis->sInterStore($newset, $set);
            } else {
                $result = $this->_redis->sInter($set);
            }
        }
        return $result;
    }

    /**
     * 求并集 并可选是否将交集保存到新集合
     * @param array $set  集合名数组
     * @param string $newset  要保存到的集合名 默认为null 即不保存交集到新集合
     * @param int $stype  集合类型 0:无序集合 1:有序集和 默认0
     * @param array $weight  权重 执行function操作时要指定的每个集合的相同元素所占的权重 默认1
     * @param string $function  不同集合的相同元素的取值规则函数 SUM:取元素值的和 MAX:取最大值元素 MIN:取最小值元素
     */
    public function setUnion($set, $newset = null, $stype = 0, $weight = array(1), $function = 'SUM')
    {
        $result = array();
        if (is_array($set) && !empty($set)) {
            if ($newset) {
                if ($stype)
                    $result = $this->_redis->zUnionStore($newset, $set, $weight, $function);
                else
                    $result = $this->_redis->sUnionStore($newset, $set);
            } else {
                $result = $this->_redis->sUnion($set);
            }
        }
        return $result;
    }


    /**
     * 求差集 并可选是否将交集保存到新集合
     * @param array $set 集合名数组
     * @param string $newset 要保存到的集合名 默认为null 即不保存交集到新集合
     */
    public function setDiff($set, $newset = null)
    {
        $result = array();
        if (is_array($set) && !empty($set)) {
            if ($newset) {
                $result = $this->_redis->sDiffStore($newset, $set);
            } else {
                $result = $this->_redis->sDiff($set);
            }
        }
        return $result;
    }

    /**
     * 排序 分页等
     * @param $set string 集合名
     * @param $option array 选项
     */
    public function setSort($set, $option)
    {
        $default_option = array(
            'by'    => 'some_pattern_*',         //要匹配的排序value值
            'limit' => array(0, 1),              //array(start,length)
            'get'   => 'some_other_pattern_*',   //多个匹配格式:array('some_other_pattern1_*','some_other_pattern2_*')
            'sort'  => 'asc',                    //asc|desc 默认asc
            'alpha' => TRUE,                     //按字符排序,默认数字排序
            'store' => 'some_need_pattern_*'     //永久性排序值
        );
        $option = array_merge($default_option, $option);
        return $this->_redis->sort($set, $option);
    }

    //----------------------------------------------------------------------
    // Tag.有序集合 (sorted set) 下方函数只针对有序集合操作
    //----------------------------------------------------------------------

    /**
     * 返回set中index从start到end的所有元素
     * @param string    $set    集合名
     * @param int       $start  开始Index
     * @param int       $end    结束Index
     * @param int       $order  排序方式 0:从小到大排序 1:从大到小排序 默认0
     * @param bool      $score  元素排序值 false:返回数据不带score true:返回数据带score 默认false
     */
    public function setRange($set, $start, $end, $order = 0, $score = false)
    {
        if ($order) {
            return $this->_redis->zRevRange($set, $start, $end, $score);
        } else {
            return $this->_redis->zRange($set, $start, $end, $score);
        }
    }

    /**
     * 删除set中score从start到end的所有元素
     * @param string    $set    集合名
     * @param int       $start  开始score
     * @param int       $end    结束score
     */
    public function setDeleteRange($set, $start, $end)
    {
        return $this->_redis->zRemRangeByScore($set, $start, $end);
    }

    /**
     * 获取set中某个元素的score
     * 如果指定了inc参数 则给该元素的score增加inc值
     * 如果没有该元素 则将该元素写入集合
     * 
     * @param string    $set    集合名
     * @param mixed     $value  元素值
     * @param int       $inc    要给score增加的数值 默认是null 不执行score增加操作
     */
    public function setScore($set, $value, $inc = null)
    {
        $result = null;
        if ($inc) {
            $result = $this->_redis->zIncrBy($set, $inc, $value);
        } else {
            $result = $this->_redis->zScore($set, $value);
        }
        return $result;
    }


    //----------------------------------------------------------------------
    // Tag.Redis键 (key)
    //----------------------------------------------------------------------

    /**
     * 设置key的过期时间
     *
     * @param string    $key        redis key
     * @param int       $seconds    秒
     * @return void
     */
    public function expire($key, $seconds)
    {
        return $this->_redis->expire($key, $seconds);
    }

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
        $this->_transcation = $this->_redis->multi();
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
    // Tag.发布订阅
    //----------------------------------------------------------------------


    //----------------------------------------------------------------------
    // Tag.redis.opt
    //----------------------------------------------------------------------

    /**
     * 保存redis数据到硬盘文件
     */
    public function bgSave()
    {
        $this->_redis->bgsave();
    }

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
