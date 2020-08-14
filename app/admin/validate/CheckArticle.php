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

namespace app\admin\validate;


use think\Validate;

class CheckArticle extends Validate
{

    protected $rule = [
        'cate_id' =>  'gt:0',
        'title'  =>  'require|max:150',
        'keywords' =>  'max:100',
        'description' =>  'max:200',
        'img_url' =>'require',
        'content' =>'require'
    ];


    protected $message = [

    ];

    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneArticleName(){

    }

}