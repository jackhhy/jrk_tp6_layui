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
// | Date: 2020-08-14 16:48:41
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\Exception;
use think\facade\Db;
use Jrk\Tree;
use Jrk\Tool;

class Friendlinks extends AdminBaseModel implements Comm
{
    //表名
    protected $name = "friendlinks";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where = [];
        if (isset($param['name']) && $param['name'] != '') {
            $where[] = ['name', 'like', "%" . $param['name'] . "%"];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b), strtotime($e)]];
        }

        if (!empty($param['status'])) {
            $status = (int)$param['status'] - 1;
            $where[] = ['status', '=', $status];
        }

        if (!empty($param['site_link'])) {
            $where[] = ['site_link', '=', (int)$param['site_link']];
        }

        try {
            $data = self::limit_select($where, $order);

            if (!empty($data)) {
                $ck = config("admin.site_link");
                foreach ($data as $k => $v) {
                    $data[$k]['site_link'] = $ck[$v['site_link']];
                }
            }
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
        try {
            if (!Tool::is_url($data['url'])) {
                return parent::JsonReturn("不是有效的友情链接地址", 0);
            }
            $where = [];
            $where[] = ['name', "=", "" . $data['name'] . ""];
            if (isset($data['id'])) {
                $where[] = ['id', "<>", $data['id']];
            }
            $res = self::where($where)->find();
            if ($res) {
                return parent::JsonReturn("当前链接名称已存在", 0);
            }
            unset($where);
            return parent::doAllData($data);

        } catch (Exception $exception) {
            return parent::JsonReturn($exception->getMessage(), 0);
        }
    }


}