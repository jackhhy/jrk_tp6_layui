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
// | Date: 2020/10/26 0026
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\index\middleware;

use app\common\traits\JumpReturn;
use Jrk\Auth;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\Request;

/**
 * Class CheckIndexLogin
 * @package app\admin\middleware
 * 检测 是否登录
 */
class CheckIndexLogin
{

    use JumpReturn;
    use Jump;
    public function handle($request, \Closure $next){

        //验证是否登录
        if (empty($request->session(INDEX_LOGIN_INFO))){
            //异步提交数据的话
            if ($request->isAjax() || $request->isPost()){
                return self::JsonReturn("您的登录信息已过期请先登录",0,url('Login/index'));
            }else{
                return redirect((string)url('Login/index'));
            }
        }

        return $next($request);
    }


}