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
use Cron\CronExpression;
use think\db\Where;
use think\Exception;

class Queues extends AdminBaseModel implements Comm
{

    /**
     * @var string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25-16:10
     */
    protected $name = "sys_queue";


    /**
     * @var array
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25-16:10
     * 追加属性
     */
    protected $append = [
        'type_text'
    ];

    /**
     * @return array
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: getTypeList
     * @describe:
     */
    public static function getTypeList()
    {
        return [
            'url'   => "请求URL",
            'sql'   => "执行SQL",
            'shell' => "执行Shell",
        ];
    }

    /**
     * @param $value
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/26
     * @name: getStatus
     * @describe:
     */
    public function getStatusAttr($value){
        $status = ['completed'=>'已完成','expired'=>'已过期',"hidden"=>'禁用',"normal"=>'正常'];
        return $status[$value];
    }

    /**
     * @param $value
     * @param $data
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: getTypeTextAttr
     * @describe:
     */
    public function getTypeTextAttr($value, $data)
    {
        $typelist = self::getTypeList();
        $value = $value ? $value : $data['type'];
        return $value && isset($typelist[$value]) ? $typelist[$value] : $value;
    }

    /**
     * @param $value
     * @return false|int|string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: setBegintimeAttr
     * @describe:
     */
    protected function setBegintimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    /**
     * @param $value
     * @return false|int|string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: setEndtimeAttr
     * @describe:
     */
    protected function setEndtimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }

    /**
     * @param $value
     * @return false|int|string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: setExecutetimeAttr
     * @describe:
     */
    protected function setExecutetimeAttr($value)
    {
        return $value && !is_numeric($value) ? strtotime($value) : $value;
    }


    /**
     * @param array $param
     * @param string $order
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:
     */
    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.
        $where = [];
        if(!empty($param)) {
            //搜索条件
            if(isset($param['title']) && $param['title'] !='') {
                $where[] =['title','like', "%".$param['title']."%"];
            }
            if(isset($param['type']) && $param['type'] !='') {
                $where[] =['type',$param['type']];
            }
        }
        try{
            $data = self::where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
            $count =self::where($where)->count("id");

            if (!empty($data)){
                $time = time();
                foreach ($data as $k =>$v) {
                    $cron = CronExpression::factory($v['schedule']);
                    $data[$k]['nexttime'] = $time > $v['endtime'] ? "无" : $cron->getNextRunDate()->getTimestamp();
                }
            }
            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @param $id
     * @return bool|mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/25
     * @name: del
     * @describe:
     */
    public function del($id)
    {
        // TODO: Implement del() method.
        return parent::del($id);
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
     * @param $id
     * @return array|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:
     */
    public function getOne($id){
        return self::find($id);
    }


}