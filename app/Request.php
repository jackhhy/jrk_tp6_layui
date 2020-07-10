<?php
namespace app;

// 应用请求对象类
class Request extends \think\Request
{
    //全局请求过滤
    protected $filter = ['htmlspecialchars','trim','strip_tags'];
}
