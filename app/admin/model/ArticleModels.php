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
// | Date: 2020-08-14 16:32:05
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\validate\CheckArticleModel;
use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use Guzzle\Http\Url;
use think\Exception;
use think\facade\Db;
use Jrk\Tree;
use think\facade\Route;


class ArticleModels extends AdminBaseModel implements Comm
{
    //表名
    protected $name = "articles_models";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where = [];
        if (isset($param['username']) && $param['username'] != '') {
            $where[] = ['username', 'like', "%" . $param['username'] . "%"];
        }


        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b), strtotime($e)]];
        }

          if (!empty($param['status'])){
                $status=(int)$param['status']-1;
                $where[] = ['status', '=', $status];
            }

        try {
            $data = self::limit_select($where, $order);
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
        try{
            $check=new CheckArticleModel();

            if (!$check->check($data)){
                return parent::JsonReturn($check->getError(), 0);
            }
            return parent::doAllData($data);

        }catch (Exception $exception){
            return parent::JsonReturn($exception->getMessage(), 0);
        }
    }


    /**
     * @param $model_id
     * @param array $param $param ['param1'=>'id or category','param2'=>'$id']
     * @param string $func 控制器下的方法  如：index/Article/index  or index/Article/edit
     * @return Url
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:生成url跳转链接
     */
    public function getUrlToModelId($model_id,$param=[],$func='index'){
        $model_data=self::adminGetTableNameToModelId($model_id);
        $url=Route::buildUrl('index/'.$model_data['tablename'].'/'.$func, [$param['param1']=>$param['param2']])->__toString();
        return $url;
    }


    /**
     * @param $id
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:根据模型id获取数据表名称
     */
    public static  function adminGetTableNameToModelId($id){
        $data=self::where(['id'=>$id])->field('id,name,tablename')->find();
        if(empty($data)){
            return false;
        }else{
            $data=$data->toArray();
        }
        return $data;
    }


    /**
     * @param $tablename
     * @return array|bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:根据数据表名称获取model数据
     */
    public function adminGetModelDataToTableName($tablename){
        $data=self::where(['tablename'=>$tablename])->field('id,name,tablename')->find();
        if(empty($data)){
            return false;
        }
        return $data->toArray();
    }


    /**
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:
     */
    public static function adminGetModelSelect(){
        $data=self::order('sort desc')->select()->toArray();
        return $data;
    }

    /**
     * @param int $id
     * @param string $func
     * @return array|bool|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe: 获取带不同url的model跳转链接(后台url)
     */
    public function adminGetModelSelectAndUrl($id=0,$func='index'){
        if($id==0){
            $arr=[];
            $all_data=self::adminGetModelSelect();
            foreach ($all_data as $val){
                $val['url']=url("".$val['tablename']."/".$func."");
                $arr[]=$val;
            }
            return $arr;
        }else{
            $one_data=self::adminGetTableNameToModelId($id);
            $one_data['url']=url("".$one_data['tablename'] ."/".$func."");
            return $one_data;
        }
    }

}