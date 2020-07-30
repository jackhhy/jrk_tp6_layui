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
// | Date: 2020/7/30 0030
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\admin\library;


class Push
{
    /**
     * @var array Push的实例
     */
    public static $instance = [];

    /**
     * @var object 操作句柄
     */
    public static $handler;


    /**
     * @param array $options
     * @param bool $name Push连接标识 true 强制重新初始化
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: connect
     * @describe: 连接Push驱动
     */
    public static function connect(array $options = [], $name = false)
    {
        $type = !empty($options['type']) ? $options['type'] : 'zhanzhang';
        $config=[
            'xiongzhang'=>[
                'appid'=>sysconfig("push","xzappid"),
                'token'=>sysconfig("push","xztoken")
            ],
            'zhanzhang'=>[
                'site'=>sysconfig("push","zz_site"),
                'token'=>sysconfig("push","zz_token")
            ]
        ];

        $type = strtolower($type);

        $options = array_merge($options, isset($config[$type]) ? $config[$type] : []);

        if (false === $name) {
            $name = md5(serialize($options));
        }

        if (true === $name || !isset(self::$instance[$name])) {
            $class = false === strpos($type, '\\') ?
                '\\app\\common\\library\\push\\driver\\' . ucwords($type) :
                $type;

            if (true === $name) {
                return new $class($options);
            }

            self::$instance[$name] = new $class($options);
        }

        return self::$instance[$name];
    }

    /**
     * @param array $options
     * @return mixed|object
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: init
     * @describe:自动初始化Push
     */
    public static function init(array $options = [])
    {
        if (is_null(self::$handler)) {
            self::$handler = self::connect($options);
        }

        return self::$handler;
    }

    /**
     * @param $urls
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: realtime
     * @describe:
     */
    public static function realtime($urls)
    {
        return self::init()->realtime($urls);
    }

    /**
     * @param $urls
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: history
     * @describe:推送历史链接
     */
    public static function history($urls)
    {
        return self::init()->history($urls);
    }

    /**
     * @param $urls
     * @return mixed
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: delete
     * @describe: 删除链接
     */
    public static function delete($urls)
    {
        return self::init()->delete($urls);
    }
}