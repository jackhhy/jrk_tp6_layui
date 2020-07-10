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
// | Date: 2020/6/29 0029
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\admin\model;


use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use Jrk\Tree;
use think\Exception;

class AuthGroups extends AdminBaseModel implements Comm
{

    protected $name="auth_group";

    public function getAdminPageData($param = [], $order = 'id desc')
    {
        // TODO: Implement getAdminPageData() method.

        $where=[];
        if (isset($param['title']) && $param['title'] != '') {
            $where[] = ['title', 'like', "%" . $param['title'] . "%"];
        }
        try {
            $data = self::where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
            $count = self::where($where)->count("id");

            if (!empty($data)){
                $data=Tree::sortListTier($data);
            }

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