<?php

namespace app\api\service;

use app\api\model\Member;

use Jrk\Random;
use think\Exception;
use think\facade\Db;
use think\facade\Request;
use think\facade\Validate;

class Auth
{
    protected static $instance = null;
    protected $_error = '';
    protected $_logined = false;
    protected $_user = null;
    protected $_token = '';
    //Token默认有效时长
    protected $keeptime = 2592000;
    protected $requestUri = '';
    protected $rules = [];
    //默认配置
    protected $config = [];
    protected $options = [];

    protected $allowFields = ['id', 'username', 'email'];

    public function __construct($options = [])
    {
        $this->options = array_merge($this->config, $options);
    }

    /**
     *
     * @param array $options 参数
     * @return Auth
     */
    public static function instance($options = [])
    {
        if (is_null(self::$instance)) {
            self::$instance = new static($options);
        }
        return self::$instance;
    }


    /**
     * 获取User模型
     * @return User
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * 兼容调用user模型的属性
     *
     * @param string $name
     * @return mixed
     */
    public function __get($name)
    {
        return $this->_user ? $this->_user->$name : null;
    }

    /**
     * 兼容调用user模型的属性
     */
    public function __isset($name)
    {
        return isset($this->_user) ? isset($this->_user->$name) : false;
    }

    /**
     * @param $token
     * @return bool
     * 根据Token初始化
     */
    public function init($token)
    {
        if ($this->_logined) {
            return true;
        }
        if ($this->_error) {
            return false;
        }
        $data = Token::get($token);
        if (!$data) {
            return false;
        }
        $user_id = intval($data['user_id']);
        if ($user_id > 0) {
            $user = Member::find($user_id);
            if (!$user) {
                return false;
            }
            if ($user['status'] != '1') {
                return false;
            }
            $this->_user = $user;
            $this->_logined = true;
            $this->_token = $token;
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $account
     * @param $password
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 用户登录
     */
    public function login($account, $password)
    {
        $field = Validate::is($account, 'email') ? 'email' : 'username';

        $user = Member::where([$field => $account])->find();
        if (!$user) {
            $this->setError(__('Account is incorrect'));
            return false;
        }
        if ($user->status != '1') {
            $this->setError(__('Account is locked'));
            return false;
        }
        //验证密码
        if (password_very($password, $user->password) == false) {
            $this->setError(__('Password is incorrect'));
            return false;
        }
        //直接登录会员
        $this->direct($user->id);
        return true;
    }


    /**
     * @param $username
     * @param $password
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 注册
     */
    public function register($username,$password){
        // 密码长度不能低于6位
        if (strlen($password) < 6) {
            $this->setError(__('Password length cannot be less than 6 digits'));
            return false;
        }
        // 邮箱合法性判断
        if (!is_email($username)) {
            $this->setError(__('Incorrect username email format'));
            return false;
        }

        $info= Member::where('email|username', '=', $username)->find();
        if ($info){
            $this->setError(__('Email has been registered'));
            return false;
        }
        $member=new Member();
        // 注册入库
        $data = [];
        $data['email'] = $username;
        $data['username'] = $username;
        $data['password'] = password($password);
        $data['last_login_time'] = $data['create_time'] = time();
        $data['create_ip'] = $data['last_login_ip'] = Request::ip();
        $data['status'] = 1;
        $data['type_id'] = 1;
        $data['sex'] = Request::post('sex') ? Request::post('sex') : 0;
        $result = $member->save($data);
        if ($result==false){
            $this->setError(__('Registration failed'));
            return false;
        }
        //直接登录
        $this->direct($member->id);
        return true;
    }

    /**
     * 退出
     *
     * @return boolean
     */
    public function logout()
    {
        if (!$this->_logined) {
            $this->setError(__('You are not logged in'));
            return false;
        }
        //设置登录标识
        $this->_logined = false;
        //删除Token
        Token::delete($this->_token);
        return true;
    }

    /**
     * @param $user_id
     * @return bool
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * 直接登录账号
     */
    public function direct($user_id)
    {
        $user = Member::find($user_id);
        if ($user) {
            Db::startTrans();
            try {
                $ip = request()->ip();
                $time = time();

                //记录本次登录的IP和时间
                $user->last_login_ip = $ip;
                $user->last_login_time = $time;

                $user->save();

                $this->_user = $user;

                $this->_token = Random::uuid();

                Token::set($this->_token, $user->id, $this->keeptime);

                $this->_logined = true;

                Db::commit();

            } catch (Exception $e) {
                Db::rollback();
                $this->setError($e->getMessage());
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * 判断是否登录
     * @return boolean
     */
    public function isLogin()
    {
        if ($this->_logined) {
            return true;
        }
        return false;
    }

    /**
     * 获取当前Token
     * @return string
     */
    public function getToken()
    {
        return $this->_token;
    }

    /**
     * 获取会员基本信息
     */
    public function getUserinfo()
    {
        $data = $this->_user->toArray();
        $allowFields = $this->getAllowFields();
        $userinfo = array_intersect_key($data, array_flip($allowFields));
        return ['user_info'=>$userinfo,'token'=>Token::get($this->_token)];
    }



    /**
     * 获取当前请求的URI
     * @return string
     */
    public function getRequestUri()
    {
        return $this->requestUri;
    }

    /**
     * 设置当前请求的URI
     * @param string $uri
     */
    public function setRequestUri($uri)
    {
        $this->requestUri = $uri;
    }

    /**
     * 获取允许输出的字段
     * @return array
     */
    public function getAllowFields()
    {
        return $this->allowFields;
    }

    /**
     * 设置允许输出的字段
     * @param array $fields
     */
    public function setAllowFields($fields)
    {
        $this->allowFields = $fields;
    }

    /**
     * @param $user_id
     * @return bool
     * 删除一个指定会员
     */
    public function delete($user_id)
    {
        $user = Member::find($user_id);
        if (!$user) {
            return false;
        }
        Db::startTrans();
        try {
            // 删除会员
            Member::destroy($user_id);
            // 删除会员指定的所有Token
            Token::clear($user_id);

            Db::commit();
        } catch (Exception $e) {
            Db::rollback();
            $this->setError($e->getMessage());
            return false;
        }
        return true;
    }


    /**
     * 获取密码加密后的字符串
     * @param string $password 密码
     * @param string $salt     密码盐
     * @return string
     */
    public function getEncryptPassword($password, $salt)
    {
        return Auth_pass($password,"DECODE",$salt); //密码可解密
    }

    /**
     * 检测当前控制器和方法是否匹配传递的数组
     *
     * @param array $arr 需要验证权限的数组
     * @return boolean
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
     * 设置会话有效时间
     * @param int $keeptime 默认为永久
     */
    public function keeptime($keeptime = 0)
    {
        $this->keeptime = $keeptime;
    }

    /**
     * 设置错误信息
     *
     * @param $error 错误信息
     * @return Auth
     */
    public function setError($error)
    {
        $this->_error = $error;
        return $this;
    }

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->_error ? __($this->_error) : '';
    }
}
