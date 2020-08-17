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

namespace app\admin\controller;


use app\common\controller\AdminBaseController;
use app\admin\library\Push as Pushs;

class Push extends AdminBaseController
{
    protected function initialize()
    {
        parent::initialize(); // TODO: Change the autogenerated stub
    }

    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:百度站长
     */
    public function bindex(){

        return $this->fetch();
    }



    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: zhanzhang
     * @describe: 百度站长提交
     */
    public function zhanzhang(){
        if (IS_POST){
            $action = $this->request->post("action");
            $urls = $this->request->post("urls");

            $urls = explode("\n", $urls);
            $urls = array_unique(array_filter($urls));
            if (!$urls) {
                $this->error("URL列表不能为空");
            }

            $result = false;
            if ($action == 'urls') {
                $result = Pushs::init(['type' => 'zhanzhang'])->realtime($urls);
            } elseif ($action == 'del') {
                $result = Pushs::init(['type' => 'zhanzhang'])->delete($urls);
            }
            if ($result) {
                $data = Pushs::init()->getData();
                $this->success("推送成功", null, $data);
            } else {
                $this->error("推送失败：" . Pushs::init()->getError());
            }
        }
    }


    /**
     * @return string
     * @throws \Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/30 0030
     * @describe:熊掌号
     */
    public function xindex(){

        return $this->fetch();
    }



    /**
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: xiongzhang
     * @describe:
     */
    public function xiongzhang()
    {
        $action = $this->request->post("action");
        $urls = $this->request->post("urls");
        $urls = explode("\n", $urls);
        $urls = array_unique(array_filter($urls));
        if (!$urls) {
            $this->error("URL列表不能为空");
        }
        $result = false;
        if ($action == 'urls') {
            $type = $this->request->post("type");
            if ($type == 'realtime') {
                $result = Pushs::init(['type' => 'xiongzhang'])->realtime($urls);
            } else {
                $result = Pushs::init(['type' => 'xiongzhang'])->history($urls);
            }
        } elseif ($action == 'del') {
            $result = Pushs::init(['type' => 'xiongzhang'])->delete($urls);
        }

        if ($result) {
            $data = Pushs::init()->getData();
            $this->success("推送成功", null, $data);
        } else {
            $this->error("推送失败：" . Pushs::init()->getError());
        }
    }


}