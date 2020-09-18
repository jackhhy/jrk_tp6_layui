<?php


namespace app\api\middleware;


use app\api\service\JwtService;
use think\exception\HttpResponseException;
use think\facade\Request;
use think\Response;


class CheckApi
{

    /**
     * @param $request
     * @param \Closure $next
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:
     */
    public function handle($request, \Closure $next)
    {
        $token = Request::header('token');
        if ($token) {
            if (count(explode('.', $token)) <> 3) {
                $this->result([], 0, 'token格式错误');
            }
            $jwtAuth = JwtService::getInstance();
            $jwtAuth->setToken($token);
            //验证token
            if ($jwtAuth->validate() && $jwtAuth->verify()) {
                return $next($request);
            } else {
                $this->result([], 0, 'token已过期');
            }
        } else {
            $this->result([], 0, 'token不能为空');
        }

        return $next($request);
    }


    /**
     * 返回封装后的API数据到客户端
     * @param  mixed   $data 要返回的数据
     * @param  integer $code 返回的code
     * @param  mixed   $msg 提示信息
     * @param  string  $type 返回数据格式
     * @param  array   $header 发送的Header信息
     * @return Response
     */
    protected function result($data, int $code = 0, $msg = '', string $type = '', array $header = []): Response
    {
        $result = [
            'code' => $code,
            'msg'  => $msg,
            'time' => time(),
            'data' => $data,
        ];

        $type     = $type ?: 'json';
        $response = Response::create($result, $type)->header($header);
        throw new HttpResponseException($response);
    }

}