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
// | Date: 2020/7/01 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace Jrk;


class Tool
{

    /**
     * 下划线转驼峰
     * @param $str
     * @return null|string|string[]
     */
    public static function lineToHump($str)
    {
        $str = preg_replace_callback('/([-_]+([a-z]{1}))/i', function ($matches) {
            return strtoupper($matches[2]);
        }, $str);
        return $str;
    }

    /**
     * 驼峰转下划线
     * @param $str
     * @return null|string|string[]
     */
    public static function humpToLine($str)
    {
        $str = preg_replace_callback('/([A-Z]{1})/', function ($matches) {
            return '_' . strtolower($matches[0]);
        }, $str);
        return $str;
    }


    /**
     * 获取真实IP
     * @return mixed
     */
    public static function getRealIp()
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && preg_match_all('#\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}#s', $_SERVER['HTTP_X_FORWARDED_FOR'], $matches)) {
            foreach ($matches[0] as $xip) {
                if (!preg_match('#^(10|172\.16|192\.168)\.#', $xip)) {
                    $ip = $xip;
                    break;
                }
            }
        } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_CF_CONNECTING_IP'])) {
            $ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
        } elseif (isset($_SERVER['HTTP_X_REAL_IP']) && preg_match('/^([0-9]{1,3}\.){3}[0-9]{1,3}$/', $_SERVER['HTTP_X_REAL_IP'])) {
            $ip = $_SERVER['HTTP_X_REAL_IP'];
        }
        return $ip;
    }


    /**
     * @param int $length
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/17
     * @name: uniqidNumberCode
     * @describe:唯一数字编码
     */
    public static function uniqidNumberCode($length = 10)
    {
        $time = time() . '';
        if ($length < 10) $length = 10;
        $string = ($time[0] + $time[1]) . substr($time, 2) . rand(0, 9);
        while (strlen($string) < $length) $string .= rand(0, 9);
        return $string;
    }

    /**
     * @param int $length
     * @return string
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/17
     * @name: uniqidDateCode
     * @describe: 唯一日期编码
     */
    public static function uniqidDateCode($length = 14)
    {
        if ($length < 14) $length = 14;
        $string = date('Ymd') . (date('H') + date('i')) . date('s');
        while (strlen($string) < $length) $string .= rand(0, 9);
        return $string;
    }


    /**
     * @param $data
     * @return array|mixed
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: string2array
     * @describe:将字符串转换为数组
     */
    public static function  string2array($data)
    {
        if ($data == '') return array();
        return unserialize($data);
    }

    /**
     * @param $data
     * @param int $isformdata
     * @return string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: array2string
     * @describe:将数组转换为字符串
     */
    public static function array2string($data, $isformdata = 1)
    {
        if ($data == '') return '';
        if ($isformdata) $data = self::new_stripslashes($data);
        return serialize($data);
    }


    /**
     * @param $string
     * @param $length
     * @param string $dot
     * @param string $code
     * @return mixed|string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: str_cut
     * @describe:字符串截取
     */
    public static function str_cut($string, $length, $dot = '...', $code = 'utf-8') {
        $strlen = strlen($string);
        if($strlen <= $length) return $string;
        $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
        $strcut = '';
        if($code == 'utf-8') {
            $length = intval($length-strlen($dot)-$length/3);
            $n = $tn = $noc = 0;
            while($n < strlen($string)) {
                $t = ord($string[$n]);
                if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
                    $tn = 1; $n++; $noc++;
                } elseif(194 <= $t && $t <= 223) {
                    $tn = 2; $n += 2; $noc += 2;
                } elseif(224 <= $t && $t <= 239) {
                    $tn = 3; $n += 3; $noc += 2;
                } elseif(240 <= $t && $t <= 247) {
                    $tn = 4; $n += 4; $noc += 2;
                } elseif(248 <= $t && $t <= 251) {
                    $tn = 5; $n += 5; $noc += 2;
                } elseif($t == 252 || $t == 253) {
                    $tn = 6; $n += 6; $noc += 2;
                } else {
                    $n++;
                }
                if($noc >= $length) {
                    break;
                }
            }
            if($noc > $length) {
                $n -= $tn;
            }
            $strcut = substr($string, 0, $n);
            $strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
        } else {
            $dotlen = strlen($dot);
            $maxi = $length - $dotlen - 1;
            $current_str = '';
            $search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
            $replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
            $search_flip = array_flip($search_arr);
            for ($i = 0; $i < $maxi; $i++) {
                $current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
                if (in_array($current_str, $search_arr)) {
                    $key = $search_flip[$current_str];
                    $current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
                }
                $strcut .= $current_str;
            }
        }
        return $strcut.$dot;
    }


    /**
     * @param $str
     * @param int $start 开始位置
     * @param $length 截取长度
     * @param string $charset 编码格式
     * @param bool $suffix 截断显示字符
     * @return false|string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: msubstr
     * @describe:字符串截取，支持中文和其他编码
     */
    public static function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
        if(function_exists("mb_substr"))
            $slice = mb_substr($str, $start, $length, $charset);
        elseif(function_exists('iconv_substr')) {
            $slice = iconv_substr($str,$start,$length,$charset);
            if(false === $slice) {
                $slice = '';
            }
        } else{
            $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
            $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
            $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
            $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
            preg_match_all($re[$charset], $str, $match);
            $slice = join("",array_slice($match[0], $start, $length));
        }
        return $suffix ? $slice.'...' : $slice;
    }

    /**
     * @param $string
     * @return mixed
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: safe_replace
     * @describe:安全过滤
     */
    public static function safe_replace($string) {
        $string = str_replace('%20','',$string);
        $string = str_replace('%27','',$string);
        $string = str_replace('%2527','',$string);
        $string = str_replace('*','',$string);
        $string = str_replace('"','',$string);
        $string = str_replace("'",'',$string);
        $string = str_replace(';','',$string);
        $string = str_replace('<','&lt;',$string);
        $string = str_replace('>','&gt;',$string);
        $string = str_replace("{",'',$string);
        $string = str_replace('}','',$string);
        $string = str_replace('\\','',$string);
        return $string;
    }

    /**
     * @param $string
     * @return array|string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: new_stripslashes
     * @describe:返回经stripslashes处理过的字符串或数组
     */
    protected static function new_stripslashes($string)
    {
        if (!is_array($string)) return stripslashes($string);
        foreach ($string as $key => $val) $string[$key] = self::new_stripslashes($val);
        return $string;
    }

    /**
     * @param $obj
     * @return array|void
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/3/26
     * @name: object_to_array
     * @describe:对象 转 数组
     */
    public static function object_to_array($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)self::object_to_array($v);
            }
        }
        return $obj;
    }

    /**
     * @param $ip
     * @return array|mixed
     * @Author: LuckyHhy <jackhhy520@qq.com>
     * @name: getAddress
     * @describe: 获取IP地址详细信息
     */
    public static function getAddress($ip)
    {
        $url = file_get_contents("http://api.map.baidu.com/location/ip?ip=$ip&ak=Eay7nMQ0htmL357Yh1GSFHcN9qVVoGsg");
        $res1 = json_decode($url, true);
        if ($res1['status'] == 0) { //获取到地址信息
            return $res1;
        } else {
            return [];
        }
    }


    /**
     * @param $url
     * @return bool
     * @author: hhygyl <jackhhy520@qq.com>
     * @name: is_url
     * @describe:验证url
     */
    public static function is_url($url)
    {
        if (empty($url)) return false;
        if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $url)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $path
     * @return StringService
     * @author: hhygyl
     * @name: pathToUrl
     * @describe:路径转url路径
     */
    public static function pathToUrl($path)
    {
        return trim(str_replace(DS, '/', $path), '.');
    }

    /**
     * @param $url
     * @return StringService
     * @author: hhygyl
     * @name: urlToPath
     * @describe:url转换路径
     */
    public static function urlToPath($url)
    {
        return app()->getRootPath() . trim(str_replace('/', DS, $url), DS);
    }


    /**
     * 模板值替换
     * @param $string
     * @param $array
     * @return mixed
     */
    public static function replaceTemplate($string, $array)
    {
        foreach ($array as $key => $val) {
            $string = str_replace("{{" . $key . "}}", $val, $string);
        }
        return $string;
    }


    /**
     * @param $str
     * @return mixed
     * @author: hhygyl
     * @name: hide_phone
     * @describe:替换手机号码中间四位数字
     */
    public static function hide_phone($str)
    {
        $resstr = substr_replace($str, '****', 3, 4);
        return $resstr;
    }


    /**
     * 格式化字节大小
     * @param number $size 字节数
     * @param StringService $delimiter 数字和单位分隔符
     * @return StringService            格式化后的带单位的大小
     */
    public static function format_bytes($size, $delimiter = '')
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
        for ($i = 0; $size >= 1024 && $i < 5; $i++)
            $size /= 1024;
        return round($size, 2) . $delimiter . $units[$i];
    }


    /**
     * @return bool
     * @author: hhygyl
     * @name: isWechatBrowser
     * @describe:是否为微信内部浏览器
     */
    public static function isWechatBrowser()
    {
        return (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false);
    }

    /**
     * @param $name
     * @return StringService
     * @author: hhygyl
     * @name: anonymity
     * @describe:匿名处理
     */
    public static function anonymity($name)
    {
        $strLen = mb_strlen($name, 'UTF-8');
        $min = 3;
        if ($strLen <= 1)
            return '*';
        if ($strLen <= $min)
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $min - 1);
        else
            return mb_substr($name, 0, 1, 'UTF-8') . str_repeat('*', $strLen - 1) . mb_substr($name, -1, 1, 'UTF-8');
    }

    /**
     * @param $card
     * @return bool
     * @author: hhygyl
     * @name: setCard
     * @describe:身份证验证
     */
    public static function setCard($card)
    {
        $city = [11 => "北京", 12 => "天津", 13 => "河北", 14 => "山西", 15 => "内蒙古", 21 => "辽宁", 22 => "吉林", 23 => "黑龙江 ", 31 => "上海", 32 => "江苏", 33 => "浙江", 34 => "安徽", 35 => "福建", 36 => "江西", 37 => "山东", 41 => "河南", 42 => "湖北 ", 43 => "湖南", 44 => "广东", 45 => "广西", 46 => "海南", 50 => "重庆", 51 => "四川", 52 => "贵州", 53 => "云南", 54 => "西藏 ", 61 => "陕西", 62 => "甘肃", 63 => "青海", 64 => "宁夏", 65 => "新疆", 71 => "台湾", 81 => "香港", 82 => "澳门", 91 => "国外 "];
        $tip = "";
        $match = "/^\d{6}(18|19|20)?\d{2}(0[1-9]|1[012])(0[1-9]|[12]\d|3[01])\d{3}(\d|X)$/";
        $pass = true;
        if (!$card || !preg_match($match, $card)) {
            //身份证格式错误
            $pass = false;
        } else if (!$city[substr($card, 0, 2)]) {
            //地址错误
            $pass = false;
        } else {
            //18位身份证需要验证最后一位校验位
            if (strlen($card) == 18) {
                $card = str_split($card);
                //∑(ai×Wi)(mod 11)
                //加权因子
                $factor = [7, 9, 10, 5, 8, 4, 2, 1, 6, 3, 7, 9, 10, 5, 8, 4, 2];
                //校验位
                $parity = [1, 0, 'X', 9, 8, 7, 6, 5, 4, 3, 2];
                $sum = 0;
                $ai = 0;
                $wi = 0;
                for ($i = 0; $i < 17; $i++) {
                    $ai = $card[$i];
                    $wi = $factor[$i];
                    $sum += $ai * $wi;
                }
                $last = $parity[$sum % 11];
                if ($parity[$sum % 11] != $card[17]) {
                    //                        $tip = "校验位错误";
                    $pass = false;
                }
            } else {
                $pass = false;
            }
        }
        if (!$pass)
            return false;/* 身份证格式错误*/
        return true;/* 身份证格式正确*/
    }


    /**
     * @return bool
     * @author: hhygyl
     * @name: is_mobile
     * @describe:判断是否为手机访问
     */
    public static function is_mobile()
    {
        static $is_mobile;

        if (isset($is_mobile)) {
            return $is_mobile;
        }

        if (empty($_SERVER['HTTP_USER_AGENT'])) {
            $is_mobile = false;
        } else if (strpos($_SERVER['HTTP_USER_AGENT'], 'Mobile') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Silk/') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Kindle') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false || strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mobi') !== false) {
            $is_mobile = true;
        } else {
            $is_mobile = false;
        }

        return $is_mobile;
    }


    /**
     * @return StringService
     * @author: hhygyl
     * @name: getOS
     * @describe:获取客户端操作系统
     */
    public static function getOS()
    {
        $agent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if (strpos($agent, 'windows')) {
            $platform = 'windows';
        } else if (strpos($agent, 'macintosh')) {
            $platform = 'mac';
        } else if (strpos($agent, 'ipod')) {
            $platform = 'ipod';
        } else if (strpos($agent, 'ipad')) {
            $platform = 'ipad';
        } else if (strpos($agent, 'iphone')) {
            $platform = 'iphone';
        } else if (strpos($agent, 'android')) {
            $platform = 'android';
        } else if (strpos($agent, 'unix')) {
            $platform = 'unix';
        } else if (strpos($agent, 'linux')) {
            $platform = 'linux';
        } else {
            $platform = 'other';
        }
        return $platform;
    }


    /**
     * @return array
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: getBrowser
     * @describe:获取浏览器模式
     */
    public static function getBrowser()
    {
        // 获取用户代理基本信息
        $flag = $_SERVER['HTTP_USER_AGENT'];
        // 定义一个空数组
        $para = array();
        // 检查操作系统

        if (preg_match('/Chrome\/[\d\.\w]*/', $flag, $match)) {
            // 检查Chrome
            $para['browser'] = $match[0];
        } elseif (preg_match('/Safari\/[\d\.\w]*/', $flag, $match)) {
            // 检查Safari
            $para['browser'] = $match[0];
        } elseif (preg_match('/MSIE [\d\.\w]*/', $flag, $match)) {
            // IE
            $para['browser'] = $match[0];
        } elseif (preg_match('/Opera\/[\d\.\w]*/', $flag, $match)) {
            // opera
            $para['browser'] = $match[0];
        } elseif (preg_match('/Firefox\/[\d\.\w]*/', $flag, $match)) {
            // Firefox
            $para['browser'] = $match[0];
        } elseif (preg_match('/OmniWeb\/(v*)([^\s|;]+)/i', $flag, $match)) {
            //OmniWeb
            $para['browser'] = $match[2];
        } elseif (preg_match('/Netscape([\d]*)\/([^\s]+)/i', $flag, $match)) {
            //Netscape
            $para['browser'] = $match[2];
        } elseif (preg_match('/Lynx\/([^\s]+)/i', $flag, $match)) {
            //Lynx
            $para['browser'] = $match[1];
        } elseif (preg_match('/360SE/i', $flag, $match)) {
            //360SE
            $para['browser'] = '360安全浏览器';
        } elseif (preg_match('/SE 2.x/i', $flag, $match)) {
            //搜狗
            $para['browser'] = '搜狗浏览器';
        } else {
            $para['browser'] = 'unkown';
        }
        // 数据返回
        return $para['browser'];
    }


    /**
     * @param $email
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: is_email
     * @describe:判断email格式是否正确
     */
    public static function is_email($email)
    {
        return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
    }


    /**
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: is_ie
     * @describe:IE浏览器判断
     */
    public static function is_ie()
    {
        $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);
        if ((strpos($useragent, 'opera') !== false) || (strpos($useragent, 'konqueror') !== false))
            return false;
        if (strpos($useragent, 'msie ') !== false)
            return true;
        return false;
    }

    /**
     * @param $number
     * @return string
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: format_money
     * @describe:金额格式化
     */
    public static function format_money($number)
    {
        return number_format($number,2,'.','');
    }

    /**
     * @param $accountPrice
     * @return bool
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: check_money_format
     * @describe:校验金额格式
     */
    public static function check_money_format($accountPrice)
    {
        if (!preg_match('/^[0-9]+(.[0-9]{1,2})?$/', $accountPrice)) return false;
        return true;
    }
}