<?php

namespace app\common\controller;

use app\common\traits\JumpReturn;
use liliuwei\think\Jump;
use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * Class AdminBaseController
 * @package app\common\controller
 * 后台继承的控制器
 */
abstract class BaseController
{

    //自定义 数据返回
    use JumpReturn;

    //不是ajax 提交返回
    use Jump;

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
     * 检测是否登录
     * @var array
     */
    protected $middleware = [];

    /**
     * AdminBaseController constructor.
     * @param App $app
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        app()->http->setBind(true);
        $this->request = $this->app->request;
        // 控制器初始化
        $this->_initialize();
    }

    // 初始化
    protected function _initialize()
    {
    }


    /**
     * 验证数据
     * @access protected
     * @param array $data 数据
     * @param string|array $validate 验证器名或者验证规则数组
     * @param array $message 提示信息
     * @param bool $batch 是否批量验证
     * @return array|string|true
     * @throws ValidateException
     */
    protected function validate(array $data, $validate, array $message = [], bool $batch = false)
    {
        try {
            if (is_array($validate)) {
                $v = new Validate();
                $v->rule($validate);
            } else {
                if (strpos($validate, '.')) {
                    // 支持场景
                    list($validate, $scene) = explode('.', $validate);
                }
                $class = false !== strpos($validate, '\\') ? $validate : $this->app->parseClass('validate', $validate);
                $v = new $class();
                if (!empty($scene)) {
                    $v->scene($scene);
                }
            }

            $v->message($message);

            //是否批量验证
            if ($batch || $this->batchValidate) {
                $v->batch(true);
            }

            $result = $v->failException(false)->check($data);
            if (true !== $result) {
                return $v->getError();
            } else {
                return $result;
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }


}