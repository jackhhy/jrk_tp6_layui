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


