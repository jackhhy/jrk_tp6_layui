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
use think\Exception;
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


        $where=[];
        if (isset($param['title']) && $param['title'] != '') {
            $where[] = ['title', 'like', "%" . $param['title'] . "%"];
        }

        if (!empty($param['group_id'])){
            $where[] = ['group_id', '=', $param['group_id']];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck=@explode(" ~ ",$param['time']);
            $b=$ck[0]." 00:00:00";
            $e=$ck[1]." 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b),strtotime($e)]];
        }

        try {
            $data = self::where($where)->with("sysconfigtab")->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();

            $count = self::where($where)->count("id");

            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }

    /**
     * @return \think\model\relation\HasOne
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:多对一
     */
    public function sysconfigtab(){
       return $this->hasOne("SysConfigTabs",'id','group_id');
    }

    public function delById($id)
    {
        // TODO: Implement delById() method.

        return parent::del($id);
    }


    public function doAll($data){
        // TODO: Implement doAll() method.
        return parent::doAllData($data);
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