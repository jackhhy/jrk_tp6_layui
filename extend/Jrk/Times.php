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
// | Date: 2020/7/01 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------

    namespace Jrk;


    class Times
    {
        /**
         * @param $begin_time
         * @param $end_time
         * @return array
         * @author: hhygyl
         * @describe:计算两个时间戳之间相差的日时分秒
         */
        public static function timediff($begin_time,$end_time)
        {
            if($begin_time < $end_time){
                $starttime = $begin_time;
                $endtime = $end_time;
            }else{
                $starttime = $end_time;
                $endtime = $begin_time;
            }

            //计算天数
            $timediff = $endtime-$starttime;
            $days = intval($timediff/86400);
            //计算小时数
            $remain = $timediff%86400;
            $hours = intval($remain/3600);
            //计算分钟数
            $remain = $remain%3600;
            $mins = intval($remain/60);
            //计算秒数
            $secs = $remain%60;
            $res = array("day" => $days,"hour" => $hours,"min" => $mins,"sec" => $secs);
            return $res;
        }


        /**
         * @param array $data
         * @return bool
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:判断多个时间是否冲突
         */
        public static function timeCross(array $data)
        {
            $dfiled = array_column($data, 'start_time');
            // 按开始时间排序
            array_multisort($dfiled, SORT_ASC, $data);
            // 冒泡判断是否满足时间段重合的条件
            $num = count($data);
            for ($i = 1; $i < $num; $i++) {
                $pre = $data[$i - 1];
                $current = $data[$i];
                if (strtotime($pre['start_time']) < strtotime($current['over_time']) && strtotime($current['start_time']) < strtotime($pre['over_time'])) {
                    return true;
                }
            }
            return false;
        }

        /**
         * @param $date_time
         * @param int $type
         * @param bool $format
         * @return false|string
         * @author: hhygyl <hhygyl520@qq.com>
         * @describe:友好的时间显示
         */
        public static function friendlyDate($sTime, $type = 'normal', $alt = 'false'){
            if (!$sTime) {
                return '';
            }
            //sTime=源时间，cTime=当前时间，dTime=时间差
            $cTime = time();
            $dTime = $cTime - $sTime;
            $dDay  = intval(date("z", $cTime)) - intval(date("z", $sTime));
            //$dDay     =   intval($dTime/3600/24);
            $dYear = intval(date("Y", $cTime)) - intval(date("Y", $sTime));
            //normal：n秒前，n分钟前，n小时前，日期
            if ($type == 'normal') {
                if ($dTime < 60) {
                    if ($dTime < 10) {
                        return '刚刚'; //by yangjs
                    } else {
                        return intval(floor($dTime / 10) * 10) . "秒前";
                    }
                } elseif ($dTime < 3600) {
                    return intval($dTime / 60) . "分钟前";
                    //今天的数据.年份相同.日期相同.
                } elseif ($dYear == 0 && $dDay == 0) {
                    //return intval($dTime/3600)."小时前";
                    return '今天' . date('H:i', $sTime);
                } elseif ($dYear == 0) {
                    return date("m月d日 H:i", $sTime);
                } else {
                    return date("Y-m-d", $sTime);
                }
            } elseif ($type == 'mohu') {
                if ($dTime < 60) {
                    return $dTime . "秒前";
                } elseif ($dTime < 3600) {
                    return intval($dTime / 60) . "分钟前";
                } elseif ($dTime >= 3600 && $dDay == 0) {
                    return intval($dTime / 3600) . "小时前";
                } elseif ($dDay > 0 && $dDay <= 7) {
                    return intval($dDay) . "天前";
                } elseif ($dDay > 7 && $dDay <= 30) {
                    return intval($dDay / 7) . '周前';
                } elseif ($dDay > 30) {
                    return intval($dDay / 30) . '个月前';
                }
                //full: Y-m-d , H:i:s
            } elseif ($type == 'full') {
                return date("Y-m-d H:i:s", $sTime);
            } elseif ($type == 'ymd') {
                return date("Y-m-d", $sTime);
            } else {
                if ($dTime < 60) {
                    return $dTime . "秒前";
                } elseif ($dTime < 3600) {
                    return intval($dTime / 60) . "分钟前";
                } elseif ($dTime >= 3600 && $dDay == 0) {
                    return intval($dTime / 3600) . "小时前";
                } elseif ($dYear == 0) {
                    return date("Y-m-d H:i:s", $sTime);
                } else {
                    return date("Y-m-d H:i:s", $sTime);
                }
            }
        }



        /**
         * @param StringService $timestamp
         * @return bool
         * @author: hhygyl
         * @describe:判断是否是时间戳
         */
        public static function is_timestamp($timestamp ='')
        {
            if (!$timestamp) return false;
            return $is_unixtime = ctype_digit($timestamp) && $timestamp <= 2147483647;
        }



        /**
         * @param null $time
         * @param StringService $format
         * @return false|StringService
         * @author: hhygyl <hhygyl520@qq.com>
         * @describe:时间戳格式化ibe:
         */
        public static function time_format($time = NULL, $format = 'Y-m-d H:i') {
            $time = $time === NULL ? time() : intval($time);
            return date($format, $time);
        }



        /**
         * @param int $time
         * @return bool|StringService
         * @author: hhygyl <hhygyl520@qq.com>
         * @describe:转换剩余时间格式
         */
        public static function get_surplus_time($time = 0){
            if (!$time) {
                return false;
            }
            if ($time < 0) {
                return '已结束';
            } else {
                if ($time < 60) {
                    return $time . '秒';
                } else {
                    if ($time < 3600) {
                        return floor($time / 60) . '分钟';
                    } else {
                        if ($time < 86400) {
                            return floor($time / 3600) . '小时';
                        } else {
                            if ($time < 259200) {//3天内
                                return floor($time / 86400) . '天';
                            } else {
                                return floor($time / 86400) . '天';
                            }
                        }
                    }
                }
            }
        }

        /**
         * @param $str_time
         * @param StringService $format
         * @return bool
         * @author: hhygyl <hhygyl520@qq.com>
         * @describe:判断是否日期时间
         */
        public static function check_date_time($str_time, $format="Y-m-d H:i:s") {
            $unix_time = strtotime($str_time);
            $check_date= date($format, $unix_time);
            if ($check_date == $str_time) {
                return true;
            } else {
                return false;
            }
        }

        /**
         * @param int $some
         * @param null $day
         * @return false|float|int|null
         * @author: hhygyl <hhygyl520@qq.com>
         * @describe:获取n天前0点的时间戳
         */
        public static function get_some_day($some = 30, $day = null)
        {
            $time = $day ? $day : time();
            $some_day = $time - 60 * 60 * 24 * $some;
            $btime = date('Y-m-d' . ' 00:00:00', $some_day);
            $some_day = strtotime($btime);
            return $some_day;
        }


        /**
         * @param string $type
         * @param bool $date
         * @param string $format
         * @return array
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:获取开始和结束时间
         */
        public static function TimeBeginEnd($type = "today", $date = true, $format = "Y-m-d H:i:s") {
            switch (strtolower($type)) {
                case "tomorrow":  //明天的开始和结束时间
                    $arr = [self::BeginTomorrow($date, $format), self::EndTomorrow($date, $format)];
                    break;
                case "yesterday": //昨天的开始和结束时间
                    $arr = [self::BeginYesterday($date, $format), self::EndYesterday($date, $format)];
                    break;
                case "thisweek":  //本周的开始和结束时间 【开始时间周一，结束时间为周日】
                    $arr = [self::BeginThisWeek($date, $format), self::EndThisWeek($date, $format)];
                    break;
                case "thisweekr":  //本周的开始和结束时间【开始时间周日，结束时间为周六】
                    $arr = [self::BeginThisWeekR($date, $format), self::EndThisWeekR($date, $format)];
                    break;
                case "lastweek":  //上周的开始和结束时间
                    $arr = [self::BeginLastWeek($date, $format), self::EndLastWeek($date, $format)];
                    break;
                case "thismonth":  //本月的开始和结束时间
                    $arr = [self::BeginThisMonth($date, $format), self::EndThisMonth($date, $format)];
                    break;
                case "lastmonth":  //上月的开始和结束时间
                    $arr = [self::BeginLastMonth($date, $format), self::EndLastMonth($date, $format)];
                    break;
                case "thisseason": //本季度的开始和结束时间
                    $arr = [self::BeginThisSeason($date, $format), self::EndThisSeason($date, $format)];
                    break;
                case "lastseason":  //上季度的开始和结束时间
                    $arr = [self::BeginLastSeason($date, $format), self::EndLastSeason($date, $format)];
                    break;
                case "thisyear":  //今年的开始和结束时间
                    $arr = [self::BeginThisYear($date, $format), self::EndThisYear($date, $format)];
                    break;
                case "tomorrowyear": //明年的开始和结束时间
                    $arr = [self::BeginTomorrowYear($date, $format), self::EndTomorrowYear($date, $format)];
                    break;
                case "lastyear": //去年的开始和结束时间
                    $arr = [self::BeginLastYear($date, $format), self::EndLastYear($date, $format)];
                    break;
                default:   //今天的开始和结束时间
                    $arr = [self::BeginToday($date, $format), self::EndToday($date, $format)];
                    break;
            }
            return $arr;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:今日开始时间
         */
        public static function BeginToday($date = true, $format = "Y-m-d H:i:s") {
            $today = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
            return $date ? date($format, $today) : $today;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:今日结束时间
         */
        public static function EndToday($date = true, $format = "Y-m-d H:i:s") {
            $today = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) - 1;
            return $date ? date($format, $today) : $today;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:明日开始时间
         */
        public static function BeginTomorrow($date = true, $format = "Y-m-d H:i:s") {
            $Tomorrow = mktime(0, 0, 0, date('m'), date('d'), date('Y')) + 86400;
            return $date ? date($format, $Tomorrow) : $Tomorrow;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:明日结束时间
         */
        public static function EndTomorrow($date = true, $format = "Y-m-d H:i:s") {
            $Tomorrow = mktime(0, 0, 0, date('m'), date('d') + 1, date('Y')) + 86399;
            return $date ? date($format, $Tomorrow) : $Tomorrow;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:昨日开始时间
         */
        public static function BeginYesterday($date = true, $format = "Y-m-d H:i:s") {
            $Yesterday = mktime(0, 0, 0, date('m'), date('d') - 1, date('Y'));
            return $date ? date($format, $Yesterday) : $Yesterday;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:昨日结束时间
         */
        public static function EndYesterday($date = true, $format = "Y-m-d H:i:s") {
            $Yesterday = mktime(0, 0, 0, date('m'), date('d'), date('Y')) - 1;
            return $date ? date($format, $Yesterday) : $Yesterday;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本周开始时间 【开始时间周一，结束时间为周日】
         */
        public static function BeginThisWeek($date = true, $format = "Y-m-d H:i:s") {
            $ThisWeek = strtotime("this week Monday", time());
            return $date ? date($format, $ThisWeek) : $ThisWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本周结束时间 【开始时间周一，结束时间为周日】
         */
        public static function EndThisWeek($date = true, $format = "Y-m-d H:i:s") {
            $ThisWeek = strtotime("this week Sunday", time()) + 86399;
            return $date ? date($format, $ThisWeek) : $ThisWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本周开始时间 【开始时间周日，结束时间为周六】
         */
        public static function BeginThisWeekR($date = true, $format = "Y-m-d H:i:s") {
            $ThisWeek = mktime(0, 0, 0, date("m"), date("d") - date("w") + 1, date("Y"));
            return $date ? date($format, $ThisWeek) : $ThisWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本周结束时间 【开始时间周日，结束时间为周六】
         */
        public static function EndThisWeekR($date = true, $format = "Y-m-d H:i:s") {
            $ThisWeek = mktime(0, 0, 0, date("m"), date("d") - date("w") + 7, date("Y"));
            return $date ? date($format, $ThisWeek) : $ThisWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上周开始时间
         */
        public static function BeginLastWeek($date = true, $format = "Y-m-d H:i:s") {
            $LastWeek = strtotime("last week Monday", time());
            return $date ? date($format, $LastWeek) : $LastWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上周结束时间
         */
        public static function EndLastWeek($date = true, $format = "Y-m-d H:i:s") {
            $LastWeek = strtotime("last week Sunday", time()) + 86399;
            return $date ? date($format, $LastWeek) : $LastWeek;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:这月开始时间
         */
        public static function BeginThisMonth($date = true, $format = "Y-m-d H:i:s") {
            $ThisMonth = mktime(0, 0, 0, date('m'), 1, date('Y'));
            return $date ? date($format, $ThisMonth) : $ThisMonth;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:这月结束时间
         */
        public static function EndThisMonth($date = true, $format = "Y-m-d H:i:s") {
            $ThisMonth = mktime(23, 59, 59, date('m'), date('t'), date('Y'));
            return $date ? date($format, $ThisMonth) : $ThisMonth;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上月开始时间
         */
        public static function BeginLastMonth($date = true, $format = "Y-m-d H:i:s") {
            $LastMonth = mktime(0, 0, 0, date("m") - 1, 1, date("Y"));
            return $date ? date($format, $LastMonth) : $LastMonth;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上月结束时间
         */
        public static function EndLastMonth($date = true, $format = "Y-m-d H:i:s") {
            $LastMonth = mktime(23, 59, 59, date("m"), 0, date("Y"));
            return $date ? date($format, $LastMonth) : $LastMonth;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本季度开始时间
         */
        public static function BeginThisSeason($date = true, $format = "Y-m-d H:i:s") {
            $season = ceil((date('n')) / 3);
            $ThisSeason = mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
            return $date ? date($format, $ThisSeason) : $ThisSeason;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:本季度结束时间
         */
        public static function EndThisSeason($date = true, $format = "Y-m-d H:i:s") {
            $season = ceil((date('n')) / 3);
            $ThisSeason = mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
            return $date ? date($format, $ThisSeason) : $ThisSeason;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上季度开始时间
         */
        public static function BeginLastSeason($date = true, $format = "Y-m-d H:i:s") {
            $season = ceil((date('n')) / 3) - 1;
            $ThisSeason = mktime(0, 0, 0, $season * 3 - 3 + 1, 1, date('Y'));
            return $date ? date($format, $ThisSeason) : $ThisSeason;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:上季度结束时间
         */
        public static function EndLastSeason($date = true, $format = "Y-m-d H:i:s") {
            $season = ceil((date('n')) / 3) - 1;
            $ThisSeason = mktime(23, 59, 59, $season * 3, date('t', mktime(0, 0, 0, $season * 3, 1, date("Y"))), date('Y'));
            return $date ? date($format, $ThisSeason) : $ThisSeason;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:今年开始时间
         */
        public static function BeginThisYear($date = true, $format = "Y-m-d H:i:s") {
            $ThisYear = mktime(0, 0, 0, 1, 1, date('Y'));
            return $date ? date($format, $ThisYear) : $ThisYear;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:今年结束时间
         */
        public static function EndThisYear($date = true, $format = "Y-m-d H:i:s") {
            $ThisYear = mktime(23, 59, 59, 12, 31, date('Y'));
            return $date ? date($format, $ThisYear) : $ThisYear;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:明年开始时间
         */
        public static function BeginTomorrowYear($date = true, $format = "Y-m-d H:i:s") {
            $TomorrowYear = mktime(0, 0, 0, 1, 1, date('Y') + 1);
            return $date ? date($format, $TomorrowYear) : $TomorrowYear;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:明年结束时间
         */
        public static function EndTomorrowYear($date = true, $format = "Y-m-d H:i:s") {
            $TomorrowYear = mktime(23, 59, 59, 12, 31, date('Y') + 1);
            return $date ? date($format, $TomorrowYear) : $TomorrowYear;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:去年开始时间
         */
        public static function BeginLastYear($date = true, $format = "Y-m-d H:i:s") {
            $LastYear = mktime(0, 0, 0, 1, 1, date('Y') - 1);
            return $date ? date($format, $LastYear) : $LastYear;
        }


        /**
         * @param bool $date
         * @param string $format
         * @return false|int|string
         * @author: Hhy <jackhhy520@qq.com>
         * @describe:去年结束时间
         */
        public static function EndLastYear($date = true, $format = "Y-m-d H:i:s") {
            $LastYear = mktime(23, 59, 59, 12, 31, date('Y') - 1);
            return $date ? date($format, $LastYear) : $LastYear;
        }

        /**
         * @param int $num
         * @return datetime
         * @describe:将EXCEL中的数字，转换成日期
         */
        public static function excelNumToDate($num)
        {
            $date = '';
            if ($num == (int) $num) {
        
                $time = ($num - 25569) * 24 * 60 * 60;
                return date('Y-m-d', $time);
            }
            return $date;
        }
        

    }