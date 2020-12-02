<?php

declare (strict_types = 1);

namespace app\api\controller;

use app\api\service\JwtService;
use think\App;
use think\facade\Config;
use think\facade\Request;
use think\Response;
use think\Validate;
use think\exception\HttpResponseException;

/**
 * 控制器基础类
 */
abstract class Base
{
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 是否批量验证
     * @var bool
     */
    protected $batchValidate = false;

    /**
     * 控制器中间件
     * @var array
     */
    /**
     * 检测是否登录
     * @var array
     */
    protected $middleware = [
        'app\api\middleware\CheckApi'=>['except' => ['login', 'register']],
    ];

    /**
     * 分页数量
     * @var string
     */
    protected $pageSize = '';

    /**
     * 构造方法
     * @access public
     * @param  App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {

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
