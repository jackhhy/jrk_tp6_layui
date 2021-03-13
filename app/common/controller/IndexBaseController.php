<?php
// +----------------------------------------------------------------------
// | Created by PHPstorm: [ JRK丶Admin ]
// +----------------------------------------------------------------------
// | Copyright (c) 2019~2022 [LuckyHHY] All rights reserved.
// +----------------------------------------------------------------------
// | SiteUrl: http://www.luckyhhy.cn
// +----------------------------------------------------------------------
// | Author: LuckyHhy <jackhhy520@qq.com>
// +----------------------------------------------------------------------
// | Date: 2021/3/13 0013
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\common\controller;


use think\facade\View;

class IndexBaseController extends BaseController
{

    /**
     * 检测是否登录
     * @var array
     */
    protected $middleware = ['app\index\middleware\CheckIndexLogin'=>['except' => ['index','email']]];

    //请求参数
    protected $param;

    //当前域名
    protected $domain;
    // 模型
    protected $model;

    //service 层
    protected $service;

    //登录信息
    static $index_info;



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
        self::$index_info=session(INDEX_LOGIN_INFO);

        $this->initConfig();
        $this->initAssign();
        $this->initRequestConfig();

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
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: initAssign
     * @describe:
     */
    public function initAssign()
    {
        //获取当前配置的网站地址
        $this->domain = $this->request->domain();
        $this->assign("domain", $this->domain);


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
        exit($this->fetch('admin@public/exception'));
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
            exit($this->fetch('admin@public/error'));
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
            exit($this->fetch('admin@public/success'));
        }
    }


}