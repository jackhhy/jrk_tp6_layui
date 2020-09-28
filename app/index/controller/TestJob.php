<?php


namespace app\index\controller;


use app\BaseController;
use think\Db;
use think\Log;
use think\Queue;

class TestJob extends BaseController
{


    /**
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:定时任务
     */
    public function job(){
        //参数
        $params=['id'=>1];
        //队列任务名称
        $jobname = "MakeOrderAutoDevice";
        // 1.当前任务将由哪个类来负责处理。
        //   当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法
        $jobHandlerClassName = 'app\index\job\MakeOrderAutoDevice';
        // 2.当前任务归属的队列名称，如果为新队列，会自动创建
        $jobQueueName = $jobname;
        // 3.当前任务所需的业务数据
        $jobData = $params;
        // 4.将该任务推送到消息队列，延迟35秒
        $isPushed = Queue::later(35, $jobHandlerClassName, $jobData, $jobQueueName);
        // database 驱动时，返回值为 1|false  ;   redis 驱动时，返回值为 随机字符串|false
        if ($isPushed !== false) {
            echo 'job_begin_record';
            //已加入队列
        } else {
            echo 'Oops, something went wrong.';
        }
    }

}