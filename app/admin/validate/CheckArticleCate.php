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
// | Date: 2020-08-14 16:27:12
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\validate;


use think\Validate;

class CheckArticleCate extends Validate
{

    protected $rule = [
        'name'  =>  'require|chsAlphaNum|max:12',
        'model_id' =>  'gt:0',
        'description' =>  'max:200',
        'urls' =>'url'
    ];


    protected $message = [

    ];

    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneArticleCateName(){

    }

}