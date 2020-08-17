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
// | Date: 2020-08-17 15:22:18
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use Jrk\Tool;
use think\Exception;
use think\facade\Db;
use Jrk\Tree;


class ArticleUsers extends AdminBaseModel implements Comm
{
    //表名
    protected $name = "articles_user";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where = [];
        if (isset($param['qq']) && $param['qq'] != '') {
            $where[] = ['qq', 'like', "" . $param['qq'] . "%"];
        }

        if (!empty($param['status'])) {
            $status = (int)$param['status'] - 1;
            $where[] = ['status', '=', $status];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b), strtotime($e)]];
        }
        try {
            $data = self::limit_select($where, $order);
            $count = self::hhy_count($where);

            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @param $data
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:保存QQ信息
     */
    public static function SaveQQInfo($data){
        $info= self::where("qq",$data['qq'])->find();
        if (!$info){
            $arr=[
                'qq'=>$data['qq'],
                'nickname'=>$data['name'],
                'avatar'=>$data['image'],
                'os'=>Tool::getOS(),
                'browser'=>Tool::getBrowser(),
                'ip'=>request()->ip()
            ];
            self::create($arr);
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


    /**
     * @return \think\model\relation\HasMany
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:用户下的评论
     */
    public function comments(){
        return $this->hasMany(ArticleComments::class,"user_id","id");
    }

}