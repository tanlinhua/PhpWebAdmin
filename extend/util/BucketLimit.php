<?php

class BucketLimit
{
    protected $capacity  = 60; //桶子总容量
    protected $addNum    = 20; //每次注入水的容量
    protected $rate      = 2;  //漏水速率
    protected $water_key = "water_capacity"; //缓存key
    public $redis;        //使用redis 缓存当前桶水量和上次注水时间

    public function __construct()
    {
        $redis = new \Redis();
        $this->redis = $redis;
        $this->redis->connect('127.0.0.1', 6379);
    }

    /**
     * @param int $addNum 注水量
     * @param string $api 指定接口限流
     * @return bool
     */
    public function bucket($addNum, $api = '')
    {
        $this->addNum = $addNum;
        // 获取上次 桶内水量 注水时间
        list($waterCapacity, $waterTime, $lastTime) = $this->getLastWater();
        // 计算出时间内流出的水量
        $lastWater = ($lastTime - $waterTime) * $this->rate;
        // 本次水量
        $waterCapacity = $waterCapacity - $lastWater;
        // 水量不能小于0
        $waterCapacity = ($waterCapacity >= 0) ? $waterCapacity : 0;
        $waterTime = $lastTime;
        // 当前水量大于桶子容量 溢出返回 false 存储水量和注水时间
        if (($waterCapacity + $addNum) <= $this->capacity) {
            $waterCapacity += $addNum;
            $this->setWater($waterCapacity, $waterTime);
            return true;
        } else {
            $this->setWater($waterCapacity, $waterTime);
            return false;
        }
    }

    /**
     * @return array [$waterCapacity,$waterTime,$lastTime] *  当前容量 上次漏水时间 当前时间
     */
    private function getLastWater()
    {
        $water = $this->redis->get($this->water_key);

        if ($water) {
            $water = json_decode($water, true);
            $waterCapacity = $water['water_capacity'];  //上一次容量
            $waterTime = $water['time']; //上一次注水时间
            $lastTime = time(); //本次注水时间
        } else {
            $this->redis->set($this->water_key, json_encode([
                'water_capacity' => 0,
                'time' => time()
            ]));
            $waterCapacity = 0;  //上一次容量
            $waterTime = time(); //上一次注水时间
            $lastTime = time(); //本次注水时间
        }
        return [$waterCapacity, $waterTime, $lastTime];
    }

    /**
     * @param $waterCapacity [int 本次剩余容量]
     * @param $waterTime [int 本次注水时间]
     */
    private function setWater($waterCapacity, $waterTime)
    {
        $this->redis->set($this->water_key, json_encode([
            'water_capacity' => $waterCapacity,
            'time' => $waterTime
        ]));
    }
}
