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

namespace app\admin\library\push;


abstract class Driver
{
    protected $options = [];
    protected $error = '';
    protected $data = [
        "remain"        => 0,
        "success"       => 0,
        "not_same_site" => [],
        "not_valid"     => []
    ];

    /**
     * 推送实时链接
     * @param array $urls URL链接数组
     * @return bool
     */
    abstract public function realtime($urls);

    /**
     * 推送历史链接
     * @param array $urls URL链接数组
     * @return  bool
     */
    abstract public function history($urls);

    /**
     * 删除链接
     * @param array $urls URL链接数组
     * @return  boolean
     */
    abstract public function delete($urls);

    /**
     * 获取错误信息
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * 设置错误信息
     * @param string $msg
     */
    protected function setError($msg)
    {
        $this->error = $msg;
    }

    /**
     * 获取返回的数据
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * 设置返回的数据
     * @param mixed $data
     */
    protected function setData($data)
    {
        $this->data = array_merge($this->data, $data);
    }
}