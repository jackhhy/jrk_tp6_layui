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
use think\Exception;

class AttachMent extends AdminBaseModel implements Comm
{

    //附件管理
    protected $name="attachment";

    protected $image_type=[1=>'本地',2=>'七牛云',3=>'OSS',4=>'COS'];

    protected $module_type=[1=>'后台上传',2=>'用户生成'];

    /**
     * @param array $param
     * @param string $order
     * @return mixed|\think\response\Json
     * @throws \think\db\exception\DbException
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/7/2 0002
     * @describe:获取附件列表
     */
    public function getAdminPageData($param = [], $order = 'id asc')
    {
        // TODO: Implement getAdminPageData() method.
        $where = [];
       //上传时间段
        if (isset($param['time']) && $param['time'] != '') {
            $ck=@explode(" ~ ",$param['time']);
            $b=$ck[0]." 00:00:00";
            $e=$ck[1]." 23:59:59";
            $where[] = ['create_time', 'between time', [strtotime($b),strtotime($e)]];
        }
        //文件类型
        if (isset($param['type']) && $param['type'] != '') {
            $where[] = ['type', '=', $param['type']];
        }
        try {
            $data = self::where($where)->order($order)->select()->toArray();
            $count = self::where($where)->count("id");
           // dd($data);
            if (!empty($data)) {
                foreach ($data as $k=>$v){
                    $data[$k]['size']=format_bytes($v['size']);
                    $data[$k]['image_type']=$this->image_type[$v['image_type']];
                    $data[$k]['module_type']=$this->module_type[$v['module_type']];
                }
            }
            // dd($data);
            return parent::ajaxResult($data, $count);
        } catch (Exception $exception) {
            return parent::ajaxResult([], 0, 100, $exception->getMessage());
        }
    }


    /**
     * @param $id
     * @return mixed|void
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/7/2 0002
     * @describe:删除附件
     */
    public function delById($id)
    {
        // TODO: Implement delById() method.
        try {
            if (is_array($id)){
                $ids=$id;
            }else{
                $ids=@explode(",",$id);
            }
            $result = self::where('id', 'in',$ids)->select();
            if ($result) {
                  foreach ($result as $k=>$v){
                      if (file_exists(app()->getRootPath().'public' .$v['att_dir'])){
                          @unlink(app()->getRootPath().'public' .$v['att_dir']);
                      }
                  }
                self::where('id', 'in',$ids)->delete();
                return self::JsonReturn("删除成功");
            } else {
                return self::JsonReturn("暂无数据",0);
            }
        } catch (\Exception $exception) {
            return self::JsonReturn($exception->getMessage(),0);
        }

    }


    /**
     * @param int $type
     * @param int $page
     * @return \think\Paginator
     * @throws \think\db\exception\DbException
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @date: 2020/7/2 0002
     * @describe:获取图片或文件
     */
    public function GetImagesFiles($type=1,$page=21){
        if ($type==1){
            $ext=['jpeg','jpg','png','gif'];
        }else{
            $ext=['zip','rar','pdf','txt','doc','docx','ppt','txt','xlsx','mp3','mp4'];
        }
        $data = self::where('ext','in',$ext)->order("create_time desc")->paginate($page);
        return $data;

    }


    public function doAll($data)
    {
        // TODO: Implement doAll() method.
    }


    /**
     * @param $name //附件名称
     * @param $size //附件大小
     * @param $type //附件类型
     * @param $att_dir //附件路径
     * @param string $satt_dir //压缩图片路径
     * @param int $imageType //图片上传类型 1本地 2七牛云 3OSS 4COS
     * @param $img_dir
     * @param $ext
     * @param int $module_type //图片上传模块类型 1 后台上传 2 用户生成
     * @return AttachMent
     * @author: Hhy <jackhhy520@qq.com>
     * @date: 2020/6/29 0029
     * @describe:添加附件记录
     */
    public static function attachmentAdd($name,$att_size,$att_type,$att_dir,$satt_dir='',$imageType = 1 ,$img_dir='', $ext='',$module_type=1)
    {
        $data['name'] = $name;
        $data['att_dir'] = $att_dir;
        $data['satt_dir'] = $satt_dir;
        $data['size'] = $att_size;
        $data['type'] = $att_type;
        $data['image_type'] = $imageType;
        $data['module_type'] = $module_type;
        $data['img_dir']=$img_dir;
        $data['ext']=$ext;
        return self::create($data);
    }



}