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


    class Zipdown
    {

        protected $datasec = array ();
        protected $ctrl_dir = array ();
        protected $eof_ctrl_dir = "\x50\x4b\x05\x06\x00\x00\x00\x00";
        protected $old_offset = 0;

        ///下面是Zip压缩方法
        protected function unix2_dostime($unixtime = 0){
            $timearray = ($unixtime == 0) ? getdate () : getdate($unixtime);
            if ($timearray ['year'] < 1980){
                $timearray ['year'] = 1980;
                $timearray ['mon'] = 1;
                $timearray ['mday'] = 1;
                $timearray ['hours'] = 0;
                $timearray ['minutes'] = 0;
                $timearray ['seconds'] = 0;
            }
            return (($timearray ['year'] - 1980) << 25) | ($timearray ['mon'] << 21) | ($timearray ['mday'] << 16) | ($timearray ['hours'] << 11) | ($timearray ['minutes'] << 5) | ($timearray ['seconds'] >> 1);
        }


        /**
         * @param $data
         * @param $name
         * @param int $time
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/1/13
         * @name: add_file
         * @describe:压缩
         */
        public function add_file($data, $name, $time = 0){
            $name = str_replace('\\', '/', $name);

            $dtime = dechex($this->unix2_dostime($time));
            $hexdtime = '\x' . $dtime [6] . $dtime [7] . '\x' . $dtime [4] . $dtime [5] . '\x' . $dtime [2] . $dtime [3] . '\x' . $dtime [0] . $dtime [1];
            eval('$hexdtime = "' . $hexdtime . '";');

            $fr = "\x50\x4b\x03\x04";
            $fr .= "\x14\x00";
            $fr .= "\x00\x00";
            $fr .= "\x08\x00";
            $fr .= $hexdtime;

            $unc_len = strlen($data);
            $crc = crc32($data);
            $zdata = gzcompress($data);
            $zdata = substr(substr($zdata, 0, strlen($zdata)- 4), 2);
            $c_len = strlen($zdata);
            $fr .= pack('V', $crc);
            $fr .= pack('V', $c_len);
            $fr .= pack('V', $unc_len);
            $fr .= pack('v', strlen($name));
            $fr .= pack('v', 0);
            $fr .= $name;

            $fr .= $zdata;
            $fr .= pack('V', $crc);
            $fr .= pack('V', $c_len);
            $fr .= pack('V', $unc_len);

            $this->datasec [] = $fr;

            $cdrec = "\x50\x4b\x01\x02";
            $cdrec .= "\x00\x00";
            $cdrec .= "\x14\x00";
            $cdrec .= "\x00\x00";
            $cdrec .= "\x08\x00";
            $cdrec .= $hexdtime;
            $cdrec .= pack('V', $crc);
            $cdrec .= pack('V', $c_len);
            $cdrec .= pack('V', $unc_len);
            $cdrec .= pack('v', strlen($name));
            $cdrec .= pack('v', 0);
            $cdrec .= pack('v', 0);
            $cdrec .= pack('v', 0);
            $cdrec .= pack('v', 0);
            $cdrec .= pack('V', 32);

            $cdrec .= pack('V', $this->old_offset);
            $this->old_offset += strlen($fr);

            $cdrec .= $name;

            $this->ctrl_dir[] = $cdrec;
        }



        /**
         * @param $path
         * @param int $l
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/1/13
         * @name: add_path
         * @describe:
         */
        public function add_path($path, $l = 0){
            $d = @opendir($path);
            $l = $l > 0 ? $l : strlen($path) + 1;
            while($v = @readdir($d)){
                if($v == '.' || $v == '..'){
                    continue;
                }
                $v = $path . '/' . $v;
                if(is_dir($v)){
                    $this->add_path($v, $l);
                } else {
                    $this->add_file(file_get_contents($v), substr($v, $l));
                }
            }
        }


        /**
         * @return string
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/1/13
         * @name: file
         * @describe:
         */
        public function file(){
            $data = implode('', $this->datasec);
            $ctrldir = implode('', $this->ctrl_dir);
            return $data . $ctrldir . $this->eof_ctrl_dir . pack('v', sizeof($this->ctrl_dir)) . pack('v', sizeof($this->ctrl_dir)) . pack('V', strlen($ctrldir)) . pack('V', strlen($data)) . "\x00\x00";
        }

        /**
         * @param $files
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/1/13
         * @name: add_files
         * @describe:添加文件
         */
        public  function add_files($files){
            foreach($files as $file){
                if (is_file($file)){
                    $data = implode("", file($file));
                    $this->add_file($data, $file);
                }
            }
        }


        /**
         * @param $file
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/1/13
         * @name: output
         * @describe:
         */
        public  function output($file){
            $fp = fopen($file, "w");
            fwrite($fp, $this->file ());
            fclose($fp);
        }



    }