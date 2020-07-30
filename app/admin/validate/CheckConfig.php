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

namespace app\admin\validate;


use think\Validate;

class CheckConfig extends Validate
{

    protected $rule = [
        'title'  =>  'chsDash|max:16',
        'eng_title' =>  'require|alphaDash|max:20',
        'name' => 'require|alphaDash|max:20',
        'value' => 'require',
    ];


    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneConfig(){
        return $this->only(['name','value']);
    }


    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneConfigTab(){
        return $this->only(['title','eng_title']);
    }

}