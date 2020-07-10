<?php

namespace app\admin\controller;

class Error
{
    public function __call($name, $arguments)
    {
         $result = [
          'status' => 0,
          'msg'    => "不存在的请求",
          'datas'  => []
        ];
        if (request()->isAjax()) {
             return json($result, 200);
        }
        return "不存在的请求";
    }
}