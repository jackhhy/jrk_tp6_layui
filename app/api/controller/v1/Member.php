<?php


namespace app\api\controller\v1;


use app\api\controller\Base;
use app\api\service\JwtService;
use think\facade\Db;
use think\facade\Request;

class Member extends Base
{


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\Response
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:个人信息
     */
    public function index(){
        $user = Db::name('member')
            ->alias('u')
            ->leftJoin('users_type ut', 'u.type_id = ut.id')
            ->field('u.*,ut.name as type_name')
            ->where('u.id', $this->getUid())
            ->find();
        return $this->ReturnAjax("个人信息",$user,1);
    }



    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\Response
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:用户登录
     */
    public function login(){
        //接收参数
        $param=$this->request->param();
        if(!isset($param['username'],$param['password'])){
            return $this->ReturnAjax("参数错误");
        }
        $username=$param['username'];
        $password=$param['password'];

        //查询用户信息
        $info=Db::name("member")->where("username|email",$username)->find();
        if(!$info){
            return $this->ReturnAjax("用户名错误");
        }
        //验证密码
        if(password_very($password,$info['password'])==false){
            return $this->ReturnAjax("用户密码错误");
        }

        if($info['status']==0){
            return $this->ReturnAjax("用户已被禁用");
        }
        //获取jwt的句柄
        $jwtAuth =JwtService::getInstance();
        $token = $jwtAuth->setUid($info['id'])->encode()->getToken();

        //更新信息
        Db::name("member")->where('id', $info['id'])->update(['last_login_time' => time(), 'last_login_ip' => Request::ip()]);

        return $this->ReturnAjax("登录成功",['token'=>$token],1);
    }


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\Response
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:用户注册
     */
    public function register(){
        //接收参数
        $param=$this->request->param();
        if(!isset($param['username'],$param['password'])){
            return $this->ReturnAjax("参数错误");
        }

        $username=$param['username'];
        $password=$param['password'];

        // 密码长度不能低于6位
        if (strlen($password) < 6) {
            return $this->ReturnAjax("密码长度不能低于6位");
        }
        // 邮箱合法性判断
        if (!is_email($username)) {
            return $this->ReturnAjax("邮箱格式错误");
        }

        // 防止重复
        $id = Db::name('member')->where('email|username', '=', $username)->find();
        if ($id) {
            return $this->ReturnAjax("邮箱已被注册");
        }

        // 注册入库
        $data = [];
        $data['email']           = $username;
        $data['username']        = $username;
        $data['password']        = password($password);
        $data['last_login_time'] = $data['create_time'] = time();
        $data['create_ip']       = $data['last_login_ip'] = Request::ip();
        $data['status']          = 1;
        $data['type_id']         = 1;
        $data['sex']             = Request::post('sex') ? Request::post('sex') : 0;
        $id = Db::name('member')->insertGetId($data);
        if ($id) {
            return $this->ReturnAjax("注册成功",[],1);
        } else {
            return $this->ReturnAjax("注册失败");
        }
    }


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @return \think\Response
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:更新密码
     */
    public function updatePwd(){
        //接收参数
        $param=$this->request->param();
        if(!isset($param['newpwd'],$param['oldpwd'])){
            return $this->ReturnAjax("参数错误");
        }
        // 密码长度不能低于6位
        if (strlen($param['newpwd']) < 6) {
            return $this->ReturnAjax("密码长度不能低于6位");
        }
        // 查看原密码是否正确
        $user = Db::name("member")->where('id', $this->getUid())
            ->where('password',password($param['oldpwd']))
            ->find();

        if (!$user) {
            return $this->ReturnAjax('原密码输入有误');
        }
        //更新信息
        Db::name("member")->where("id",$this->getUid())->update(['password'=>password($param['newpwd'])]);
        return $this->ReturnAjax('密码修改成功',[],1);
    }




    /**
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取用户id
     */
    protected function getUid(){
        $jwtAuth = JwtService::getInstance();
        return $jwtAuth->getUid();
    }
}