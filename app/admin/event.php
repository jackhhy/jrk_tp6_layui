<?php
// 事件定义文件
return [
    'bind' => [
    ],

    'listen' => [
        'AppInit'  => [app\common\listener\AppInit::class], //初始化常量值
        'HttpRun'  => [],
        'HttpEnd'  => [app\admin\event\SysLog::class], //操作日志
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];
