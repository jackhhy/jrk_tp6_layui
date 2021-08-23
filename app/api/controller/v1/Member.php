<?php


namespace app\api\controller\v1;

use app\api\controller\Base;

class Member extends Base
{

    //无需登录的方法
    protected $noNeedLogin=['login','register'];


    //返回个人信息
    public function index(){
        $this->success($this->auth->getUserinfo());
        /*
         * 返回示例
         * {
            "code": 1,
            "msg": {
                "user_info": {
                    "id": 1,
                    "username": "hhy@qq.com",
                    "email": "hhy@qq.com"
                },
                "token": {
                    "token": "044d46fe-fb4e-4633-968f-7498b3289854",
                    "user_id": 1,
                    "createtime": 1629701341,
                    "expiretime": 1632293341,
                    "expires_in": 2591824
                }
            },
            "time": 1629701517,
            "data": null
        }
        */
    }

    /**
     * @return \think\Response
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:用户登录
     */
    public function login()
    {
        //接收参数
        $param = $this->request->param();
        if (!isset($param['username'], $param['password'])) {
           $this->error(__('Invalid parameters'));
        }
        $username = $param['username'];
        $password = $param['password'];

        $result=$this->auth->login($username,$password);

        if ($result) {
            $this->success(__('Logged in successful'), $this->auth->getUserinfo(),200);
            /*
             *{
                "code": 200,
                "msg": "登录成功",
                "time": 1629701341,
                "data": {
                    "user_info": {
                        "id": 1,
                        "username": "hhy@qq.com",
                        "email": "hhy@qq.com"
                    },
                    "token": {
                        "token": "044d46fe-fb4e-4633-968f-7498b3289854",
                        "user_id": 1,
                        "createtime": 1629701341,
                        "expiretime": 1632293341,
                        "expires_in": 2592000
                    }
                }
             }
             */
        } else {
            $this->error($this->auth->getError());
        }
    }


    /**
     * @return \think\Response
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\db\exception\DataNotFoundException
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:用户注册
     */
    public function register()
    {
        //接收参数
        $param = $this->request->param();
        if (!isset($param['username'], $param['password'])) {
            $this->error(__('Invalid parameters'));
        }
        $username = $param['username'];
        $password = $param['password'];
        $result =$this->auth->register($username,$password);
        if ($result) {
            $this->success(__('Registered successfully'), $this->auth->getUserinfo(),200);
        } else {
            $this->error($this->auth->getError());
        }
    }


}