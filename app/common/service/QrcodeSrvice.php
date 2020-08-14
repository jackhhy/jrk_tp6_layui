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

namespace app\common\service;


use Jrk\Random;
use Endroid\QrCode\QrCode;
use think\Exception;

class QrcodeSrvice
{

    /**
     * @param $text
     * @param int $size
     * @param bool $domain
     * @return string
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:生成普通二维码
     */
    public static function make_qrcode($text,$size=105,$domain=false){
        $img_name = Random::alnum(15);
        $n = date("Ym");
        $dir= app()->getRootPath()."public/qrcode/code/".$n;
        //判断目录是否存在
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $pathname = $dir."/" . $img_name . '.png';
        $qrCode = new QrCode();
        $qrCode->setText($text)
            ->setSize($size)
            ->setPadding(15)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        try {
            $qrCode->save($pathname);
            $str="/qrcode/code/".$n."/". $img_name . '.png';
            if ($domain){
                return request()->domain().$str;
            }else{
                return $str;
            }
        } catch (\Endroid\QrCode\Exceptions\ImageTypeInvalidException $exception) {
            return "";
        }
    }


    /**
     * @param $text
     * @param $logo
     * @return string
     * @throws Exception
     * @author: Hhy <jackhhy520@qq.com>
     * @describe:生成带logo 的二维码
     */
    public static function QrCodeWithLogo($text,$logo,$domain=false){
        if (!file_exists($logo)){
            exception("logo地址不存在");
        }
        $img_name = Random::alnum(15);
        $n = date("Ym");
        $dir= app()->getRootPath()."public/qrcode/".$n;
        //判断目录是否存在
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $pathname = $dir."/" . $img_name . '.png';
        $qrCode = new QrCode();
        $qrCode->setText($text)
            ->setSize(300)
            ->setLogo($logo)
            ->setLogoSize(60)
            ->setErrorCorrection('high')
            ->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
            ->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
            ->setImageType(QrCode::IMAGE_TYPE_PNG);
        $qrCode->save($pathname);
        $str="/qrcode/".$n."/". $img_name . '.png';
        if ($domain){
            return request()->domain().$str;
        }else{
            return $str;
        }
    }



}