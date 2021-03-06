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

namespace app\admin\controller;
use app\common\controller\AdminBaseController;
use think\Exception;
use think\facade\Db;
use think\facade\Route;
use think\Request;
use app\admin\model\Friendlinks;
use app\admin\service\ExcelService;

class Friendlink extends AdminBaseController
{

    protected function initialize()
   {
           parent::initialize(); // TODO: Change the autogenerated stub

           $this->model = new Friendlinks();

           /*所属平台*/
           $this->assign("site_link", config("admin.site_link"));
    }


   /**
     * @return string|\think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:添加
     */
    public function add(){
        $info=[];
        $this->assign(compact("info"));
        return $this->fetch();
    }


    /**
     * @param $id
     * @return string|\think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:编辑
     */
    public function edit($id){
        $info=$this->model->where("id",$id)->find()->toArray();
        if (!$info){
            return parent::failed("未查询到数据");
        }

        $this->assign(compact("info"));
        return $this->fetch("add");
    }


}