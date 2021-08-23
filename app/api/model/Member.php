<?php


namespace app\api\model;


use think\Model;

class Member extends Model
{

    protected $name="member";

    protected $autoWriteTimestamp="int";
    // 定义时间戳字段名
    protected $createTime = 'create_time';


}