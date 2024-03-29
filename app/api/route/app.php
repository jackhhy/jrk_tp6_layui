<?php
use think\facade\Route;

//账号密码登录
Route::post('login', 'v1.Member/login');
//邮箱号注册
Route::post('register', 'v1.Member/register');
//个人信息
Route::post('index', 'v1.Member/index');

//token  查验
Route::post('token_check', 'v1.Token/check');

//token  刷新
Route::post('token_refresh', 'v1.Token/refresh');

//miss 路由
Route::miss(function() {
    if(app()->request->isOptions()){
        return \think\Response::create('ok')->code(200)->header([
            'Access-Control-Allow-Origin' => '*',
            'Access-Control-Allow-Headers' => 'Authori-zation,Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
            'Access-Control-Allow-Methods' => 'GET,POST,PATCH,PUT,DELETE,OPTIONS,DELETE',
            ]);
    }else{
        return \think\Response::create()->code(404);
    }
});