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
use think\Exception;

class AdminUser extends AdminBaseModel implements Comm
{

    protected $name="admin";
    //隐藏字段
    protected $hidden=["password"];

    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where=[];
        if (isset($param['username']) && $param['username'] != '') {
            $where[] = ['username', 'like', "%" . $param['username'] . "%"];
        }
        try {
            $data = self::where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
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