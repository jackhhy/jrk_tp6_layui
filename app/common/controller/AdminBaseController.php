<?php

namespace app\common\controller;

use app\admin\model\AuthRule;
use app\common\traits\JumpReturn;
use Jrk\Tree;
use liliuwei\think\Jump;
use think\facade\View;
use think\App;
use think\exception\ValidateException;
use think\Validate;

/**
 * Class AdminBaseController
 * @package app\common\controller
 * 后台继承的控制器
 */
abstract class AdminBaseController
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
    protected $middleware = ['app\admin\middleware\CheckAdminLogin'];

    //请求参数
    protected $param;

    //当前域名
    protected $domain;
    // 模型
    protected $model;

    //service 层
    protected $service;

    //登录信息
    static $admin_info;

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
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();


    }




    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: initialize
     * @describe:
     */
    protected function initialize()
    {
        //用户登录信息
        self::$admin_info=session(ADMIN_LOGIN_INFO);

        $this->initConfig();
        $this->initAssign();
        $this->initRequestConfig();
       //左侧菜单
        $this->menuList();
    }


    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:index
     */
    public function index(){

        if (IS_AJAX){
            return $this->model->getAdminPageData($this->param);
        }
        return $this->fetch();
    }


    /**
     * @return mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:删除
     */
    public function del()
    {
        if (IS_AJAX) {
            $ids = $this->request->post("ids");

            return $this->model->delById($ids);
        }
    }



    /**
     * @param mixed ...$vars
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: assign
     * @describe:
     */
    protected function assign(...$vars)
    {
        View::assign(...$vars);
    }


    /**
     * @param string $template
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/26 0026
     * @describe:
     */
    protected function fetch(string $template = '')
    {
        return View::fetch($template);
    }



    /**
     * 初始化配置
     * @return void
     * @author Jackhhy
     */
    public function initConfig()
    {
        // 请求参数
        $this->param = $this->request->param();
        // 分页基础默认值
        defined('LIMIT') or define('LIMIT', isset($this->param['limit']) ? $this->param['limit'] : 20);
        defined('PAGE') or define('PAGE', isset($this->param['page']) ? $this->param['page'] : 1);
    }


    /**
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: initRequestConfig
     * @describe:初始化请求配置
     */
    public function initRequestConfig()
    {
        // 定义是否GET请求
        defined('IS_GET') or define('IS_GET', $this->request->isGet());
        // 定义是否POST请求
        defined('IS_POST') or define('IS_POST', $this->request->isPost());
        // 定义是否AJAX请求
        defined('IS_AJAX') or define('IS_AJAX', $this->request->isAjax());
        // 定义是否PAJAX请求
        defined('IS_PJAX') or define('IS_PJAX', $this->request->isPjax());
        // 定义是否PUT请求
        defined('IS_PUT') or define('IS_PUT', $this->request->isPut());
        // 定义是否DELETE请求
        defined('IS_DELETE') or define('IS_DELETE', $this->request->isDelete());
        // 定义是否HEAD请求
        defined('IS_HEAD') or define('IS_HEAD', $this->request->isHead());
        // 定义是否PATCH请求
        defined('IS_PATCH') or define('IS_PATCH', $this->request->isPatch());
        // 定义是否为手机访问
        defined('IS_MOBILE') or define('IS_MOBILE', $this->request->isMobile());
    }


    /**
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:菜单列表
     */
    public function menuList(){

        if (self::$admin_info['id'] !=1){
            $data=AuthRule::where("id","in",session("admin_rules"))->where("type","1")->where("status",1)->select()->toArray();
            if (!empty($data)){
                foreach ($data as $k => $v) {
                    if (!empty($v['name'])) {
                        $data[$k]['url'] = (string)url($v['name']);
                    }
                }
            }
        }else{
            //超级管理员拥有所有权限
            $data = AuthRule::menuList();
        }
        View::assign("menulist",  empty($data) ? []:Tree::DeepTree($data));
    }

    /**
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: initAssign
     * @describe:
     */
    public function initAssign()
    {
        //获取当前配置的网站地址
        $this->domain = $this->request->domain();
        $this->assign("domain", $this->domain);
        //系统名称和版本号和站点地址
        $this->assign('_version', VERSION);
        $this->assign('_name', _NAME);
        $this->assign("_site",SITE_URL);

        //用户登录信息
        $this->assign("_info",session(ADMIN_LOGIN_INFO));
    }


    /**
     * @param string $msg
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: exception
     * @describe:
     */
    protected function exception($msg = '无法打开页面')
    {
        $this->assign(compact('msg'));
        exit($this->fetch('public/exception'));
    }


    /**
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: makeToken
     * @describe:生成一个不会重复的字符串
     */
    public function makeToken()
    {
        $str = md5(uniqid(md5(microtime(true)), true)); //
        $str = sha1($str); //加密
        return $str;
    }

    /**
     * @param $name
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: _empty
     * @describe:
     */
    public function _empty($name)
    {
        exit($this->fetch('admin@public/404'));
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