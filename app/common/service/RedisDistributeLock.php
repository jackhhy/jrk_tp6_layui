<?php
// +----------------------------------------------------------------------
// | Created by PHPstorm: [ JRK丶Admin ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2022 [LuckyHHY] All rights reserved.
// +----------------------------------------------------------------------
// | SiteUrl: http://www.luckyhhy.cn
// +----------------------------------------------------------------------
// | Author: LuckyHhy <jackhhy520@qq.com>
// +----------------------------------------------------------------------
// | Date: 2020/12/2 0002
// +----------------------------------------------------------------------
// | Description:   redis分布式锁
// +----------------------------------------------------------------------

namespace app\common\service;

use think\Exception;

class RedisDistributeLock
{
    private $lockKey; //锁的键名
    private $Timeout; //超时时间
    private $redis; //$reids实例
    private $Negtive = true; //是否是悲观锁
    private $identify = ""; //锁的唯一标识，防止锁被别的进程误删
    //redis 配置
    private $redisConfig = [
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'timeout' => 86400,
        'expire' => 0,
        'persistent' => false,
        'prefix' => '',
    ];

    /**
     * RedisDistributeLock constructor.
     * @param $lockKey
     * @param array $config
     * @param int $aTimeout 单据锁默认超时时间（秒）
     * @param bool $Negtive
     * @throws Exception
     * @throws \RedisException
     */
    public function __construct($lockKey, $config = [], $aTimeout = 8, $Negtive = true)
    {
        if (!extension_loaded('redis')) {
            throw new \BadFunctionCallException('不支持: redis');
        }
        if (!$lockKey) {
            throw new Exception("lockKey不能为空");
        }
         //合并redis配置
        if (!empty($config)) {
            $this->redisConfig = array_merge($this->redisConfig, $config);
        }
        try {
            $this->lockKey = $lockKey; //锁的键名
            $this->Negtive = $Negtive; //是否是悲观锁,是
            $this->Timeout = $aTimeout; //超时
            $this->redis = new \Redis(); //实例redis
            if ($this->redisConfig['persistent']) {
                $this->redis->pconnect($this->redisConfig['host'], $this->redisConfig['port'], $this->redisConfig['timeout'], 'persistent_id_' . $this->redisConfig['select']);
            } else {
                $this->redis->connect($this->redisConfig['host'], $this->redisConfig['port'], $this->redisConfig['timeout']);
            }

        } catch (\RedisException $e) {
            throw new Exception($e->getMessage());

        } catch (Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @return \Redis
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取实例
     */
    public function getRedis()
    {
        return $this->redis;
    }


    /**
     * @return bool
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取锁
     */
    public function Getlock()
    {
        $v = uniqid();
        if ($this->Negtive) {
            //悲观锁
            $endtime = microtime(true) * 1000 + $this->Timeout * 1000;
            while (microtime(true) * 1000 < $endtime) {
                //每隔一段时间尝试获取一次锁
                $acquired = $this->redis->set($this->lockKey, $v, ["NX", "EX" => $this->Timeout]);
                if ($acquired) {
                    //获取锁成功
                    $this->identify = $v;
                    return true;
                }
                usleep(100);
            }
            //获取锁超时
            return false;
        } else {
            //乐观锁
            //乐观锁只尝试一次，成功返回true,失败返回false
            $acquired = $this->redis->set($this->lockKey, $v, ["NX", "EX" => $this->Timeout]);
            if ($acquired) {
                $this->identify = $v;
                return true;
            }
            return false;
        }
    }


    /**
     * @return bool
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:释放锁
     */
    public function Unlock()
    {
        //如果没有成功获得锁，直接返回false
        if (!$this->identify) {
            return false;
        }
        //由于判断是否相等和删除是两步操作，因此使用 lua 脚本来保证原子性
        $script = "if redis.call('get', KEYS[1]) == ARGV[1] then return redis.call('del', KEYS[1]) else return 0 end";
        $result = $this->redis->eval($script, [$this->lockKey, $this->identify], 1);
        if ($result) {
            return true;
        }
        return false;
    }


}