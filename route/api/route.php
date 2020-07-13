<?php
use think\facade\Route;



























//miss 路由
Route::miss(function() {
    if(app()->request->isOptions())
        return \think\Response::create('ok')->code(200)->header([
            'Access-Control-Allow-Origin'   => '*',
            'Access-Control-Allow-Headers'  => 'Authori-zation,Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
            'Access-Control-Allow-Methods'  => 'GET,POST,PATCH,PUT,DELETE,OPTIONS,DELETE',
        ]);
    else
        return \think\Response::create()->code(404);
});