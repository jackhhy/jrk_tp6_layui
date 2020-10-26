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
// | Date: 
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\common\service;


use think\facade\Session;

class WxSendTemplte
{
    private $appid = '';
    //过期时间
    private $expTime = 3600;
    //
    private $secret = '';
    // 单例模式句柄
    private static $instance;

    /**
     * @return WxSendTemplte
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:获取JwtAuth的句柄
     */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }


    /**
     * JwtService constructor.
     * 私有化构造函数
     */
    private function __construct()
    {

    }

    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:私有化clone函数
     */
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }


    /**
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe: 获取TOKEN,一天就2000条，用一次少一次，跟获取用户信息的access_token 不一样。
     */
    public function getToken()
    {
        if (Session::get('access_token')) {
            $access_token = Session::get('access_token');
        } else {
            $urla = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $this->appid . "&secret=" . $this->secret;
            $outputa = self::curlGet($urla);
            $result = json_decode($outputa, true);
            $access_token = $result['access_token'];
            Session::set('access_token', $access_token, $this->expTime);
        }
        return $access_token;
    }


    /**
     * @param array $data
     * @param string $topcolor
     * @return mixed
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:将模板消息json格式化
     */
    public function sendMessage($data = [], $topcolor = '#0000')
    {
        $template = [
            'touser' => $data['openid'],
            'template_id' => $data['template_id'],
            'url' => $data['url'],
            'topcolor' => $topcolor,
            'data' => $data['data']
        ];
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . self::getToken();
        $result = self::curlPost($url, urldecode($json_template));
        $resultData = json_decode($result, true);
        return $resultData;
    }


    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:发送模板推送消息
     */
    public function sendMsg($openid,$template_id,$data)
    {
        $weiwei_token = self::getToken();
        $send_data = [
            'openid' => $openid, // 用户openid
            'access_token' => $weiwei_token,
            'template_id' => $template_id, // 填写你自己的消息模板ID
            'data'=>$data,
           /* 'data' => [ // 模板消息内容，根据模板详情进行设置
                'first' => ['value' => urlencode("尊敬的某某某先生，您好，您太帅了"), 'color' => "#743A3A"],
                'toName' => ['value' => urlencode("2019必胜猪"), 'color' => 'blue'],
                'gift' => ['value' => urlencode("2019必胜猪"), 'color' => 'blue'],
                'time' => ['value' => urlencode("2019必胜猪"), 'color' => 'green'],
                'remark' => ['value' => urlencode("请收下我的膝盖"), 'color' => '#743A3A']
            ],*/
            'url' => 'http://cssnb.com'
        ];
        // 'url_link' => 'http://cssnb.com' // 消息跳转链接
        $res = self::sendMessage($send_data);
    }


    /**
     * 发送get请求
     * @param string $url 链接
     * @return bool|mixed
     */
    private static function curlGet($url)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            return 'ERROR ' . curl_error($curl);
        }
        curl_close($curl);
        return $output;
    }

    /**
     * 发送post请求
     * @param string $url 链接
     * @param string $data 数据
     * @return bool|mixed
     */
    private static function curlPost($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }


}