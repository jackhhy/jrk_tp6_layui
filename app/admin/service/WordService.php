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
// | Date: 2020/7/31 0031
// +----------------------------------------------------------------------
// | Description: php 生成word文档
// +----------------------------------------------------------------------

namespace app\admin\service;

use Jrk\Tool;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\PhpWord;

class WordService
{

    /**
     * @param $text
     * @param null $title
     * @param bool $save
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文档导出生成word文档
     */
    public static function exportToword($text,$title=null,$save=false){
        $phpWord=new PhpWord(); //实例化
        //调整页面样式
        $sectionStyle = array('orientation' => null,
            'marginLeft' => 300,
            'marginRight' => 300,
            'marginTop' => 300,
            'marginBottom' => 400);
        $section = $phpWord->addSection($sectionStyle);
        //添加页眉
        /*  $header=$section->addHeader();
          $k=$header->addTextRun();
          //页眉添加一张图片
          $k->addImage(app()->getRootPath().'public'.DS."static/images/jrk.jpg",array(
              'width'         => '100%',
              'height'        => 60,
              'marginTop'     => -1,
              'marginLeft'    => 1,
              'wrappingStyle' => 'behind',
          ));*/

        //添加页脚
        $footer = $section->addFooter();
        $f=$footer->addTextRun();

        $f->addImage(app()->getRootPath().'public'.DS."static/images/jrk.jpg",array(
            'width'         => 105,
            'height'        => 65,
            'marginTop'     => -1,
            'marginLeft'    => 1,
            'wrappingStyle' => 'behind',
        ));

        $footer->addPreserveText('Page {PAGE} of {NUMPAGES}.',array('align'=>'center'));

        //添加标题
        if (!empty($title)){
            $section->addText(
                $title,
                array('name' => '黑体', 'size' => 15),
                array('align'=>'center')
            );
        }
        //添加换行符
        $section->addTextBreak(2);

        //添加文本
        if (is_array($text)){
            foreach ($text as $v){
                $section->addText(
                    $v,
                    array('name' => 'Arial', 'size' => 13),
                    array('lineHeight'=>1.5,'indent'=>1)
                );
            }
        }else{
            $section->addText(
                $text,
                array('name' => 'Arial', 'size' => 13),
                array('lineHeight'=>1.5,'indent'=>1)
            );
        }
        $fname=Tool::uniqidDateCode();
        if ($save){
            /*保存文档到本地*/
            $objwrite =IOFactory::createWriter($phpWord);
            $t=date("Ymd",time());
            //保存的路径和中文名称适应
            $dir      = iconv("UTF-8", "GBK", app()->getRootPath().'public'.DS.'words'.DS.$t);
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
            $pa = $t."/".$fname.".docx";
            $objwrite->save(app()->getRootPath().'public'.DS.'phpoffices/words'.DS.$pa);
            return  ['code'=>1,'url'=>'/phpoffices/words/'.$pa,'domain'=>request()->domain(true)];
        }else{
            //不保存到服务器，直接输出浏览器下载
            $name=$fname.".docx"; //文件名称
            $phpWord->save($name,"Word2007",true);
        }
        exit;
    }


    /**
     * @param $text
     * @param bool $save
     * @return array
     * @throws \PhpOffice\PhpWord\Exception\Exception
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @describe:文档生成 html 文件
     */
    public static function makeHtml($text,$save=false){
        $phpWord=new PhpWord(); //实例化
        $section = $phpWord->addSection();

        $fontStyleName = 'oneUserDefinedStyle';
        $phpWord->addFontStyle(
            $fontStyleName,
            array('name' => 'Tahoma', 'size' => 13, 'color' => '1B2232', 'bold' => true)
        );
        if (is_array($text)){
            foreach ($text as $v){
                $section->addText(
                    $v,
                    $fontStyleName
                );
            }
        }else{
            $section->addText(
                $text,
                $fontStyleName
            );
        }
        $fname=Tool::uniqidDateCode();
        if ($save){
            $objwrite = IOFactory::createWriter($phpWord, 'HTML');
            $t=date("Ymd",time());
            //保存的路径和中文名称适应
            $dir      = iconv("UTF-8", "GBK", app()->getRootPath().'public'.DS.'phpoffices/htmls'.DS.$t);
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
            $pa = $t."/".$fname.".html";
            $objwrite->save(app()->getRootPath().'public'.DS.'phpoffices/htmls'.DS.$pa);
            return  ['code'=>1,'url'=>'/phpoffices/htmls/'.$pa,'domain'=>request()->domain(true)];
        }else{
            $name=$fname.".html"; //文件名称
            $phpWord->save($name,"HTML",true);
        }
        exit;
    }

}