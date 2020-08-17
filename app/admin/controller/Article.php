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
// | Date: 2020-08-14 16:24:03
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\controller;
use app\admin\model\ArticleCates;
use app\common\controller\AdminBaseController;
use Jrk\Tree;
use think\Exception;
use think\facade\Db;
use think\facade\Route;
use think\Request;
use app\admin\model\Articles;
use app\admin\service\ExcelService;

class Article extends AdminBaseController
{

    protected $cate;

    protected function initialize()
   {
           parent::initialize(); // TODO: Change the autogenerated stub

          $this->model = new Articles();

          $this->cate = Tree::toFormatTree(ArticleCates::where("model_id", "<>", 4)->select()->toArray(), "name");
         //查询不是链接模型的栏目
          $this->assign("cate", $this->cate);

    }



   /**
     * @param Request $request
     * @return string|\think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:添加
     */
    public function add(Request $request){
        $this->assign("info",[]);
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
        return $this->fetch('add');
    }




    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:回收站
     */
    public function recycle()
    {
        if (IS_AJAX) {
            return $this->model->getRecycleData($this->param);
        }
        return $this->fetch();
    }


    /**
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:真实删除
     */
    public function deltrue()
    {
        if (IS_AJAX) {
            $ids = $this->request->post("ids");

            return $this->model->delTrue($ids);
        }
    }


    /**
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:恢复数据
     */
    public function recycleData()
    {
        if (IS_AJAX) {
            $ids = $this->request->post("ids");
            return $this->model->recycleData($ids);
        }
    }

}