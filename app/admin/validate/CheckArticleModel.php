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

namespace app\admin\validate;


use think\Validate;

class CheckArticleModel extends Validate
{

    protected $rule = [
        'name'  =>  'chs|max:12',
        'tablename' =>  'require',
        'index_template'    =>'alpha|max:14',
        'list_template' =>  'alpha|max:14',
        'show_template' =>  'alpha|max:14'
    ];


    protected $message = [

    ];

    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneArticleModelName(){

    }

}