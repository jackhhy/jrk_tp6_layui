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
// | Date: 2020/6/26 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\AdminBaseController;
use think\facade\Cache;
use think\facade\App;
use think\facade\Db;
use think\facade\Config;
use think\facade\Request;

class Index extends AdminBaseController
{
    public function index(){

        return $this->fetch();
    }



    public function home(){
        //系统信息
        $mysqlVersion = Db::query('SELECT VERSION() AS ver');
        $config = [
            'url'             => $_SERVER['HTTP_HOST'],
            'document_root'   => $_SERVER['DOCUMENT_ROOT'],
            'server_os'       => PHP_OS,
            'server_port'     => $_SERVER['SERVER_PORT'],
            'server_ip'       => isset($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '',
            'server_soft'     => $_SERVER['SERVER_SOFTWARE'],
            'php_version'     => PHP_VERSION,
            'mysql_version'   => $mysqlVersion[0]['ver'],
            'max_upload_size' => ini_get('upload_max_filesize'),
            'version'         => App::version()
        ];

        $this->assign("config",$config);
        return $this->fetch();
    }



    public function test(){
        return $this->fetch();
    }

    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:天气
     */
    public function weather(){

        return $this->fetch();
    }


    /**
     * @return \think\response\Json
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:清缓存
     */
    public function clearCache(){
        if ($this->request->isPost()){
            $path = App::getRootPath() . 'runtime';
            if ($this->_deleteDir($path)) {
                $result['msg'] = '清除缓存成功!';
                $result['code'] = 0;
            } else {
                $result['msg'] = '清除缓存失败!';
                $result['code'] = 1;
            }
            $result['url'] = url('/admin/login/index');
            return json($result);
        }
    }


    /**
     * @param $R
     * @return bool
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/27 0027
     * @describe:
     */
    private function _deleteDir($R)
    {
        Cache::clear();
        $handle = opendir($R);
        while (($item = readdir($handle)) !== false) {
            // log目录不再清楚
            if ($item != '.' && $item != '..' && $item != 'log') {
                if (is_dir($R . DIRECTORY_SEPARATOR . $item)) {
                    $this->_deleteDir($R . DIRECTORY_SEPARATOR . $item);
                } else {
                    if ($item != '.gitignore') {
                        if (!unlink($R . DIRECTORY_SEPARATOR . $item)) {
                            return false;
                        }
                    }
                }
            }
        }
        closedir($handle);
        return true;
    }


}