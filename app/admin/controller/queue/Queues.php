<?php
    // +----------------------------------------------------------------------
    // | Created by PHPstorm: JRKAdmin框架 [ JRKAdmin ] 
    // +----------------------------------------------------------------------
    // | Copyright (c) 2019~2022 [LuckyHHY] All rights reserved.
    // +----------------------------------------------------------------------
    // | SiteUrl: http://www.luckyhhy.cn
    // +----------------------------------------------------------------------
    // | Author: LuckyHhy <jackhhy520@qq.com>
    // +----------------------------------------------------------------------
    // | Date: 2020/3/17-16:04
    // +----------------------------------------------------------------------
    // | Description:  
    // +----------------------------------------------------------------------


    namespace app\admin\controller\queue;


    use app\common\controller\AdminBaseController;
    use think\Queue;

    class Queues extends AdminBaseController
    {

        /**
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/17
         * @name: actionWithHelloJob
         * @describe:数据处理：
         * php think queue:work --queue helloJobQueue (单次执行)
        ​* php think queue:listen --queue helloJobQueue(一直会监听)
         */
        public function actionWithHelloJob(){
            // 1.当前任务将由哪个类来负责处理。
            //   当轮到该任务时，系统将生成一个该类的实例，并调用其 fire 方法

            $jobHandlerClassName  = 'app\admin\job\Hello';
            // 2.当前任务归属的队列名称，如果为新队列，会自动创建
            $jobQueueName     = "helloJobQueue";
            // 3.当前任务所需的业务数据 . 不能为 resource 类型，其他类型最终将转化为json形式的字符串
            //   ( jobData 为对象时，需要在先在此处手动序列化，否则只存储其public属性的键值对)
            $jobData          = [ 'ts' => time(), 'bizId' => uniqid() , 'a' => 1 ] ;
            $isPushed = Queue::push( $jobHandlerClassName , $jobData, $jobQueueName );
            // database 驱动时，返回值为 1|false  ;   redis 驱动时，返回值为 随机字符串|false
            var_dump($isPushed);
            if( $isPushed !== false ){
                echo date('Y-m-d H:i:s') . " a new Hello Job is Pushed to the MQ"."<br>";
            }else{
                echo 'Oops, something went wrong.';
            }
        }

    }