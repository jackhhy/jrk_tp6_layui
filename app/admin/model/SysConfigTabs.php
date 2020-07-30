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

namespace app\admin\model;


use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\Exception;


class SysConfigTabs extends AdminBaseModel implements Comm
{

    protected $name="sys_config_tab";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where=[];
        if (isset($param['title']) && $param['title'] != '') {
            $where[] = ['title', 'like', "%" . $param['title'] . "%"];
        }


        if (!empty($param['status'])){
            $status=(int)$param['status']-1;
            $where[] = ['status', '=', $status];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck=@explode(" ~ ",$param['time']);
            $b=$ck[0]." 00:00:00";
            $e=$ck[1]." 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b),strtotime($e)]];
        }

        try {
            $data = self::where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
            //dd(self::getLastSql());
            $count = self::where($where)->count("id");

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


}