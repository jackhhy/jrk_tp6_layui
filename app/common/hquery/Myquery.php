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
// | Date: 2020/8/5 0005
// +----------------------------------------------------------------------
// | Description: 自定义查询
// +----------------------------------------------------------------------

namespace app\common\hquery;


use think\db\Query;

class Myquery extends Query
{

    /***
     * @param $where
     * @param $order
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @describe: 带分页的
     */
    public function limit_select($where,$order)
    {
        return $this->where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
    }


    /**
     * @param $where
     * @param $order
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:不带分页的
     */
    public function hhy_select($where,$order)
    {
        return $this->where($where)->order($order)->select()->toArray();
    }


    /**
     * @param $where
     * @param string $field
     * @return int
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:统计
     */
    public function hhy_count($where,$field="id"){
        return $this->where($where)->count($field);
    }



}