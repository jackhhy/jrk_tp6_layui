<?php
// 事件定义文件
return [
    'bind'      => [
    ],

    'listen'    => [
        'AppInit'  => ['\app\common\listener\AppInit'], //初始化常量值
        'HttpRun'  => [],
        'HttpEnd'  => [],
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
        \app\common\subscribes\AdminSubscribe::class, //后台用户事件类
        \app\common\subscribes\UserSubscribe::class, // 前台用户事件类

    ],
];
