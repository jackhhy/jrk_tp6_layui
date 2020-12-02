<?php


namespace app\api\middleware;


use app\api\service\JwtService;
use think\Exception;
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
        try {
            if ($token) {
                if (count(explode('.', $token)) <> 3) {
                   return $this->result([], 0, 'token格式错误');
                }
                $jwtAuth = JwtService::getInstance();
                $jwtAuth->setToken($token);
                //验证token
                if ($jwtAuth->validate() && $jwtAuth->verify()) {
                    return $next($request);
                } else {
                    return  $this->result([], 0, 'token已过期');
                }
            } else {
                return $this->result([], 0, 'token不能为空');
            }
        } catch (Exception $exception) {
            return $this->result([], 0, $exception->getMessage());
        }

    }


    /**
     * @param $data
     * @param int $code
     * @param string $msg
     * @return \think\response\Json
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:返回封装后的API数据到客户端
     */
    protected function result($data, int $code = 0, $msg = '')
    {
        $result = [
            'code' => $code,
            'msg' => $msg,
            'time' => time(),
            'data' => $data,
        ];
        return json($result);
    }

}