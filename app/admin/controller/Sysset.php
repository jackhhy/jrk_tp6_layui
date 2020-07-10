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

namespace app\admin\controller;


use app\common\controller\AdminBaseController;

class Sysset extends AdminBaseController
{


    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:UI动画设置
     */
    public function alertSkin(){

        return $this->fetch();
    }


    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:ui框架设置
     */
    public function setting(){

        return $this->fetch();
    }

}