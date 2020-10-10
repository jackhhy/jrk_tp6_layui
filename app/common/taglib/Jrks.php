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
// | Date:
// +----------------------------------------------------------------------
// | Description: 自定义标签
// +----------------------------------------------------------------------

namespace app\common\taglib;


use think\template\TagLib;

class Jrks extends TagLib
{

    protected $tags=[
        // 标签定义： attr 属性列表 close 是否闭合（0 或者1 默认1） alias 标签别名 level 嵌套层次
        'list'   =>array('attr' => 'table,where,order,limit,id,field','close' => 1,'level'=>3),//列表
        'inputform'=>array('attr'=>'label,value,name,id,place,verify,word,type,style,lang,class','close'=>0),
        'input'=>array('attr'=>'value,name,id,place,verify,type,style,class','close'=>0),
        'textarea'=>array('attr'=>'value,name,verify,style,class,place','close'=>0)
    ];


    /**
     * @param $tag
     * @param $content
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:查询列表
     */
    public function tagList($tag,$content){
        $name     = !empty($tag['table']) ? $tag['table'] : 'article';
        $field     = !empty($tag['field ']) ? $tag['field '] : '*';
        $map="";
        if(!empty($tag['where'])){
            $map=$tag['where'];
        }
        $limit        = empty($tag['limit']) ? 10 : $tag['limit'];
        $order        = empty($tag['order']) ? 'id desc' : $tag['order'];

        $where[] = "status = 1 ";
        if ($map) {
            $where[] = $map;
        }
        $map = implode(" and ", $where);

        $parse  = $parse   = '<?php ';
        $parse .= '$__LIST__ = \think\facade\Db::name(\''.$name.'\')->where(\''.$map.'\')->field(\''.$field.'\')->limit(\''.$limit.'\')->order(\''.$order.'\')->select();';
        $parse .= 'foreach ($__LIST__ as $key => $'.$tag['id'].') {';
        $parse .= '?>';
        $parse .= $content;
        $parse .= '<?php } ?>';
        return $parse;
    }


    /*
     * 调用
     * {jrks:list  table="table" id="v" where="1=1"}
     *   {$v.id}
     * {/jrks:list}
     *
     * */


    /**
     * @param $tag
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @name: tagTextarea
     * @describe: 文本域
     */
    public function tagTextarea($tag){
        $class="";
        if(!empty($tag['class'])){ //类名称
            $class=$tag['class'];
        }
        $style="";
        if(!empty($tag['style'])){ //样式
            $style=$tag['style'];
        }
        $ver="";
        if(!empty($tag['verify'])){
            $ver=$tag['verify'];
        }
        $place="";
        if(!empty($tag['place'])){
            $place=$tag['place'];
        }
        $html = "<div class='layui-form-item'>";
        $html .= "<div class='layui-form-label'>".$tag['label']."</div> <div class='layui-input-block input-custom-width'>";
        if (empty($tag['value'])) {
            $html .= "<textarea name='".$tag['name']."' class='layui-textarea ".$class."' lay-verType='tips' lay-reqText='".$place."' autocomplete='off' placeholder='".$place."' lay-verify='".$ver."' style='".$style."'></textarea>";
        } else {
            $html .= "<textarea name='".$tag['name']."'  class='layui-textarea ".$class."' lay-verType='tips' lay-reqText='".$place."'  autocomplete='off' lay-verify='".$ver."' style='".$style."' placeholder='".$place."'>";
            $html .= "<?php echo ".$tag['value']."?>";
            $html .= "</textarea>";
        }
        $html .= "</div>";
        if(!empty($tag['word'])) {
            $html .= " <div class=\"layui-form-mid layui-word-aux\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$tag['word']."</div>";
        }
        $html .= "</div>";
        return $html;
    }

    /**
     * @param $tag
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @name: tagInput
     * @describe:单个 input输入
     */
    public function tagInput($tag){
        if(empty($tag['type'])){ //input 类型
            $type="text";
        }else{
            $type=$tag['type'];
        }
        $style="";
        if(!empty($tag['style'])){ //样式
            $style=$tag['style'];
        }
        $class="";
        if(!empty($tag['class'])){ //类名称
            $class=$tag['class'];
        }
        if(empty($tag['id']) && !isset($tag['id'])){ //ID
            $id="";
        }else{
            $id=$tag['id'];
        }
        $ver="";
        if(!empty($tag['verify'])){
            $ver=$tag['verify'];
        }
        if (empty($tag['value'])) {
            $html='<input type="'.$type.'"  style="'.$style.'" name="'.$tag['name'].'" id="'.$id.'"   value="" placeholder="'.$tag['place'].'" lay-verify="'.$ver.'" lay-verType="tips" lay-reqText="'.$tag['place'].'"  autocomplete="off"  class="layui-input '.$class.'">';
        } else {
            $val=$this->autoBuildVar($tag['value']);
            $html= "<input type='".$type."' name='".$tag['name']."' style='".$style."'  id='".$id."' lay-verify='".$tag['verify']."' lay-verType='tips' lay-reqText='".$tag['place']."' autocomplete='off'  class='layui-input ".$class."'  placeholder='".$tag['place']."' value='";
            $html.= "<?php echo ".$val."?>";
            $html.= "' />";
        }
        return $html;
    }

    /**
     * @param $tag
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @name: tagInput
     * @describe:input 输入标签
     */
    public function tagInputForm($tag) {
        $html = "<div class=\"layui-form-item\" >";
        $ver="";
        if(!empty($tag['verify'])){
            $ver=$tag['verify'];
            $html.="<label class=\"layui-form-label label-required-next \">".$tag['label']."</label>";
        }else{
            $html.="<label class=\"layui-form-label \">".$tag['label']."</label>";
        }
        $val="";
        if(!empty($tag['value'])){ //值
            $val=$this->autoBuildVar($tag['value']);
        }
        $tg="inline";
        if(empty($tag['lang'])){ //行内或者单行
            $tg="block";
        }
        if(empty($tag['type'])){ //input 类型
            $type="text";
        }else{
            $type=$tag['type'];
        }
        if(empty($tag['id']) && !isset($tag['id'])){ //ID
            $id="";
        }else{
            $id=$tag['id'];
        }
        $style="";
        if(!empty($tag['style'])){ //样式
            $style=$tag['style'];
        }
        $class="";
        if(!empty($tag['class'])){ //类名称
            $class=$tag['class'];
        }


        if($tg=="inline"){
            $html.='<div class="layui-input-inline input-custom-width" style="'.$style.'">';
        }else{
            $html.='<div class="layui-input-block input-custom-width"  style="'.$style.'">';
        }
        if (!isset($tag['value']) ||empty($tag['value'])) {
            $html.='<input type="'.$type.'" name="'.$tag['name'].'" id="'.$id.'"   value="" placeholder="'.$tag['place'].'" lay-verify="'.$ver.'" lay-verType="tips" lay-reqText="'.$tag['place'].'"  autocomplete="off"  class="layui-input '.$class.'">';
            if(!empty($tag['word'])){ //注释
                $html.='<p class="help-block">'.$tag['word'].'</p>';
            }
        } else {
            $html .= "<input type='".$type."' name='".$tag['name']."' id='".$id."' lay-verify='".$ver."' lay-verType='tips' lay-reqText='".$tag['place']."' autocomplete='off'  class='layui-input ".$class."'  placeholder='".$tag['place']."' value='";
            $html .= "<?php echo ".$val."?>";
            $html .= "' />";
            if(!empty($tag['word'])){ //注释
                $html.='<p class="help-block">'.$tag['word'].'</p>';
            }
        }
        $html .= "</div>";
        /*  if(!empty($tag['word'])){ //注释
              if($tg=="inline"){
                  $html.='<div class="layui-form-mid layui-word-aux layui-text text-success">'.$tag['word'].'</div>';
              }else{
                  $html.='<div class="layui-form-mid layui-word-aux layui-text text-success">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tag['word'].'</div>';
              }
          }*/
        $html .= "</div>";
        return $html;
    }

}