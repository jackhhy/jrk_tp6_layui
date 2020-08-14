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
// | Date: 2020/8/14 0014
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\common\subscribes;

use app\admin\model\ArticleUsers;

class UserSubscribe extends Base
{

    /**
     * @param $event
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:保存QQ信息
     */
    public function onUserQQAfter($event){
        list($data)=$event;
        ArticleUsers::SaveQQInfo($data);
    }

}