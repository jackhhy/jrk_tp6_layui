<?php
/**
 * Created by PhpStorm.
 * User: liliuwei
 * Date: 2019/5/23
 * Time: 22:50
 */
return[
    // 默认跳转页面对应的模板文件
    'dispatch_success_tmpl' => app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
    'dispatch_error_tmpl'   =>app()->getBasePath() . 'common' . DIRECTORY_SEPARATOR . 'tpl' . DIRECTORY_SEPARATOR . 'dispatch_jump.tpl',
];
