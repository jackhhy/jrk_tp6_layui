<?php
// 事件定义文件
return [
    'bind' => [
    ],

    'listen' => [
        'AppInit'  => [], //初始化常量值
        'HttpRun'  => [],
        'HttpEnd'  => [], //操作日志
        'LogLevel' => [],
        'LogWrite' => [],
    ],

    'subscribe' => [
    ],
];
