<?php


namespace app\common\controller;


use app\admin\model\AuthRule;
use app\BaseController;
use Jrk\Tree;
use think\facade\Lang;
use think\facade\View;
use think\Request;
use app\common\traits\JumpReturn;
use liliuwei\think\Jump;
use think\App;
use think\exception\ValidateException;
use think\Validate;
use think\Exception;


class AdminBaseController extends BaseController
{

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
     * 无需登录的方法,同时也就不需要鉴权了.
     *
     * @var array
     */
    protected $noNeedLogin = [];

    /**
     * 无需鉴权的方法,但需要登录.
     *
     * @var array
     */
    protected $noNeedRight = [];


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

        $modulename = app()->http->getName();
        $controller = preg_replace_callback('/\.[A-Z]/', function ($d) {
            return strtolower($d[0]);
        }, $this->request->controller(), 1);

        $controllername = parseName($controller);
        $actionname = strtolower($this->request->action());

        $path = str_replace('.', '/', $controllername).'/'.$actionname;




        $this->initAssign();

        $this->initConfig();

        $this->initRequestConfig();
        //左侧菜单
        $this->menuList();
    }


    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
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
     * @param Request $request
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:编辑添加
     */
    public function upAndAdd(Request $request){
        if (IS_AJAX) {
            $data = $request->post();
            try {
                $data['admin_id'] = self::$admin_info['id'];
                return $this->model->doAll($data);
            } catch (Exception $exception) {
                return self::JsonReturn($exception->getMessage(), 0);
            }
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
     * @describe:
     */
    protected function fetch(string $template = '')
    {
        return View::fetch($template);
    }



    /**
     * 检测当前控制器和方法是否匹配传递的数组.
     *
     * @param array $arr 需要验证权限的数组
     *
     * @return bool
     */
    public function match($arr = [])
    {
        $request = Request::instance();
        $arr = is_array($arr) ? $arr : explode(',', $arr);
        if (! $arr) {
            return false;
        }

        $arr = array_map('strtolower', $arr);
        // 是否存在
        if (in_array(strtolower($request->action()), $arr) || in_array('*', $arr)) {
            return true;
        }

        // 没找到匹配
        return false;
    }

    /**
     * 加载语言文件.
     *
     * @param  string  $name
     */
    protected function loadlang($name)
    {
        if (strpos($name, '.')) {
            $_arr = explode('.', $name);
            if (count($_arr) == 2) {
                $path = $_arr[0].'/'.parseName($_arr[1]);
            } else {
                $path = strtolower($name);
            }
        } else {
            $path = parseName($name);
        }
        Lang::load(app()->getAppPath().'/lang/'.Lang::getLangset().'/'.$path.'.php');
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
        if(empty(self::$admin_info) || self::$admin_info==null){
            if ($this->request->isAjax() || $this->request->isPost()){
                header('Content-Type:application/json; charset=utf-8');
                exit(json_encode(['code'=>0,'msg'=>'您的登录信息已过期请先登录',"time"=>time()], 0));
            }else{
                return redirect((string)url('Login/index'));
            }
        }
        //获取当前配置的网站地址
        $this->domain = $this->request->domain();
        $this->assign("domain", $this->domain);
        //系统名称和版本号和站点地址
        $this->assign('_version', VERSION);
        $this->assign('_name', _NAME);
        $this->assign("_site",SITE_URL);
        //用户登录信息
        $this->assign("_info",self::$admin_info);
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
     * @param string $msg
     * @param int $url
     * @return \think\response\Json
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:错误提醒页面
     */
    protected function failed($msg = '哎呀…亲…您访问的页面出现错误', $url = 0)
    {
        if ($this->request->isAjax()) {
            return self::JsonReturn($msg,0,$url);
        } else {
            $this->assign(compact('msg', 'url'));
            exit($this->fetch('public/error'));
        }
    }


    /**
     * @param string $msg
     * @param int $url
     * @return \think\response\Json
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:成功提醒
     */
    protected function successed($msg = '恭喜你，提交成功！', $url = 0){
        if ($this->request->isAjax()) {
            return self::JsonReturn($msg,1,$url);
        } else {
            $this->assign(compact('msg', 'url'));
            exit($this->fetch('public/success'));
        }
    }


}