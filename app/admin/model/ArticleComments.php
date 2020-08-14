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
// | Date: 2020-08-14 16:31:07
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\Exception;
use think\facade\Db;
use Jrk\Tree;


class ArticleComments extends AdminBaseModel implements Comm
{
    //表名
    protected $name = "articles_comment";


    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.
        $where = [];
        if (!empty($param['is_show'])) {
            $status = (int)$param['is_show'] - 1;
            $where[] = ['c.is_show', '=', $status];
        }

        if (!empty($param['status'])) {
            $status = (int)$param['status'] - 1;
            $where[] = ['c.status', '=', $status];
        }
        if (!empty($param['user_id'])) {
            $where[] = ['c.status', '=', $param['user_id']];
        }

        if (isset($param['time']) && $param['time'] != '') {
            $ck = @explode(" ~ ", $param['time']);
            $b = $ck[0] . " 00:00:00";
            $e = $ck[1] . " 23:59:59";
            $where[] = ['c.create_time', 'between', [strtotime($b), strtotime($e)]];
        }

        try {
            $data=self::alias("c")
                ->join("articles_user u","u.id=c.user_id","left")
                ->join("articles a","c.article_id=a.id","left")
                ->field("c.*,a.title,u.nickname")
                ->where($where)->order($order)->page(PAGE)->limit(LIMIT)->select()->toArray();

            $count=self::alias("c")
                ->join("articles_user u","u.id=c.user_id","left")
                ->join("articles a","c.article_id=a.id","left")
                ->field("c.*,a.title,u.nickname")
                ->where($where)->count("c.id");

            if (!empty($data)) {
                $data = Tree::toFormatTree($data, "nickname",'user_id');
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



    /**
     * @return \think\model\relation\HasOne
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:评论所属文章
     */
    public function articels()
    {
        return $this->hasOne(Articles::class, "id", "article_id");
    }


    /**
     * @return \think\model\relation\HasOne
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:评论所属用户
     */
    public function users()
    {
        return $this->hasOne(ArticleUsers::class, "id", "user_id");
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文章评论自增1
     */
    public static function inc_article_comment($article_id)
    {
        return Articles::where("id", $article_id)->inc('comment_num', 1)->update();
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文章评论自减1
     */
    public static function dec_article_comment($article_id)
    {
        return Articles::where("id", $article_id)->dec('comment_num', 1)->update();
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文章点击量自增1
     */
    public static function inc_article_hits($article_id)
    {
        return Articles::where("id", $article_id)->inc('hits', 1)->update();
    }


    /**
     * @param $article_id
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文章喜欢量自增1
     */
    public static function inc_article_love($article_id)
    {
        return Articles::where("id", $article_id)->inc('love', 1)->update();
    }

}