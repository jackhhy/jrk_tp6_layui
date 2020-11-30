<?php
// 应用公共文件
use think\facade\Cache;

//加载用户自定义的公共方法
if (file_exists(__DIR__ . "/../app/function.php")) {
    require __DIR__ . "/../app/function.php";
}

if (!function_exists('__')) {
    /**
     * @param $name
     * @param array $vars
     * @param string $lang
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取语言变量值
     */
    function __($name, $vars = [], $lang = '')
    {
        if (is_numeric($name) || !$name) {
            return $name;
        }
        if (!is_array($vars)) {
            $vars = func_get_args();
            array_shift($vars);
            $lang = '';
        }
        return \think\Lang::get($name, $vars, $lang);
    }

}

if (!function_exists('create_min_code')) {
    /**
     * @param $param
     * @param bool $domain
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:生成小程序二维码（小程序必须发布）
     */
    function create_min_code($param,$domain=false)
    {
        return \app\common\traits\QrcodeMin::min_qrcode($param,$domain);
    }
}



if (!function_exists("makeToken")){
    /**
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: makeToken
     * @describe:生成一个不会重复的字符串
     */
    function makeToken()
    {
        $str = md5(uniqid(md5(microtime(true)), true)); //
        $str = sha1($str); //加密
        return $str;
    }
}



if (!function_exists('create_qrcode')) {
    /**
     * @param $text //文本
     * @param int $ize //大小
     * @param bool $domain //是否返回当前域名
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:生成普通二维码
     */
    function create_qrcode($text,$ize=105,$domain=false){
        return \app\common\service\QrcodeSrvice::make_qrcode($text,$ize,$domain);
    }
}

if(!function_exists("curl_get")){
    /**
     * @param $url
     * @param array $data
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:curl请求(get)
     */
    function curl_get($url, $data = [])
    {
        // 处理get数据
        if (!empty($data)) {
            $url = $url . '?' . http_build_query($data);
        }
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//这个是重点。
        $result = curl_exec($curl);
        curl_close($curl);
        return $result;
    }
}

if (!function_exists('array_merge_multiple')) {

    /**
     * @param $array1
     * @param $array2
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:多维数组合并
     */
    function array_merge_multiple($array1, $array2)
    {
        $merge = $array1 + $array2;
        $data = [];
        foreach ($merge as $key => $val) {
            if (isset($array1[$key])
                && is_array($array1[$key])
                && isset($array2[$key])
                && is_array($array2[$key])
            ) {
                $data[$key] = array_merge_multiple($array1[$key], $array2[$key]);
            } else {
                $data[$key] = isset($array2[$key]) ? $array2[$key] : $array1[$key];
            }
        }
        return $data;
    }
}



if (!function_exists('curl_post')) {

    /**
     * @param $url
     * @param array $data
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:curl请求(POST)
     */
    function curl_post($url, $data = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
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




if (!function_exists('build_ueditor')) {
    /**
     * @param array $params
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: build_ueditor
     * @describe:百度编辑器内容
     */
    function build_ueditor($params = array())
    {
        $name = isset($params['name']) ? $params['name'] : null;
        $theme = isset($params['theme']) ? $params['theme'] : 'normal';
        $content = isset($params['content']) ? $params['content'] : null;
        $h = isset($params['h']) ? $params['h'] : 350;
        /* 指定使用哪种主题 */
        $themes = array(
            'normal' => "[   
           'fullscreen', 'source', '|', 'undo', 'redo', '|',
            'bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
            'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
            'customstyle', 'paragraph', 'fontfamily', 'fontsize', '|',
            'directionalityltr', 'directionalityrtl', 'indent', '|',
            'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|', 'touppercase', 'tolowercase', '|',
            'link', 'unlink', 'anchor', '|', 'imagenone', 'imageleft', 'imageright', 'imagecenter', '|',
            'simpleupload', 'insertimage', 'emotion', 'scrawl', 'insertvideo', 'music', 'attachment', 'map', 'gmap', 'insertframe', 'insertcode', 'webapp', 'pagebreak', 'template', 'background', '|',
            'horizontal', 'date', 'time', 'spechars', 'snapscreen', 'wordimage', '|',
            'inserttable', 'deletetable', 'insertparagraphbeforetable', 'insertrow', 'deleterow', 'insertcol', 'deletecol', 'mergecells', 'mergeright', 'mergedown', 'splittocells', 'splittorows', 'splittocols', 'charts', '|',
            'print', 'preview', 'searchreplace', 'drafts', 'help'
       ]", 'simple' => " ['fullscreen', 'source', 'undo', 'redo', 'bold']",
        );
        switch ($theme) {
            case 'simple':
                $theme_config = $themes['simple'];
                break;
            case 'normal':
                $theme_config = $themes['normal'];
                break;
            default:
                $theme_config = $themes['normal'];
                break;
        }
        /* 配置界面语言 */
        switch ('zh-cn') {
            case 'zh-cn':
                $lang = '/plugs/ueditor/lang/zh-cn/zh-cn.js';
                break;
            case 'en-us':
                $lang =  '/plugs/ueditor/lang/en/en.js';
                break;
            default:
                $lang = '/plugs/ueditor/lang/zh-cn/zh-cn.js';
                break;
        }
        $include_js = '<script type="text/javascript" charset="utf-8" src="/plugs/ueditor/ueditor.config.js"></script> <script type="text/javascript" charset="utf-8" src="/plugs/ueditor/ueditor.all.min.js""> </script><script type="text/javascript" charset="utf-8" src="' . $lang . '"></script>';
        $content = json_encode($content);
        $str = <<<EOT
$include_js
<script type="text/javascript">
var ue = UE.getEditor('{$name}',{
    toolbars:[{$theme_config}],
    autoHeightEnabled:false,
    initialFrameHeight:{$h},
        });
    if($content){
ue.ready(function() {
       this.setContent($content);	
})
   }
</script>
EOT;
        return $str;
    }
}


if(!function_exists("is_email")){
    function is_email($user_email)
    {
        $chars = "/^([a-z0-9+_]|\\-|\\.)+@(([a-z0-9_]|\\-)+\\.)+[a-z]{2,6}\$/i";
        if (strpos($user_email, '@') !== false && strpos($user_email, '.') !== false) {
            if (preg_match($chars, $user_email)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}


if(!function_exists("send_email")){
    /**
     * @param $to
     * @param string $subject 邮件标题
     * @param string $content 邮件内容(html模板渲染后的内容)
     * @author: Hhy <jackhhy520@qq.com>
     * @describe: 发送邮件
     */
    function send_email($to, $subject = '', $content = ''){
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $config =sysconfig("smtp");//获取配置
        $mail->CharSet = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        //调试输出格式
        //$mail->Debugoutput = 'html';
        //smtp服务器
        $mail->Host = $config['smtp_server'];
        //端口 - likely to be 25, 465 or 587
        $mail->Port = $config['smtp_port'];

        if ($mail->Port == '465') {
            $mail->SMTPSecure = 'ssl';
        }// 使用安全协议
        //Whether to use SMTP authentication
        $mail->SMTPAuth = true;
        //发送邮箱
        $mail->Username = $config['smtp_user'];
        //密码
        $mail->Password = $config['smtp_pwd'];
        //Set who the message is to be sent from
        $mail->setFrom($config['smtp_user'], $config['email_id']);
        //回复地址
        //$mail->addReplyTo('replyto@example.com', 'First Last');
        //接收邮件方
        if (is_array($to)) {
            foreach ($to as $v) {
                if(is_email($v)){
                    $mail->addAddress($v);
                }
            }
        } else {
            if(is_email($to)){
                $mail->addAddress($to);
            }
        }
        $mail->isHTML(true);// send as HTML
        //标题
        $mail->Subject = $subject;
        //HTML内容转换
        $mail->msgHTML($content);
        return $mail->send();
    }
}



if (!function_exists('add_log')){
    /**
     * @param $param
     * @param string $file 文件夹
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:
     */
     function writeLog($param,$file=''){
         $filename=date("Y_m_d",time());
         if (empty($root)) {
             $myfile =$filename.".txt";
         }else{
             $f=app()->getRootPath().'Logs/'.$file."/";
             if (!is_dir($f)){
                 @mkdir($f,0777,true);
             }
             $myfile=app()->getRootPath().'Logs/'.$file."/".$filename.".txt";
         }
         if (is_array($param)){
             $param=json_encode($param,JSON_FORCE_OBJECT|JSON_UNESCAPED_UNICODE);
         }
         @file_put_contents(
             $myfile,
             "执行日期："."\r\n".date('Y-m-d H:i:s', time()) . ' ' . "\n" . $param . "\r\n",
             FILE_APPEND
         );
    }

}