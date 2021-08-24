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
        return \think\facade\Lang::get($name, $vars, $lang);
    }

}



if ( ! function_exists('Auth_pass')){
    /**
     * 加密解密
     * @param	string	$string		要加密的字符串或已加密的密文
     * @param	string	$operation	DECODE表示解密, ENCODE其他为加密
     * @param	string	$key		密匙
     * @param	integer	$expiry		加密后有效期
     * @return	string				加密解密后的字符串
     */
    function Auth_pass($string, $operation = 'DECODE', $key = '', $expiry = 0){
        $ckey_length = 4;						//	动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
        $key = md5($key ? $key : 'AC_KEY');		//	密匙
        $keya = md5(substr($key, 0, 16));		//	密匙a会参与加解密
        $keyb = md5(substr($key, 16, 16));		//	密匙b会用来做数据完整性验证
        //	密匙c用于变化生成的密文
        $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
        //	参与运算的密匙
        $cryptkey = $keya.md5($keya.$keyc);
        $key_length = strlen($cryptkey);
        /*
            明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
            如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
         */
        $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
        $string_length = strlen($string);
        $result = '';
        $box = range(0, 255);
        //	产生密匙簿
        $rndkey = array();
        for($i = 0; $i <= 255; $i++) {
            $rndkey[$i] = ord($cryptkey[$i % $key_length]);
        }
        //	用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上对并不会增加密文的强度
        for($j = $i = 0; $i < 256; $i++) {
            $j = ($j + $box[$i] + $rndkey[$i]) % 256;
            $tmp = $box[$i];
            $box[$i] = $box[$j];
            $box[$j] = $tmp;
        }
        //	核心加解密部分
        for($a = $j = $i = 0; $i < $string_length; $i++) {
            $a = ($a + 1) % 256;
            $j = ($j + $box[$a]) % 256;
            $tmp = $box[$a];
            $box[$a] = $box[$j];
            $box[$j] = $tmp;
            $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));	//	从密匙簿得出密匙进行异或，再转成字符
        }
        if($operation == 'DECODE') {
            /*
                substr($result, 0, 10) == 0 验证数据有效性
                substr($result, 0, 10) - time() > 0 验证数据有效性
                substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
                验证数据有效性，请看未加密明文的格式
             */
            if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
                return substr($result, 26);
            } else {
                return '';
            }
        } else {
            /*
                把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
                因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
             */
            return $keyc.str_replace('=', '', base64_encode($result));
        }
    }
}



if (! function_exists('upload_file')) {
    /**
     * @param null $file
     * @param string $name
     * @param string $path
     * @param string $validate
     * @param string $url
     * @return bool|string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:上传文件.
     */
    function upload_file($file = null, $name = 'local', $path = '', $validate = '', $url = '/')
    {
        //文件
        if (! $file) {
            return false;
        }
        //上传配置
        $config_name = 'filesystem.disks.'.$name;
        $filesystem = config($config_name);
        if (! $filesystem) {
            return false;
        }
        //上传文件
        if ($validate) {
            validate(['file' => $validate])->check(['file' => $file]);
        }
        $savename = \think\facade\Filesystem::disk($name)->putFile($path, $file, function ($file) {
            //重命名
            return date('Ymd').'/'.md5((string) microtime(true));
        });
        if(empty($url)){
            $url = '/';
        }
        $savename = $url.$savename;

        return $savename;
    }
}


if (! function_exists('parseName')) {
    /**
     * @param $name
     * @param int $type
     * @param bool $ucfirst
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:
     */
    function parseName($name, $type = 0, $ucfirst = true)
    {
        if ($type) {
            $name = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                return strtoupper($match[1]);
            }, $name);

            return $ucfirst ? ucfirst($name) : lcfirst($name);
        }
        return strtolower(trim(preg_replace('/[A-Z]/', '_\\0', $name), '_'));
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
           'fullscreen', 'source', '|', 'undo', 'redo','bold', 'italic', 'underline', 'fontborder', 'strikethrough', 'superscript', 'subscript', 'removeformat', 'formatmatch', 'autotypeset', 'blockquote', 'pasteplain', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', 'selectall', 'cleardoc', '|',
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
 UE.getEditor('{$name}',{
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



if (!function_exists('writeLog')){
    /**
     * @param $param
     * @param string $file 文件夹
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:
     */
     function writeLog($param,$file=''){
         $filename=date("Y_m_d",time());
         $f=app()->getRootPath().'Logs/'.$file."/";
         if (!is_dir($f)){
             @mkdir($f,0777,true);
         }
         $myfile=app()->getRootPath().'Logs/'.$file."/".$filename.".txt";
         if (is_array($param)){
             $param=json_encode($param,302);
         }
         @file_put_contents(
             $myfile,
             "执行日期："."\r\n".date('Y-m-d H:i:s', time()) . ' ' . "\n" . $param . "\r\n",
             FILE_APPEND
         );
    }

}