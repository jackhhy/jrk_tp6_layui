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
// | Date: 2020/6/26 0026
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\admin\middleware;

use app\common\traits\JumpReturn;
use Jrk\Auth;
use liliuwei\think\Jump;
use think\facade\Db;
use think\facade\Request;

/**
 * Class CheckAdminAuth
 * @package app\admin\middleware
 * 检测 是否登录
 */
class CheckAdminLogin
{

    use JumpReturn;
    use Jump;
    public function handle($request, \Closure $next){

        //验证是否登录
        if (empty($request->session(ADMIN_LOGIN_INFO))){
            //异步提交数据的话
            if ($request->isAjax() || $request->isPost()){
                return self::JsonReturn("您的登录信息已过期请先登录",0,url('Login/index'));
            }else{
                return redirect((string)url('Login/index'));
            }
        }

        //验证权限
        // 定义方法白名单
        $allow = [
            'Index/index',      // 首页
            'Common/changeStatus',     //
            'Common/UpImg',     //
            'Common/upWebupload',     //
            'Common/UpFile',     //
            'Index/clearCache',      // 清除缓存
            'Index/weather',    // 天气
            'Index/home',
            'Temp/icon'
        ];
        // 查询所有不验证的方法并放入白名单
        $authOpen=Db::name("auth_rule")->field("name,id")->where("auth_open","=",2)->where("status","=",1)->select();
        $authRule=Db::name("auth_rule")->where("status","=",1)->select();
        $authOpens = [];
        if (!empty($authOpen)){
            foreach ($authOpen as $k => $v) {
                // 转换方法名为小写
                $ruleName = @explode('/', $v['name']);
                if (isset($ruleName[1])) {
                    $ruleName[1] = strtolower($ruleName[1]);
                }
                // 转换控制器首字母大写
                $ruleName = trim(@implode('/', $ruleName));
                $authOpens[] = @ucfirst($ruleName);
                // 查询所有下级权限

                $ids = getChildsRule($authRule, $v['id']);
                if (!empty($ids)){
                    foreach ($ids as $kk => $vv) {
                        // 转换方法名为小写
                        $ruleName = explode('/', $vv['name']);
                        if (isset($ruleName[1])) {
                            $ruleName[1] = strtolower($ruleName[1]);
                        }
                        // 转换控制器首字母大写
                        $ruleName = trim(@implode('/', $ruleName));
                        $authOpens[] = @ucfirst($ruleName);
                    }
                }
            }
            $allow = array_merge($allow, $authOpens);
        }else{
            $allow=$authOpens;
        }
        // 查找当前控制器和方法，控制器首字母大写，方法名首字母小写 如：Index/index
        $route = Request::controller() . '/' . lcfirst(Request::action());
        //当前用户登录的ID
        if (!empty($allow)){
            $admin_id=session(ADMIN_LOGIN_INFO)['id'];
            // 权限认证
            if (!in_array($route, $allow)) {
                if ($admin_id != 1) {
                    //开始认证
                    $auth = new Auth();
                    $result = $auth->check($route, $admin_id);
                    if (!$result) {
                        if ($request->isAjax() || $request->isPost()){
                            return self::JsonReturn("您无此操作权限",0);
                        }else{
                            $this->error('您无此操作权限!!');
                        }
                    }
                }
            }
        }

        return $next($request);
    }


}