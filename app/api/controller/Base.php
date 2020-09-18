<?php

declare (strict_types = 1);

namespace app\api\controller;

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
        'app\common\middleware\CheckApi'=>['except' => ['login', 'register']],
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
     * 返回封装后的API数据到客户端
     * @param  mixed   $msg 提示信息
     * @param  mixed   $data 要返回的数据
     * @param  integer $code 返回的code
     * @param  string  $type 返回数据格式
     * @param  array   $header 发送的Header信息
     * @return Response
     */
    protected function ReturnAjax($msg, $data=[], int $code = 0,  string $type = '', array $header = []): Response
    {
        $result = [
            'code' => $code,
            'msg'  => $msg?$msg:'',
            'time' => time(),
            'data' => $data,
        ];

        $type     = $type ?: 'json';
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

}
