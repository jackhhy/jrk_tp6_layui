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
// | Date: 2020/8/4 0004
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\event;

use app\admin\service\SystemLogService;
use Jrk\Tool;
class SysLog
{
    public function handle(){
        if (request()->isAjax() || request()->isPost()) {
            $method = strtolower(request()->method());
            if (in_array($method, ['post', 'put', 'delete'])) {
                $url = substr(request()->url(), 0, 1500);
                $ip =request()->ip();
                $params = request()->param();
                if (isset($params['s'])) {
                    unset($params['s']);
                }
                if(!empty($params)){
                    //去除密码
                    foreach($params as $k=>$v){
                        if(stripos($k,"password")!==false){
                            unset($params[$k]);
                        }
                    }
                }
                $info=\session(ADMIN_LOGIN_INFO);
                $data = [
                    'admin_id'    => $info['id']??0,
                    'url'         => $url,
                    'method'      => $method,
                    'title'       => $info['nickname']??'',
                    'ip'          => $ip,
                    'os'          => Tool::getOS(),
                    'brower'      => Tool::getBrowser(),
                    'content'     => serialize($params),
                    'useragent'   => substr(request()->server('HTTP_USER_AGENT'), 0, 255),
                    'create_time' => time(),
                ];
                SystemLogService::instance()->save($data);
            }
        }
    }

}