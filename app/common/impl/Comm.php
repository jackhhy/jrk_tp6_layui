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

namespace app\common\impl;


interface Comm
{

    /**
     * @param array $param
     * @param string $order
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:
     */
    public function getAdminPageData($param=[],$order='id asc');


    /**
     * @param $id
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:
     */
    public function delById($id);


    /**
     * @param $data
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:
     */
    public function doAll($data);

}