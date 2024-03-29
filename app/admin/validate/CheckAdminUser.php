<?php


namespace app\admin\validate;


use think\Validate;

class CheckAdminUser extends Validate
{

    protected $rule = [
        'nickname'  =>  'chsDash|max:12|token',
        'username' =>  'require|alphaNum|max:12|unique:admin',
        'phone'    =>'mobile',
        'email'   =>'email',
        'password' =>  'min:6|max:16|alphaDash',
        'repassword' =>  'confirm:password',
    ];

    protected $message = [
        'nickname.chsAlpha'  =>  '管理员昵称只允许汉字、字母',
        'nickname.max'  =>  '用户昵称最大长度为12个字符',
        'username.alphaNum'  =>  '用户名只允许字母与数字',
        'username.max'  =>  '用户名最大长度为12个字符',
        'password.min'  =>  '密码最少6个字符',
        'password.max' =>  '密码最长16个字符',
        'password.alphaNum' =>  '密码只允许字母、数字',
    ];


    /**
     * 验证场景
     */
  /*  protected $scene = [
        'edit'  =>  ['username','nickname'],
    ];*/


    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:edit 验证场景定义
     */
    public function sceneEdit(){

        return $this->only(['username','nickname']);

    }


    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:修改密码时候
     */
    public function scenePass(){
        return $this->only(['password','repassword'])->append("oldpassword","require|max:16|alphaDash");
    }

}