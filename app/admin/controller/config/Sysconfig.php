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

namespace app\admin\controller\config;


use app\admin\model\SysConfigTabs;
use app\admin\validate\CheckConfig;
use app\common\controller\AdminBaseController;
use app\admin\model\SysConfig as SysConfigs;
use think\Exception;


class Sysconfig extends AdminBaseController
{
    protected $gp;
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->model=new SysConfigs();

        $this->gp=SysConfigTabs::where("status",1)->select()->toArray();
        //配置分类
        $this->assign("gropu", $this->gp);
    }


    /**
     * @return string|\think\response\Json
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:
     */
    public function addConfig(){
        if (IS_AJAX) {
            $data = $this->request->post();
            try {
                $checkUser = new CheckConfig();
                if (!$checkUser->scene("Config")->check($data)){
                    return parent::JsonReturn($checkUser->getError(), 0);
                }
                $res=$this->model->where("name",$data['name'])->where("group_id",$data['group_id'])->select()->toArray();

                if ($res){
                    return parent::JsonReturn("当前配置分类的配置名已存在", 0);
                }

                $data['group']=SysConfigTabs::where("id",$data['group_id'])->value("eng_title");
                return $this->model->doAll($data);

            } catch (Exception $exception) {
                return parent::JsonReturn($exception->getMessage(), 0);
            }
        }

        return $this->fetch();
    }


    /**
     * @return string|\think\response\Json
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:
     */
    public function update(){
        if (IS_AJAX) {
            $data = $this->request->post();
            try {
                $checkUser = new CheckConfig();
                if (!$checkUser->scene("Config")->check($data)){
                    return parent::JsonReturn($checkUser->getError(), 0);
                }
                $res=$this->model->where("name",$data['name'])->where("group_id",$data['group_id'])->where("id","<>",$data['id'])->select()->toArray();

                if ($res){
                    return parent::JsonReturn("当前配置分类的配置名已存在", 0);
                }
                $data['group']=SysConfigTabs::where("id",$data['group_id'])->value("eng_title");
                return $this->model->doAll($data);

            } catch (Exception $exception) {
                return parent::JsonReturn($exception->getMessage(), 0);
            }
        }
        $id = $this->request->param("id/d",0);//父id
        $info = $this->model->where("id",$id)->find()->toArray();
        if (!$info) return $this->error("数据错误");
        $this->assign("info",$info);
        return $this->fetch();
    }

}