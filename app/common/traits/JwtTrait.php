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
// | Date: 2020/7/31 0031
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\common\traits;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\SignatureInvalidException;
use UnexpectedValueException;
use think\facade\Config;

trait JwtTrait
{


    /**
     * @param string $type
     * @param array $params
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取token
     */
    public function getToken(string $type, array $params = []): array
    {
        $id = $this->{$this->getPk()};
        $host = app()->request->host();
        $time = time();

        $params += [
            'iss' => $host,
            'aud' => $host,
            'iat' => $time,
            'nbf' => $time,
            'exp' => strtotime('+ 3hour'),
        ];
        $params['jti'] = compact('id', 'type');
        $token = JWT::encode($params, Config::get('app.app_key', 'default'),'HS256');

        return compact('token', 'params');
    }


    /**
     * @param string $jwt
     * @return array
     * @throws UnexpectedValueException     Provided JWT was invalid
     * @throws SignatureInvalidException    Provided JWT was invalid because the signature verification failed
     * @throws BeforeValidException         Provided JWT is trying to be used before it's eligible as defined by 'nbf'
     * @throws BeforeValidException         Provided JWT is trying to be used before it's been created as defined by 'iat'
     * @throws ExpiredException             Provided JWT has since expired, as defined by the 'exp' claim
     * 验证Token
     */
    public static function parseToken(string $jwt): array
    {
        JWT::$leeway = 60;
        $data = JWT::decode($jwt, Config::get('app.app_key', 'default'), array('HS256'));
        $model = new self();
        return [$model->where($model->getPk(), $data->jti->id)->find(), $data->jti->type];
    }

}