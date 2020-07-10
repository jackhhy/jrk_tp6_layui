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
// | Date: 2020/7/01 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

    namespace Jrk;


    /**
     * Class Pinyin
     * @package Jrk
     */
    class Pinyin
    {
        /**
         * @var
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/23-15:37
         */
        static protected $instance;

        /**
         * @var string
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/23-15:37
         */
        static protected $trust = "";


        /**
         * @param int $type
         * @return \Overtrue\Pinyin\Pinyin
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/23
         * @name: instance
         * @describe:
         */
        public static function instance($type = 1)
        {
            // 小内存型
            if ($type == 1) {
                self::$trust = "";
            } else {
                if ($type == 2) {
                    // 内存型
                    self::$trust = "Overtrue\Pinyin\MemoryFileDictLoader";
                } else {
                    if ($type == 3) {
                        // I/O型
                        self::$trust = "Overtrue\Pinyin\GeneratorFileDictLoader";
                    }
                }
            }

            return new \Overtrue\Pinyin\Pinyin(self::$trust);
        }

    }