<?php
// 应用公共文件
use think\facade\Cache;

//加载用户自定义的公共方法
if (file_exists(__DIR__ . "/../app/function.php")) {
    require __DIR__ . "/../app/function.php";
}


if (!function_exists('sysconfig')) {

    /**
     * @param $group //分组名
     * @param null $name //配置名
     * @return array|bool|float|mixed|string|null
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:获取系统配置信息
     */
    function sysconfig($group, $name = null)
    {
        $where = ['group' => $group];
        $value = empty($name) ? Cache::get("sysconfig_{$group}") : Cache::get("sysconfig_{$group}_{$name}");
        if (empty($value)) {
            if (!empty($name)) {
                $where['name'] = $name;
                $value = \app\admin\model\SysConfig::where($where)->value('value');
                Cache::tag('sysconfig')->set("sysconfig_{$group}_{$name}", $value, 3600);
            } else {
                $value = \app\admin\model\SysConfig::where($where)->column('value', 'name');
                Cache::tag('sysconfig')->set("sysconfig_{$group}", $value, 3600);
            }
        }
        return $value;
    }
}


if (!function_exists('exception')) {
    /**
     * @param $msg
     * @param int $code
     * @param string $exception
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/29 0029
     * @describe:抛出异常处理
     */
    function exception($msg, $code = 0, $exception = '')
    {
        $e = $exception ?: '\think\Exception';
        throw new $e($msg, $code);
    }
}

if (!function_exists('password')) {
    /**
     * @param $value
     * @return false|string|null
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:密码加密算法
     */
    function password($value)
    {
        $value = sha1('jrk_') . md5($value) . md5('_encrypt') . sha1($value);
        return password_hash($value, PASSWORD_DEFAULT);
    }
}


if (!function_exists('password_very')) {
    /**
     * @param $value //密码
     * @param $pass //数据库存的 hash值
     * @return bool
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:验证密码
     */
    function password_very($value, $pass)
    {
        $value = sha1('jrk_') . md5($value) . md5('_encrypt') . sha1($value);
        return password_verify($value, $pass);
    }
}


if (!function_exists('array_format_key')) {
    /**
     * @param $array
     * @param $key
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:二位数组重新组合数据
     */
    function array_format_key($array, $key)
    {
        $newArray = [];
        foreach ($array as $vo) {
            $newArray[$vo[$key]] = $vo;
        }
        return $newArray;
    }
}


if (!function_exists('node')) {
    /**
     * @param null $node
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe: 按钮权限认证 {:node('Login/index')} //写在按钮的class里面
     */
    function node($node = null)
    {
        $k = \app\admin\model\AuthRule::auth_verify($node);
        if ($k == true) {
            $str = "";
        } else {
            $str = "node_hide";
        }
        echo $str;
    }

}


if (!function_exists('make_path')) {

    /**
     * @param $path
     * @param int $type
     * @param bool $force
     * @return string
     * @throws Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:上传路径转化,默认路径
     */
    function make_path($path, int $type = 2, bool $force = false)
    {
        $path = DS . ltrim(rtrim($path));
        switch ($type) {
            case 1:
                $path .= DS . date('Y');
                break;
            case 2:
                $path .= DS . date('Y') . DS . date('m');
                break;
            case 3:
                $path .= DS . date('Y') . DS . date('m') . DS . date('d');
                break;
        }
        try {
            if (is_dir(app()->getRootPath() . 'public' . DS . 'uploads' . $path) == true || mkdir(app()->getRootPath() . 'public' . DS . 'uploads' . $path, 0777, true) == true) {
                return trim(str_replace(DS, '/', $path), '.');
            } else return '';
        } catch (\Exception $e) {
            if ($force)
                throw new \Exception($e->getMessage());
            return '无法创建文件夹，请检查您的上传目录权限：' . app()->getRootPath() . 'public' . DS . 'uploads' . DS . 'attach' . DS;
        }

    }
}


if (!function_exists('filterEmoji')) {
    /**
     * @param $str
     * @return string|string[]|null
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/28 0028
     * @describe:过滤掉emoji表情
     */
    function filterEmoji($str)
    {
        $str = preg_replace_callback(    //执行一个正则表达式搜索并且使用一个回调进行替换
            '/./u',
            function (array $match) {
                return strlen($match[0]) >= 4 ? '' : $match[0];
            },
            $str);
        return $str;
    }
}

if (!function_exists('get_this_class_methods')) {
    /**
     * @param $class
     * @param array $unarray
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/29 0029
     * @describe:
     */
    function get_this_class_methods($class, $unarray = [])
    {
        $arrayall = get_class_methods($class);
        if ($parent_class = get_parent_class($class)) {
            $arrayparent = get_class_methods($parent_class);
            $arraynow = array_diff($arrayall, $arrayparent);//去除父级的
        } else {
            $arraynow = $arrayall;
        }
        return array_diff($arraynow, $unarray);//去除无用的
    }
}

if (!function_exists('zip_file')) {

    /**
     * 打包压缩文件及文件夹
     * @param array $files 文件
     * @param string $zipName 压缩包名称
     * @param bool $isDown 压缩后是否下载true或false
     * @return string 返回结果
     */
    function zip_file($files = [], $zipName = '', $isDown = true)
    {
        // 文件名为空则生成文件名
        if (empty($zipName)) {
            $zipName = date('YmdHis') . '.zip';
        }

        // 实例化类,使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
        $zip = new \ZipArchive;
        /*
         * 通过ZipArchive的对象处理zip文件
         * $zip->open这个方法如果对zip文件对象操作成功，$zip->open这个方法会返回TRUE
         * $zip->open这个方法第一个参数表示处理的zip文件名。
         * 这里重点说下第二个参数，它表示处理模式
         * ZipArchive::OVERWRITE 总是以一个新的压缩包开始，此模式下如果已经存在则会被覆盖。
         * ZipArchive::OVERWRITE 不会新建，只有当前存在这个压缩包的时候，它才有效
         * */
        if ($zip->open($zipName, \ZIPARCHIVE::OVERWRITE | \ZIPARCHIVE::CREATE) !== true) {
            exit('无法打开文件，或者文件创建失败');
        }

        // 打包处理
        if (is_string($files)) {
            // 文件夹整体打包
            addFileToZip($files, $zip);
        } else {
            // 文件打包
            foreach ($files as $val) {
                if (file_exists($val)) {
                    // 添加文件
                    $zip->addFile($val, basename($val));
                }
            }
        }
        // 关闭
        $zip->close();

        // 验证文件是否存在
        if (!file_exists($zipName)) {
            exit("文件不存在");
        }

        if ($isDown) {
            ob_clean();
            // 下载压缩包
            header("Cache-Control: public");
            header("Content-Description: File Transfer");
            header('Content-disposition: attachment; filename=' . basename($zipName)); //文件名
            header("Content-Type: application/zip"); //zip格式的
            header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
            header('Content-Length: ' . filesize($zipName)); //告诉浏览器，文件大小
            @readfile($zipName);ob_end_clean();
        } else {
            // 直接返回压缩包地址
            return $zipName;
        }
    }
}

if (!function_exists('addFileToZip')) {

    /**
     * 添加文件至压缩包
     * @param string $path 文件夹路径
     * @param $zip zip对象
     */
    function addFileToZip($path, $zip)
    {
        // 打开文件夹
        $handler = opendir($path);
        while (($filename = readdir($handler)) !== false) {
            if ($filename != "." && $filename != "..") {
                // 编码转换
                $filename = iconv('gb2312', 'utf-8', $filename);
                // 文件夹文件名字为'.'和‘..’，不要对他们进行操作
                if (is_dir($path . "/" . $filename)) {
                    // 如果读取的某个对象是文件夹，则递归
                    addFileToZip($path . "/" . $filename, $zip);
                } else {
                    // 将文件加入zip对象
                    $file_path = $path . "/" . $filename;
                    $zip->addFile($file_path, basename($file_path));
                }
            }
        }
        // 关闭文件夹
        @closedir($path);
    }
}

if (!function_exists('unzip_file')) {

    /**
     * 压缩文件解压
     * @param string $file 被解压的文件
     * @param $dirname 解压目录
     * @return bool 返回结果true或false
     */
    function unzip_file($file, $dirname)
    {
        if (!file_exists($file)) {
            return false;
        }
        // zip实例化对象
        $zipArc = new ZipArchive();
        // 打开文件
        if (!$zipArc->open($file)) {
            return false;
        }
        // 解压文件
        if (!$zipArc->extractTo($dirname)) {
            // 关闭
            $zipArc->close();
            return false;
        }
        return $zipArc->close();
    }
}