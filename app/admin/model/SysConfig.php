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
// | Date: 2020/6/26 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\facade\Cache;

/**
 * Class SysConfig
 * @package admin\model
 * 系统配置
 */
class SysConfig extends AdminBaseModel implements Comm
{

    protected $name="sys_config";

    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.
    }

    public function delById($id)
    {
        // TODO: Implement delById() method.
    }


    public function doAll($data){
        // TODO: Implement doAll() method.
    }



    /**
     * @return bool
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:更新系统设置缓存
     */
    public static function updateSysconfig()
    {
        Cache::tag('sysconfig')->clear();
        return true;
    }

}