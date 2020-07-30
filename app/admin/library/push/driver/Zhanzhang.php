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
// | Date: 2020/7/30 0030
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------

namespace app\admin\library\push\driver;


use app\admin\library\push\Driver;
use Jrk\Http;

class Zhanzhang extends Driver
{
    protected $options = [
        'site'  => '',
        'token' => '',
    ];

    /**
     * 构造函数
     * @param array $options 参数
     * @access public
     */
    public function __construct($options = [])
    {
        if (!empty($options)) {
            $this->options['site'] = isset($options['site']) ? $options['site'] : '';
            $this->options['token'] = isset($options['token']) ? $options['token'] : '';
        }
    }

    /**
     * 推送实时链接
     * @param array $urls URL链接数组
     * @return bool
     */
    public function realtime($urls)
    {
        return $this->request($urls, 'urls');
    }

    /**
     * 推送历史链接
     * @param array $urls URL链接数组
     * @return  bool
     */
    public function history($urls)
    {
        return $this->realtime($urls);
    }

    /**
     * 删除链接
     * @param array $urls URL链接数组
     * @return  bool
     */
    public function delete($urls)
    {
        return $this->request($urls, 'del');
    }


    /**
     * @param $urls
     * @param $type
     * @return bool
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: request
     * @describe:
     */
    protected function request($urls, $type)
    {
        $url = "http://data.zz.baidu.com/{$type}?site={$this->options['site']}&token={$this->options['token']}";
        try {
            $options = [
                CURLOPT_HTTPHEADER => [
                    'Content-Type: text/plain'
                ]
            ];

            $ret = Http::sendRequest($url, implode("\n", $urls), 'POST', $options);
            if ($ret['ret']) {
                $json = (array)json_decode($ret['msg'], true);
                if (!$json || isset($json['error'])) {
                    $this->setError($json['message']);
                    return false;
                }
                $this->setData($json);
                return true;
            }
        } catch (\Exception $e) {
            $this->setError($e->getMessage());
        }
        return false;
    }
}