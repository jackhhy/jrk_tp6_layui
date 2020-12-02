<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------


if (function_exists("SendError")){
    /**
     * @param $msg
     * @param array $data
     * @param int $code
     * @return \think\response\Json
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:返回错误信息数组
     */
    function SendError($msg, $data=[], int $code = 0)
    {
        $result = [
            'code' => $code,
            'msg'  => $msg?$msg:'error',
            'time' => time(),
            'data' => $data,
        ];
        return  json($result);
    }
}


if (function_exists("SendSuccess")){
    /**
     * @param $msg
     * @param array $data
     * @param int $code
     * @return \think\response\Json
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:返回成功信息数组
     */
    function SendSuccess($msg, $data=[], int $code = 1)
    {
        $result = [
            'code' => $code,
            'msg'  => $msg?$msg:'error',
            'time' => time(),
            'data' => $data,
        ];
        return  json($result);
    }
}