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
// | Date: 2020/6/27 0027
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------


/**
 * @param $rules
 * @param $pid
 * @return array
 * @author: LuckyHhy <jackhhy520@qq.com>
 * @date: 2020/6/27 0027
 * @describe:传递一个父级分类ID返回所有子分类
 */
function getChildsRule($rules, $pid)
{
    $arr = [];
    foreach ($rules as $v) {
        if ($v['pid'] == $pid) {
            $arr[] = $v;
            $arr = array_merge($arr, getChildsRule($rules, $v['id']));
        }
    }
    return $arr;
}


/**
 * @param $size
 * @param string $delimiter
 * @return string
 * @author: Hhy <jackhhy520@qq.com>
 * @date: 2020/7/1 0001
 * @describe:
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}


/**
 * @param $time
 * @return false|string
 * @author: LuckyHhy <jackhhy520@qq.com>
 * @date: 2020/7/1 0001
 * @describe:
 */
function ftime($time){
return \Jrk\Times::friendlyDate($time,"full");
}