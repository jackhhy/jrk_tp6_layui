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
use think\Exception;


class Sysconfigtab extends AdminBaseController
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub

        $this->model=new SysConfigTabs();
    }



    public function addConfigTab(){
        if (IS_AJAX) {
            $data = $this->request->post();
            try {
                $checkUser = new CheckConfig();
                if (!$checkUser->scene("ConfigTab")->check($data)){
                    return parent::JsonReturn($checkUser->getError(), 0);
                }
                $res=$this->model->where(['eng_title' => "" . $data['eng_title'] . ""])->select()->toArray();
                if ($res){
                    return parent::JsonReturn("当前配置分类的英文名已存在", 0);
                }
                return $this->model->doAll($data);

            } catch (Exception $exception) {
                return parent::JsonReturn($exception->getMessage(), 0);
            }
        }

        return $this->fetch();
    }



    public function update(){
        if (IS_AJAX) {
            $data = $this->request->post();
            try {
                $checkUser = new CheckConfig();
                if (!$checkUser->scene("ConfigTab")->check($data)){
                    return parent::JsonReturn($checkUser->getError(), 0);
                }
                $res=$this->model->where(['eng_title' => "" . $data['eng_title'] . ""])->where("id","<>",$data['id'])->select()->toArray();
                if ($res){
                    return parent::JsonReturn("当前配置分类的英文名已存在", 0);
                }
                return $this->model->doAll($data);

            } catch (Exception $exception) {
                return parent::JsonReturn($exception->getMessage(), 0);
            }
        }
        $id = $this->request->param("id/d",0);//父id
        $info = $this->model->where("id",$id)->find()->toArray();
        if (!$info) return $this->error("数据错误");

        $this->assign(compact('info'));
        return $this->fetch();
    }


}