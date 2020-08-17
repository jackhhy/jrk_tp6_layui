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

namespace app\admin\model;

use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\Exception;
use think\facade\Db;
use Jrk\Tree;
use think\model\concern\SoftDelete;
use think\facade\Route;
use app\admin\validate\CheckArticle;
use Jrk\Tool;

class Articles extends AdminBaseModel implements Comm
{

    use SoftDelete;
    protected $deleteTime = 'delete_time';
    protected $defaultSoftDelete = 0; //默认值

    //表名
    protected $name = "articles";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.

        $where = [];
        if (isset($param['title']) && $param['title'] != '') {
            $where[] = ['title', 'like', "%" . $param['title'] . "%"];
        }

        if (!empty($param['is_show']) && (int)$param['is_show']!=0) {
            $status = (int)$param['is_show'] - 1;
            $where[] = ['is_show', '=', $status];
        }

        if (!empty($param['is_top']) && (int)$param['is_top']!=0) {
            $status = (int)$param['is_top'] - 1;
            $where[] = ['is_top', '=', $status];
        }

        if (!empty($param['is_recommend']) && (int)$param['is_recommend']!=0) {
            $status = (int)$param['is_recommend'] - 1;
            $where[] = ['is_recommend', '=', $status];
        }

        if (!empty($param['cate_id']) && (int)$param['cate_id']!=0) {
            $child=getChildsRule(ArticleCates::select()->toArray(),$param['cate_id'],false);
            $child[]=$param['cate_id'];
            $where[] = ['cate_id', 'in', $child];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['create_time', 'between', [strtotime($b), strtotime($e)]];
        }

        try {
            $data = self::with("cates")->limit_select($where, $order);
            $count = self::hhy_count($where);

            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @param array $param
     * @param string $order
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:回收站数据
     */
    public function getRecycleData($param = [], $order = 'id asc'){
        $where = [];

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['delete_time', 'between', [strtotime($b), strtotime($e)]];
        }
        try {

            $data = self::onlyTrashed()->where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();
            $count = self::onlyTrashed()->where($where)->count("id");

            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @param $param
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:编辑添加
     */
    public function doAll($param)
    {
        // TODO: Implement doAll() method.
        try {
            unset($param['file']);
            $check = new CheckArticle();
            if (!$check->check($param)) {
                return parent::JsonReturn($check->getError(), 0);
            }

            $param['content'] = htmlspecialchars_decode($param['content']);

            if (empty($param['description'])) {
                $param['description'] = Tool::str_cut($param['content'], 100);
            }

            if (isset($param['id'])) {
                $id=$param['id'];
                $res = self::update($param);
            }else{
                $res = self::save($param);
                $id=$this->id;
            }
            $u = Route::buildUrl("index/article/show", ['id' => $id])->__toString();
            if ($param['origin'] == '原创') {
                $this->edit(['id' => $id, 'url' => $u]);
            }
            if ($res) {
                return self::JsonReturn("更新添加成功");
            } else {
                return self::JsonReturn("更新添加失败", 0);
            }
        } catch (\Exception $e) {
            return self::JsonReturn($e->getMessage(), 0);
        }
    }


    /**
     * @param $id
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:软删除
     */
    public function delById($id)
    {
        try {
            // TODO: Implement delById() method.
            if (is_array($id)) {
                $ids = $id;
            } else {
                $ids = @explode(",", $id);
            }
            $result = self::destroy($ids);
            if ($result) {
                return self::JsonReturn("删除成功");
            } else {
                return self::JsonReturn("删除失败", 0);
            }
        } catch (\Exception $exception) {
            return self::JsonReturn($exception->getMessage(), 0);
        }
    }


    /**
     * @param $id
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:真实删除
     */
    public function delTrue($id){
        try {
            // TODO: Implement delById() method.
            if (is_array($id)) {
                $ids = $id;
            } else {
                $ids = @explode(",", $id);
            }
            $result = self::destroy($ids,true);
            if ($result) {
                return self::JsonReturn("删除成功");
            } else {
                return self::JsonReturn("删除失败", 0);
            }
        } catch (\Exception $exception) {
            return self::JsonReturn($exception->getMessage(), 0);
        }
    }


    /**
     * @param $id
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:恢复数据
     */
    public function recycleData($id){
        try {
            // TODO: Implement delById() method.
            if (is_array($id)) {
                $ids = $id;
            } else {
                $ids = @explode(",", $id);
            }
            $where=[];
            $where[]=["id","in",$ids];
            $result =self::restore($where);

            if ($result) {
                return self::JsonReturn("恢复成功");
            } else {
                return self::JsonReturn("恢复失败", 0);
            }
        } catch (\Exception $exception) {
            return self::JsonReturn($exception->getMessage(), 0);
        }
    }



    public function edit($param)
    {
        return self::update($param);
    }


    /**
     * @return \think\model\relation\HasOne
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:文章所属栏目
     */
    public function cates()
    {
        return $this->hasOne(ArticleCates::class, "id", "cate_id");
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取文章的cate_id
     */
    public static function getArticleCateId($article_id)
    {
        return self::where("id", $article_id)->value("cate_id");
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:更新文章评论数量
     */
    public static function updateArticleComments($article_id)
    {
        return self::where("id", $article_id)->inc('comment_num')->update();
    }


}