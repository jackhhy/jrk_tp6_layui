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


use think\Exception;
use think\facade\Session;

class WxSendTemplte
{
    private static $appid = '';
    //过期时间
    private static $expTime = 3600;
    //
    private static $secret = '';
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
    private static function getToken()
    {
        if (Session::get('access_token')) {
            $access_token = Session::get('access_token');
        } else {
            $urla = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . self::$appid . "&secret=" . self::$secret;
            $outputa = self::curlGet($urla);
            $result = json_decode($outputa, true);
            $access_token = $result['access_token'];
            Session::set('access_token', $access_token, self::$expTime);
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
        if ($resultData['errcode']==0){
            return  ['code'=>1,'msg'=>'发送成功'];
        }
        return  ['code'=>$resultData['errcode'],'msg'=>$resultData['errmsg']];
    }


    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:发送模板推送消息
     */
    public function sendMsg($openid,$template_id)
    {
        $weiwei_token = self::getToken();
        $send_data = [
            'openid' => $openid, // 用户openid
            'access_token' => $weiwei_token,
            'template_id' => $template_id, // 填写你自己的消息模板ID
            'data' => [ // 模板消息内容，根据模板详情进行设置
                'first' => ['value' => urlencode("尊敬的某某某先生，您好，您太帅了"), 'color' => "#743A3A"],
                'toName' => ['value' => urlencode("2019必胜猪"), 'color' => 'blue'],
                'gift' => ['value' => urlencode("2019必胜猪"), 'color' => 'blue'],
                'time' => ['value' => urlencode("2019必胜猪"), 'color' => 'green'],
                'remark' => ['value' => urlencode("请收下我的膝盖"), 'color' => '#743A3A']
            ],
            'url' => 'http://cssnb.com'
        ];
        return self::sendMessage($send_data);
    }


    /**
     * @param $touser
     * @param $name
     * @param $mobile
     * @param $time
     * @param $level
     * @param $remark
     * @return array
     * @throws Exception
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:
     */
    public static function sendMsgNewCustomer($touser,$name,$mobile,$time,$level,$remark){
        $template_id="_5Vv5JSf9n0ht-VY8wFW8NL_3t0MtG-Wb9EY9aOZlC4"; //消息模板ID
        if (empty($level)) $level="A（重点客户）";
        if (empty($remark)) $remark="请下次跟进时间及时跟进客户！";
        $time_=date("Y-m-d H:i:s",$time);
        $template=[
            'touser' => $touser,//"o8MU45yBvg2DRzphyFOzK1RlzOe8", // 用户openid
            'template_id' => $template_id, // 消息模板ID
            'url'=>"http://crm.1230t.com/index.html#/login", //点击模板消息会跳转的链接
            'topcolor'=>"#7B68EE",
            'data' => [ // 模板消息内容，根据模板详情进行设置
                'first'    => ['value' => urlencode("您好，您有一个新客户需要联系，请关注！"),'color' => "#743A3A"],
                'keyword1'=>array('value'=>urlencode($name),'color'=>'#FF0000'),
                'keyword2'=>array('value'=>urlencode($mobile),'color'=>'#FF0000'),
                'keyword3'=>array('value'=>urlencode($time_),'color'=>'#FF0000'),
                'keyword4'=>array('value'=>urlencode($level),'color'=>'#743A3A'),
                'remark' =>array('value'=>urlencode($remark),'color'=>'#7B68EE')
            ],
        ];
        return  self::pushSend($template);
    }


    /**
     * @param $template
     * @return array
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:
     */
    private static function pushSend($template){
        $weiwei_token=self::getToken();
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $weiwei_token;
        $result = self::curlPost($url, urldecode($json_template));
        $resultData = json_decode($result, true);
        if ($resultData['errcode']==0){
            return  ['code'=>1,'msg'=>'发送成功'];
        }
        return  ['code'=>$resultData['errcode'],'msg'=>$resultData['errmsg']];
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