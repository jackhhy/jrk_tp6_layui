<?php


namespace app\api\service;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\ValidationData;

/**
 * Class JwtService
 * @package app\api\service
 * @author: Hhy <jackhhy520@qq.com>
 * @describe: 单例 一次请求中所有出现jwt的地方都是一个用户
 */
class JwtService
{

    // jwt token
    private $token;

    // jwt 过期时间
    private $expTime = 3600;

    // claim iss
    private $iss = 'api.siyucms.com';

    // claim aud
    private $aud = 'siyucms_app';

    // claim uid
    private $uid;

    // secrect
    private $secrect = '1faASDF3';

    // decode token
    private $decodeToken;

    // 单例模式JwtAuth句柄
    private static $instance;

    /**
     * @return JwtService
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取JwtAuth的句柄
     */
    public static function getInstance()
    {
        if(is_null(self::$instance)){
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * JwtService constructor.
     * 私有化构造函数
     */
    private function __construct()
    {

    }

    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:私有化clone函数
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }

    /**
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取token
     */
    public function getToken()
    {
        return (string)$this->token;
    }

    /**
     * @param $token
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:设置token
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @param $uid
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:设置uid
     */
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    /**
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取uid
     */
    public function getUid()
    {
        return $this->uid;
    }

    /**
     * @return $this
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:编码jwt token
     */
    public function encode()
    {
        $time = time();
        $this->token = (new Builder())->setHeader('alg', 'HS256')->setIssuer($this->iss)->setAudience($this->aud)->setIssuedAt($time)->setExpiration($time+$this->expTime)->set('uid', $this->uid)->sign(new Sha256(), $this->secrect)->getToken();
        return $this;
    }


    /**
     * @return \Lcobucci\JWT\Token
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:解码jwt token
     */
    public function decode()
    {
        if(!$this->decodeToken){
            $this->decodeToken = (new Parser())->parse((string)$this->token); // Parses from a string
            $this->uid = $this->decodeToken->getClaim('uid');
        }
        return $this->decodeToken;
    }

    /**
     * @return bool
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:验证 token
     */
    public function validate()
    {
        $data = new ValidationData(); // It will use the current time to validate (iat, nbf and exp)
        $data->setIssuer($this->iss);
        $data->setAudience($this->aud);
        $data->setId($this->uid);

        return $this->decode()->validate($data);
    }

    /**
     * @return bool
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:verify token
     */
    public function verify()
    {
        $signer = new Sha256();
        return $this->decode()->verify($signer, $this->secrect);
    }


}