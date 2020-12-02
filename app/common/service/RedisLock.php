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
// | Date: 2020/11/30 0030
// +----------------------------------------------------------------------
// | Description: 单例redis 锁
// +----------------------------------------------------------------------

namespace app\common\service;


use think\Exception;

class RedisLock {

    /**
     * 单据锁redis key模板
     */
    const REDIS_LOCK_KEY_TEMPLATE = 'order_lock_%s';
    /**
     * 单据锁默认超时时间（秒）
     */
    const REDIS_LOCK_DEFAULT_EXPIRE_TIME = 8;
    /**
     * Redis配置：IP
     */
    const REDIS_CONFIG_HOST = '127.0.0.1';
    /**
     * Redis配置：端口
     */
    const REDIS_CONFIG_PORT = 6379;
    /**
     * 加锁key
     */
    const REDIS_LOCK_UNIQUE_ID_KEY = 'lock_unique_id';


    /**
     * @param $intOrderId
     * @param int $intExpireTime
     * @return bool|int
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe: redis 加锁
     */
    public static function lock($intOrderId, $intExpireTime = self::REDIS_LOCK_DEFAULT_EXPIRE_TIME)
    {
        //参数校验
        if (empty($intOrderId) || $intExpireTime <= 0) {
            return false;
        }
        //获取Redis连接
        $objRedisConn = self::getRedisConn();
        //生成唯一锁ID，解锁需持有此ID
        $intUniqueLockId = self::generateUniqueLockId();
        //根据板，结合单据ID，生成唯一Redis key（一般来说，单据ID在业务中系统中唯一的）
        $strKey = sprintf(self::REDIS_LOCK_KEY_TEMPLATE, $intOrderId);
        //加锁（通过Redis setnx指令实现，从Redis 2.6.12开始，通过set指令可选参数也可以实现setnx，同时可原子化地设置超时时间）
        $bolRes = $objRedisConn->set($strKey, $intUniqueLockId, ['nx', 'ex'=>$intExpireTime]);
        //加锁成功返回锁ID，加锁失败返回false
        return $bolRes ? $intUniqueLockId : $bolRes;
    }


    /**
     * @param $intOrderId
     * @param $intLockId
     * @return bool
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:redis 解锁
     */
    public static function unlock($intOrderId, $intLockId)
    {
        //参数校验
        if (empty($intOrderId) || empty($intLockId)) {
            return false;
        }
        //获取Redis连接
        $objRedisConn = self::getRedisConn();
        //生成Redis key
        $strKey = sprintf(self::REDIS_LOCK_KEY_TEMPLATE, $intOrderId);
        //监听Redis key防止在【比对lock id】与【解锁事务执行过程中】被修改或删除，提交事务后会自动取消监控，其他情况需手动解除监控
        $objRedisConn->watch($strKey);
        if ($intLockId == $objRedisConn->get($strKey)) {
            $objRedisConn->multi()->del($strKey)->exec();
            return true;
        }
        $objRedisConn->unwatch();
        return false;
    }


    /**
     * @param string $strIp
     * @param int $intPort
     * @return \Redis
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:获取Redis连接（简易版本，可用单例实现）
     */
    public static function getRedisConn($strIp = self::REDIS_CONFIG_HOST, $intPort = self::REDIS_CONFIG_PORT)
    {
        try {
            if (!extension_loaded('redis')) {
                throw new \BadFunctionCallException('not support: redis');
            }
            $objRedis = new \Redis();
            $objRedis->connect($strIp, $intPort);
            return $objRedis;
        }catch (Exception $exception){
            throw new Exception($exception->getMessage());
        }
    }


    /**
     * @return int
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:生成锁唯一ID（通过Redis incr指令实现简易版本，可结合日期、时间戳、取余、字符串填充、随机数等函数，生成指定位数唯一ID）
     */
    public static function generateUniqueLockId()
    {
        return self::getRedisConn()->incr(self::REDIS_LOCK_UNIQUE_ID_KEY);
    }

}