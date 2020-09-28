<?php


namespace app\index\job;


use think\facade\Db;
use think\queue\Job;

class MakeOrderAutoDevice
{


    /**
     * @param Job $job
     * @param $param
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:队列执行
     */
    public function fire(Job $job, $param)
    {
        try {
            //参数
            $data=$param;

            /*c操作开始*/
            $res=Db::name("test")->where("id",$data['id'])->delete();

           if (!$res){
               if ($job->attempts() > 2) {
                   writeLog("任务已经重试2次，删除任务","job");
                   $job->delete();
                   return ;
               }
           }
            writeLog("执行成功：".$res,"job");
            $job->delete();
            /*操作结束*/
            //删除任务
            $job->delete();
            return;

        }catch (\Exception $exception){
            $job->delete();
            writeLog($exception->getMessage(),"exception");
        }
    }


    /*在宝塔里的  Supervisord管理器==添加手护进程
     * 名称就是 队列名称，启动命令是：php think queue:listen --queue
     * 启动用户：root
     * */

    /**
     * @param $data
     * @author: Hhy <jackhhy520@qq.com>
     * @describe: 执行失败
     */
    public function failed($data){
        // 记录日志
        writeLog($data,'failed_job');
    }

}