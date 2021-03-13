<?php


namespace app\common\service;

/**
 * Class RedisPage
 * @package app\common\service
 * redis数据分页
 */
class RedisPage
{

    protected $_redis;
    protected $_redis_ip = '127.0.0.1'; //ip
    protected $_redis_port = 6379; //端口
    protected $_redis_db = 1; //数据库号
    protected $_hash_prefix = 'my_data'; //前缀名称

    /**
     * 当前实例
     * @var object
     */
    // protected static $instance;

    public function __construct($hash_prefix=''){
        if($hash_prefix != '') $this->_hash_prefix = $hash_prefix;
        $this->_redis = new \Redis();
        $this->_redis->connect($this->_redis_ip, $this->_redis_port);
        $this->_redis->select($this->_redis_db);
    }

    /**
     * @return object|static
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/6/25 0025
     * @describe:获取实例对象
     */
    /*  public static function instance()
      {
          if (is_null(self::$instance)) {
              self::$instance = new static();
          }
          return self::$instance;
      }*/

    /*
       * 添加记录
       * @param $id id
       * @param $data hash数据
       * @param $hashName Hash 记录名称
       * @param $SortName Redis SortSet 记录名称
       * @param $redis Redis 对象
       * @return bool
       */
    public function set_redis_page_info($id,$data){
        if(!is_numeric($id) || !is_array($data)) return false;
        $hashName = $this->_hash_prefix.'_'.$id;
        $this->_redis->hMset($hashName, $data);
        $this->_redis->zAdd($this->_hash_prefix.'_sort',$id,$id);
        return true;
    }
    /*
        * 获取分页数据
        * @param $page 当前页数
        * @param $pageSize 每页多少条
        * @param $hashName Hash 记录名称
        * @param $SortName Redis SortSet 记录名称
        * @param $redis Redis 对象
        * @param $key 字段数组 不传为取出全部字段
        * @return array
        */
    public function get_redis_page_info($page,$pageSize,$key=array())
    {
        if (!is_numeric($page) || !is_numeric($pageSize)) return false;
        $limit_s = ($page - 1) * $pageSize;
        $limit_e = ($limit_s + $pageSize) - 1;
        $range = $this->_redis->ZRANGE($this->_hash_prefix . '_sort', $limit_s, $limit_e); //指定区间内，带有 score 值(可选)的有序集成员的列表。
        $count = $this->_redis->zCard($this->_hash_prefix . '_sort'); //统计ScoreSet总数
        $pageCount = ceil($count / $pageSize); //总共多少页
        $pageList = array();
        foreach ($range as $qid) {
            if (count($key) > 0) {
                $pageList[] = $this->_redis->hMGet($this->_hash_prefix . '_' . $qid, $key); //获取hash表中所有的数据
            } else {
                $pageList[] = $this->_redis->hGetAll($this->_hash_prefix . '_' . $qid); //获取hash表中所有的数据
            }
        }
        $data = array(
            'data' => $pageList, //需求数据
            'page' => array(
                'page' => $page, //当前页数
                'pageSize' => $pageSize, //每页多少条
                'count' => $count, //记录总数
                'pageCount' => $pageCount //总页数
            )
        );
        return $data;
    }


    /*
     * 删除记录
     * @param $id id
     * @param $hashName Hash 记录名称
     * @param $SortName Redis SortSet 记录名称
     * @param $redis Redis 对象
     * @return bool
     */
    public function del_redis_page_info($id){
        if(!is_array($id)) return false;
        foreach($id as $value){
            $hashName = $this->_hash_prefix.'_'.$value;
            $this->_redis->del($hashName);
            $this->_redis->zRem($this->_hash_prefix.'_sort',$value);
        }
        return true;
    }

    /*
        * 清空数据
        * @param string $type db:清空当前数据库 all:清空所有数据库
        * @return bool
        */
    public function clear($type='db'){
        if($type == 'db'){
            $this->_redis->flushDB();
        }elseif($type == 'all'){
            $this->_redis->flushAll();
        }else{
            return false;
        }
        return true;
    }



}