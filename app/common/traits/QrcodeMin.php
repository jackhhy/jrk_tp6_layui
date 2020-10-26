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
// | Date: 2020/7/28 0028
// +----------------------------------------------------------------------
// | Description: 生成小程序码
// +----------------------------------------------------------------------

namespace app\common\traits;


trait QrcodeMin
{

    //获取配置
    protected static function _C($type){
        $arr=[
            'APPID'=>'wx857f26c3ba595', //你的APPID
            'APP_SECRET'=>'7bfd44f6541b23660e8993cef163' //你的app_secret
        ];
        return $arr[$type];
    }


    /**
     * @param null $param
     * @param bool $domain
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:生成小程序太阳码
     */
    public static function min_qrcode($param=null,$domain=false)
    {
        if (empty($param)){
            $param = "site_id=4";
        }else{
            if (is_array($param)){
                $param = http_build_query($param);
            }
        }
        $url = "https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=" . self::getAccessToken();
        //生成二维码图片
        $da['page'] = 'pages/index/index'; //小程序路径地址,不写默认跳首页
        $da['width'] = 430;  //二维码大小
        $da['scene'] = $param; //页面传参
        $post_data = json_encode($da);
        //这里会直接生成base64图片.直接写成文件就可以 打印会显示乱码
        $result = self::api_notice_increment($url, $post_data);
        $n = date("Ym");
        $dir = app()->getRootPath() . '/public/' . 'qrcode/min/'.$n;
        //判断目录是否存在
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        //生成唯一文件名
        $file =uniqid().'.png';
        $filename=app()->getRootPath() . '/public/qrcode/min/'.$n."/".$file;
        //写入文件
        file_put_contents($filename,$result);
        $f='/qrcode/min/'.$n."/".$file;
        if ($domain){
            return  request()->domain().$f;
        }else{
            return $f;
        }

    }


    /**
     * @param $file
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:删除二维码文件
     */
    public static function delQrcode($file)
    {
        //这里传入的$file 是我这边存入数据库的图片.调用unlink函数删除服务器上的图片文件
        $path = app()->getRootPath() .'public'.$file;
        if (file_exists($path)) {
            @unlink ($path);
        };
    }


    //添加日志
    public static function add_log($data,$path=""){
        if (empty($path)) $path="min_qrcode";
        $file = date("Y_m_d", time());
        $jia=date("Ym");
        $file_path = app()->getRootPath()."Logs/".$path."/".$jia;
        if (!is_dir($file_path)) {
            mkdir($file_path, 0777, true);
        }
        @file_put_contents(
            $file_path.'/'.$file.'.log',
            date('Y-m-d H:i:s', time()).' '.json_encode($data)."\r\n",
            FILE_APPEND
        );
    }


    /**
     * @return mixed
     * 获取accessToken
     */
    public static function getAccessToken()
    {
        $tokenUrl="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".self::_C("APPID")."&secret=".self::_C("APP_SECRET");
        $getArr=array();
        $tokenArr=json_decode(self::send_post($tokenUrl,$getArr,"GET"));
        $access_token=self::checkWXToken($tokenArr->access_token);
        return $access_token;
    }


    /**
     * @param $access_token
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe: 验证access_token是否有效
     */
    protected static function checkWXToken($access_token){
        //请求微信不限制调用次数的接口
        $ipurl = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$access_token;
        $ipresult = self::getSSLPage($ipurl);
        $ipdata = json_decode($ipresult,true);

        if($ipdata['errcode'] == '40001'){
            self::add_log(date('Y-m-d H:i:s').' access_token提前失效，进入二次获取token'.PHP_EOL,"access_token");
            //   file_put_contents('access_token.txt',date('Y-m-d H:i:s').' access_token提前失效，进入二次获取token'.PHP_EOL,FILE_APPEND);
            $access_token = self::getAccessToken();
        }
        return $access_token;
    }


    /**
     * @param $url
     * @param $data
     * @return bool|string
     */
    protected static function api_notice_increment($url, $data){
        $ch = curl_init();
        $header = "Accept-Charset: utf-8";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        //curl_setopt($ch,  CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return false;
        }else{
            return $tmpInfo;die;
        }
    }

    /**
     * @param $url
     * @param $post_data
     * @param string $method
     * @return false|string
     * 发送post请求
     */
    protected static function send_post($url, $post_data,$method='POST') {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => $method, //or GET
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60 // 超时时间（单位:s）
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;

    }



    /**
     * @param $url
     * @return bool|string
     *
     */
    protected static function getSSLPage($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSLVERSION, 30);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

}