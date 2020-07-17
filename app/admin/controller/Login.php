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

namespace app\admin\controller;


use app\BaseController;
use Jrk\Auth;
use think\captcha\facade\Captcha;
use think\Exception;
use think\facade\Db;
use think\facade\Session;
use think\facade\View;
use think\Request;

class Login extends BaseController
{

    /**
     * @return string|\think\response\Redirect
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/26 0026
     * @describe:
     */
    public function index()
    {
        if (Session::has(ADMIN_LOGIN_INFO)) { //已经登录
            return redirect(url("Index/index")->__toString());
        }
        return View::fetch();
    }


    /**
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/26 0026
     * @describe:验证码
     */
    public function captcha()
    {
        ob_clean();
        return Captcha::create();
    }


    /**
     * @param Request $request
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/26 0026
     * @describe:登录验证
     */
    public function loginCheck(Request $request)
    {
        if ($this->request->isPost()) {
            $data = $this->request->only(['username','password','captcha','__token__']);
            try {
               // dd($data);
                /*验证验证码*/
                if (!captcha_check($data["captcha"])) {
                    return json(["code" => 0, "msg" => "验证码错误"]);
                }

                $check = $request->checkToken('__token__',$data);
                if ($check === false) {
                    return json(["code" => 4, "msg" => "非法请求",'_token'=>token()]);
                }

                $result = Db::name("admin")->where("username", $data['username'])->find();

                if (!$result) {
                    return json(["code" => 0, "msg" => "用户名错误"]);
                }

                if (!password_very($data['password'], $result['password'])) {
                    return json(["code" => 0, "msg" => "密码错误"]);
                }

                if ((int)$result['status'] == 0) {
                    return json(["code" => 0, "msg" => "当前用户已被拉黑"]);
                }

                //不是超级管理员
                if($result['id']!=1) {
                    // 查找规则
                    $auth=new Auth();
                   
                    // 查询所有不验证的方法并放入白名单
                    $authOpen=Db::name("auth_rule")->field("id,name")->where("auth_open","=",2)->where("status","=",1)->select();
                    $authRule=Db::name("auth_rule")->where("status","=",1)->select();

                    $authOpens = [];
                    foreach ($authOpen as $k => $v) {
                        $authOpens[] = $v['id'];
                        // 查询所有下级权限
                        $idss = getChildsRule($authRule, $v['id']);
                        foreach ($idss as $kk => $vv) {
                            $authOpens[] = $vv['id'];
                        }
                    }
                    //用户所属用户组设置的所有权限规则ID
                    $ids=$auth->getRuleIds($result['id']);
                    //合并id
                    $ruled=array_merge($ids,$authOpens);
                    //去除重复的
                    $rules = array_unique($ruled);

                    //权限信息保存到session
                    Session::set("admin_rules", $rules); //权限菜单id
                }

                $result = Db::name("admin")->where("username", $data['username'])->find();
                $result['login_time']=date('Y-m-d H:i:s', $result['login_time']);

                unset($result['password']);

                //更新用户信息
                $up = ['login_time' => time(), 'login_ip' => request()->ip(), 'logins' => $result['logins'] + 1,'id'=>$result['id']];

                event("AdminLoginAfter",[$up]);

                //保存登录信息
                Session::set(ADMIN_LOGIN_INFO, $result);

                if (!Session::has(ADMIN_LOGIN_INFO)){
                    \session(ADMIN_LOGIN_INFO, null);
                    return json(["code" => 0, "msg" => "用户session存储失败"]);
                }

                return json(["code" => 1, "msg" => "登录成功", "url"=>url("Index/index")->__toString()]);

            } catch (\Exception $exception) {
                return json(["code" => 0, "msg" => $exception->getMessage()]);
            }

        }
    }


    /**
     * @return \think\response\Json
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:解锁
     */
    public function unlock(){
        if($this->request->isPost()){
            $pass=$this->request->post("pass");
            if (empty($pass)){
                return json(["code" => 0, "msg" => "解锁失败"]);
            }
            $result=Db::name("admin")->where("id",session(ADMIN_LOGIN_INFO)['id'])->value("password");
            if (!password_very($pass,$result)) {
                return json(["code" => 0, "msg" => "密码错误"]);
            }
            return json(["code" => 1, "msg" => "解锁成功"]);

        }
    }


    /**
     * @return \think\response\Json|\think\response\Redirect
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/26 0026
     * @describe:退出登录
     */
    public function logout()
    {
        \session(ADMIN_LOGIN_INFO, null);
        \session("admin_group_id", null);
        \session("admin_rules", null);
        \session("admin_title", null);
        if ($this->request->isAjax()) {
            return json(["code" => 1, "msg" => '退出成功', "time" => time(),'url'=>url("login/index")->__toString()]);
        } else {
            return redirect(url("Login/index")->__toString());
        }
    }


}