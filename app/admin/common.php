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
// | Date: 2020/6/27 0027
// +----------------------------------------------------------------------
// | Description:  
// +----------------------------------------------------------------------


/**
 * @param $rules
 * @param $pid
 * @param bool $all
 * @return array
 * @author: Hhy <jackhhy520@qq.com>
 * @describe:传递一个父级分类ID返回所有子分类
 */
function getChildsRule($rules, $pid, $all = true)
{
    $arr = [];
    foreach ($rules as $v) {
        if ($v['pid'] == $pid) {
            if ($all) {
                $arr[] = $v;
            } else {
                $arr[] = (int)$v['id'];
            }

            $arr = array_merge($arr, getChildsRule($rules, $v['id']));
        }
    }
    return $arr;
}



/**
 * @param $qq
 * @return array
 * @author: LuckyHhy <jackhhy520@qq.com>
 * @describe:获取QQ信息
 */
function getQQInfo($qq)
{
    $returnArr = ['code' => 0, 'msg' => '获取失败'];
    if (!$qq || !preg_match('|^[1-9]\d{4,10}$|i', $qq)) {
        $returnArr['msg'] = 'QQ格式错误';
        return $returnArr;
    }
    $nickname = file_get_contents('https://r.qzone.qq.com/fcg-bin/cgi_get_portrait.fcg?g_tk=1518561325&uins=' . $qq);
    $image = 'http://q.qlogo.cn/headimg_dl?dst_uin=' . $qq . '&spec=100';
    if (strstr($nickname, 'portraitCallBack')) {
        $name = trim(mb_convert_encoding($nickname, "UTF-8", "GBK"), 'portraitCallBack()');
        $name = json_decode($name, true);
        if (isset($name[$qq][6]) && !empty($name[$qq][6])) {
            $name = $name[$qq][6];
        } else {
            $name = '游客';
        }
        $returnArr = array('code' => 1, 'msg' => '成功', 'image' => $image, 'name' => $name, 'qq' => $qq);
        //触发事件保存QQ信息
        event("UserQQAfter", [$returnArr]);
    } else if (strstr($nickname, '_Callback')) {
        $returnArr['msg'] = '获取昵称失败';
    }
    return $returnArr;
}

/**
 * @param $data 下拉框数据源
 * @param int $selected_id 选择数据ID
 * @param string $show_field 显示名称
 * @param string $val_field 显示值
 * @author: Hhy <jackhhy520@qq.com>
 * @describe: 下拉选择框组件
 */
function make_option($data, $selected_id = 0, $show_field = 'name', $val_field = 'id')
{
    $html = '';
    $show_field_arr = explode(',', $show_field);
    //dump($data);
    if (is_array($data)) {
        foreach ($data as $k => $v) {
            $show_text = '';
            if (is_array($v)) {
                foreach ($show_field_arr as $s) {
                    $show_text .= $v[$s] . ' ';
                }
                $show_text = substr($show_text, 0, -1);
                $val_field && $k = $v[$val_field];
            } else {
                $show_text = $v;
            }
            $sel = '';
            if ($selected_id && $k == $selected_id) {
                $sel = 'selected';
            }
            $html .= '<option value = ' . $k . ' ' . $sel . '>' . $show_text . '</option>';
        }
    }
    echo $html;
}

/**
 * @param $content HTML或者文章
 * @param int $num 内容第几张图片
 * @return false|null|\tcwei\smallTools\src
 * @author: Hhy <jackhhy520@qq.com>
 * @describe:获取内容第几张图片
 */
function get_content_image_one($content, $num = 1)
{
    return \tcwei\smallTools\GetImgSrc::src($content, $num);
}


/**
 * @param $content HTML或者文章
 * @param int $startNum 默认为1，从第一张图片开始抽取
 * @return \tcwei\smallTools\图片地址的集合数组，若无则返回空数组[]
 * @author: Hhy <jackhhy520@qq.com>
 * @describe:获取内容里第几张开始的所有图片地址
 */
function get_content_images($content, $startNum = 1)
{
    return \tcwei\smallTools\GetImgSrc::srcList($content, $startNum);
}


/**
 * @param $content
 * @return mixed
 * @author: Hhy <jackhhy520@qq.com>
 * @describe:字符串替换
 */
function str_place($content)
{
    return str_replace("<br />", "\n\t", $content);
}




/**
 * @param $size
 * @param string $delimiter
 * @return string
 * @author: Hhy <jackhhy520@qq.com>
 * @date: 2020/7/1 0001
 * @describe:
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}


/**
 * @param $time
 * @return false|string
 * @author: LuckyHhy <jackhhy520@qq.com>
 * @date: 2020/7/1 0001
 * @describe:
 */
function ftime($time){
return \Jrk\Times::friendlyDate($time,"full");
}