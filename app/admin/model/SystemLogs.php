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
// | Date: 2020/6/26 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

namespace app\admin\model;


use app\common\impl\Comm;
use app\common\model\AdminBaseModel;
use think\facade\Config;
use think\facade\Db;
use think\Exception;

class SystemLogs extends AdminBaseModel implements Comm
{

    protected $tableSuffix;

    protected $tableName;


    /**
     * @param array $param
     * @param string $order
     * @return mixed|\think\response\Json
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/7/2 0002
     * @describe:获取数据
     */
    public function getAdminPageData($param = [], $order = 'id desc')
    {
        // TODO: Implement getAdminPageData() method.
        //上传时间段
        if (isset($param['time']) && $param['time'] != '') {
            $tt = strtotime($param['time']);
            $this->tableSuffix = date('Ym', $tt);
        } else {
            $this->tableSuffix = date('Ym', time());
        }
        $this->tableName = "system_log_{$this->tableSuffix}";
        // dd($this->tableName);
        //判断当前表存不存在数据库
        if (!$this->tableExists($this->tableName)) {
            return parent::ajaxResult([], 0, 100, "当前时间：" . $this->tableSuffix . "暂无数据");
        }
        // dd($this->tableSuffix);
        try {
            $data = Db::name($this->tableName)->order($order)->select()->toArray();
            $count = Db::name($this->tableName)->count("id");
            // dd($data);
            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @return array
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     * @Author: LuckyHhy <jackhhy520@qq.com>
     * @name: getTablesList
     * @describe: 全部表
     */
    public function getTablesList()
    {
        $tables = [];
        $database = strtolower(Config::get('database.connections.mysql.database'));
        $sql = 'SHOW TABLES';
        $data = Db::query($sql);
        foreach ($data as $v) {
            $tables[] = $v["Tables_in_{$database}"];
        }

        return $tables;
    }

    /**
     * @param $table
     * @return bool
     * @throws \think\db\exception\BindParamException
     * @throws \think\exception\PDOException
     * @Author: LuckyHhy <jackhhy520@qq.com>
     * @name: tableExists
     * @describe:检查表是否存在
     */
    public function tableExists($table)
    {
        $pre = Config::get('database.connections.mysql.prefix');
        $tables = self::getTablesList();
        if (strpos($table, $pre) === false) {
            $table = $pre . $table;
        }
        return in_array($table, $tables) ? true : false;
    }


    /**
     * @param $data
     * @return \think\response\Json
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/2 0002
     * @describe:删除日志
     */
    public function dels($data)
    {
        try {
            if (!empty($data['times'])) {
                $tt = strtotime($data['times']);
                $this->tableSuffix = date('Ym', $tt);
            } else {
                $this->tableSuffix = date('Ym', time());
            }
               $this->tableName = "system_log_{$this->tableSuffix}";

            if (!$this->tableExists($this->tableName)) {
                return parent::JsonReturn("当前表：" . $this->tableName . "不存在", 0);
            }

            if (is_array($data['id'])){
                $id=$data['id'];
            }else{
                $id=@explode(",",$data['id']);
            }
            $result=Db::name($this->tableName)->where("id","in",$id)->delete();

            if ($result) {
                return self::JsonReturn("删除成功");
            } else {
                return self::JsonReturn("删除失败",0);
            }

        } catch (\Exception $exception) {
            return parent::JsonReturn($exception->getMessage(), 0);
        }
    }


    public function delById($id)
    {
        // TODO: Implement delById() method.
    }

    public function doAll($data)
    {
        // TODO: Implement doAll() method.
    }


}