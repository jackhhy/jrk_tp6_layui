<?php

declare (strict_types = 1);

namespace app\api\controller;

use app\api\service\Auth;
use think\App;
use think\exception\HttpResponseException;
use think\facade\Lang;
use think\Response;


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
     * 无需登录的方法
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 权限Auth
     * @var Auth
     */
    protected $auth = null;

    /**
     * 默认响应输出类型,支持json/xml
     * @var string
     */
    protected $responseType = 'json';

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
        //跨域请求检测
        check_cors_request();
        // 检测IP是否允许
        check_ip_allowed();
        //移除HTML标签
        $this->request->filter('trim,strip_tags,htmlspecialchars');

        $this->auth = Auth::instance();

        $controller = preg_replace_callback('/\.[A-Z]/', function ($d) {
            return strtolower($d[0]);
        }, $this->request->controller(), 1);

        $controllername = parseName($controller);
        $actionname = strtolower($this->request->action());

        $path = str_replace('.', '/', $controllername).'/'.$actionname;

        // token 需要放到请求 header 头部
        $token =  $this->request->header('Token', '');

        $this->auth->setRequestUri($path);
        // 检测是否需要验证登录
        if (!$this->auth->match($this->noNeedLogin)) {
            //初始化
            $this->auth->init($token);
            //检测是否登录
            if (!$this->auth->isLogin()) {
                $this->error(__('Please login first'),[],201);
            }
        } else {
            // 如果有传递token才验证是否登录状态
            if ($token) {
                $this->auth->init($token);
            }
        }

        // 加载当前控制器语言包
        $this->loadlang($controllername);
    }


    /**
     * 加载语言文件.
     * @param string $name
     */
    protected function loadlang($name)
    {
        Lang::load(app()->getAppPath().'/lang/'.Lang::getLangset().'/'.str_replace('.', '/',
                strtolower($name)).'.php');
    }


    /**
     * 操作成功返回的数据.
     *
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为1
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    protected function success($msg = '', $data = null, $code = 1, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 操作失败返回的数据.
     *
     * @param string $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为0
     * @param string $type   输出类型
     * @param array  $header 发送的 Header 信息
     */
    protected function error($msg = '', $data = null, $code = 0, $type = null, array $header = [])
    {
        $this->result($msg, $data, $code, $type, $header);
    }

    /**
     * 返回封装后的 API 数据到客户端.
     *
     * @param mixed  $msg    提示信息
     * @param mixed  $data   要返回的数据
     * @param int    $code   错误码，默认为0
     * @param string $type   输出类型，支持json/xml/jsonp
     * @param array  $header 发送的 Header 信息
     *
     * @throws HttpResponseException
     * @return void
     */
    protected function result($msg, $data = null, $code = 0, $type = null, array $header = [])
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'time' => time(),
            'data' => $data,
        ];
        // 如果未设置类型则自动判断
        $type = $type ? $type : ($this->request->param(config('var_jsonp_handler')) ? 'jsonp' : $this->responseType);

        if (isset($header['statuscode'])) {
            $code = $header['statuscode'];
            unset($header['statuscode']);
        } else {
            //未设置状态码,根据code值判断
            $code = $code >= 1000 || $code < 200 ? 200 : $code;
        }

        $response = Response::create($result, $type, $code)->header($header);
        //halt($response);
        throw new HttpResponseException($response);
    }

}
