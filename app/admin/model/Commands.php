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
// | Date: 2020/8/14 0014
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;


use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\Exception;

class Commands extends AdminBaseModel implements Comm
{
    //表名
    protected $name = "commands";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where = [];
        if (!empty($param['status'])){
            $status=(int)$param['status'];
            $where[] = ['status', '=', $status];
        }

        if (!empty($param['admin_id'])){
            $admin_id=(int)$param['admin_id'];
            $where[] = ['admin_id', '=', $admin_id];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b), strtotime($e)]];
        }

        try {
            $data = self::with("adminUser")->limit_select($where, $order);
            $count = self::hhy_count($where);

            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }

    public function delById($id)
    {
        // TODO: Implement delById() method.
        return parent::del($id);
    }

    public function doAll($data)
    {
        // TODO: Implement doAll() method.
        return parent::doAllData($data);
    }

    public function adminUser(){

        return $this->hasOne(AdminUser::class,"id","admin_id");
    }

}