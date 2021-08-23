<?php


namespace app\api\controller\v1;

use app\api\controller\Base;
use Jrk\Random;

class Token extends Base
{
    protected $noNeedLogin = [];

    /**
     * 检测Token是否过期
     *
     */
    public function check()
    {
        $token = $this->auth->getToken();
        $tokenInfo = \app\api\service\Token::get($token);
        $this->success('', ['token' => $tokenInfo['token'], 'expires_in' => $tokenInfo['expires_in']]);
    }
    /**
     * 刷新Token
     *
     */
    public function refresh()
    {
        //删除源Token
        $token = $this->auth->getToken();
        \app\api\service\Token::delete($token);
        //创建新Token
        $token = Random::uuid();
        \app\api\service\Token::set($token, $this->auth->id, 2592000);
        $tokenInfo = \app\api\service\Token::get($token);
        $this->success('', ['token' => $tokenInfo['token'], 'expires_in' => $tokenInfo['expires_in']]);
    }
}