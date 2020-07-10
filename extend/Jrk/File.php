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
// | Date: 2020/7/1 0026
// +----------------------------------------------------------------------
// | Description:
// +----------------------------------------------------------------------
    namespace Jrk;

    class File
    {
        /**
         * @param $dir
         * @return bool
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: mk_dir
         * @describe:目录名
         */
        public static function mk_dir($dir)
        {
            $dir = rtrim($dir, '/') . '/';
            if (!is_dir($dir)) {
                if (mkdir($dir, 0700, true) == false) {
                    return false;
                }
                return true;
            }
            return true;
        }

        /**
         * @param $filename
         * @return bool|false|string
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: read_file
         * @describe:读取文件内容
         */
        public static function read_file($filename)
        {
            $content = '';
            if (function_exists('file_get_contents')) {
                @$content = file_get_contents($filename);
            } else {
                if (@$fp = fopen($filename, 'r')) {
                    @$content = fread($fp, filesize($filename));
                    @fclose($fp);
                }
            }
            return $content;
        }



        /**
         * @param $filename
         * @param $writetext
         * @param string $openmod
         * @return bool
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: write_file
         * @describe:写文件
         */
        public static function write_file($filename, $writetext, $openmod = 'w')
        {
            if (@$fp = fopen($filename, $openmod)) {
                flock($fp, 2);
                fwrite($fp, $writetext);
                fclose($fp);
                return true;
            } else {
                return false;
            }
        }

        /**
         * @param $dirName
         * @return bool
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: del_dir
         * @describe:删除目录
         */
        public static function del_dir($dirName)
        {
            if (!file_exists($dirName)) {
                return false;
            }
            $dir = opendir($dirName);
            while ($fileName = readdir($dir)) {
                $file = $dirName . '/' . $fileName;
                if ($fileName != '.' && $fileName != '..') {
                    if (is_dir($file)) {
                        self::del_dir($file);
                    } else {
                        unlink($file);
                    }
                }
            }
            closedir($dir);
            return rmdir($dirName);
        }

        /**
         * @param $surDir
         * @param $toDir
         * @return bool
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: copy_dir
         * @describe:复制目录
         */
        public static function copy_dir($surDir, $toDir)
        {
            $surDir = rtrim($surDir, '/') . '/';
            $toDir = rtrim($toDir, '/') . '/';
            if (!file_exists($surDir)) {
                return false;
            }

            if (!file_exists($toDir)) {
                self::mk_dir($toDir);
            }
            $file = opendir($surDir);
            while ($fileName = readdir($file)) {
                $file1 = $surDir . '/' . $fileName;
                $file2 = $toDir . '/' . $fileName;
                if ($fileName != '.' && $fileName != '..') {
                    if (is_dir($file1)) {
                        self::copy_dir($file1, $file2);
                    } else {
                        copy($file1, $file2);
                    }
                }
            }
            closedir($file);
            return true;
        }

        /**
         * @param $dir
         * @return array
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: get_dirs
         * @describe: 列出目录
         */
        public static function get_dirs($dir)
        {
            $dir = rtrim($dir, '/') . '/';
            $dirArray[][] = null;
            if (false != ($handle = opendir($dir))) {
                $i = 0;
                $j = 0;
                while (false !== ($file = readdir($handle))) {
                    if (is_dir($dir . $file)) {
                        //判断是否文件夹
                        $dirArray['dir'][$i] = $file;
                        $i++;
                    } else {
                        $dirArray['file'][$j] = $file;
                        $j++;
                    }
                }
                closedir($handle);
            }
            return $dirArray;
        }

        /**
         * @param $dir
         * @return false|int
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: get_size
         * @describe:统计文件夹大小
         */
        public static function get_size($dir)
        {
            $dirlist = opendir($dir);
            $dirsize = 0;
            while (false !== ($folderorfile = readdir($dirlist))) {
                if ($folderorfile != "." && $folderorfile != "..") {
                    if (is_dir("$dir/$folderorfile")) {
                        $dirsize += self::get_size("$dir/$folderorfile");
                    } else {
                        $dirsize += filesize("$dir/$folderorfile");
                    }
                }
            }
            closedir($dirlist);
            return $dirsize;
        }

        /**
         * @param $dir
         * @return bool
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: empty_dir
         * @describe:检测是否为空文件夹
         */
        public static function empty_dir($dir)
        {
            return (($files = @scandir($dir)) && count($files) <= 2);
        }

        /**
         * @param $name
         * @param string $value
         * @param $path
         * @param bool $cached
         * @return array|bool|int|mixed|string
         * @author: LuckyHhy <jackhhy520@qq.com>
         * @date: 2020/3/18
         * @name: cache
         * @describe:文件缓存与文件读取
         */
        public function cache($name, $value = '', $path = RUNTIME_PATH, $cached = true)
        {
            static $_cache = array();
            $filename = $path . $name . '.php';
            if ('' !== $value) {
                if (is_null($value)) {
                    // 删除缓存
                    return false !== strpos($name, '*') ? array_map("unlink", glob($filename)) : unlink($filename);
                } else {
                    // 缓存数据
                    $dir = dirname($filename);
                    // 目录不存在则创建
                    if (!is_dir($dir)) {
                        mkdir($dir, 0755, true);
                    }

                    $_cache[$name] = $value;
                    return file_put_contents($filename, strip_whitespace("<?php\treturn " . var_export($value, true) . ";?>"));
                }
            }
            if (isset($_cache[$name]) && $cached == true) {
                return $_cache[$name];
            }

            // 获取缓存数据
            if (is_file($filename)) {
                $value = include $filename;
                $_cache[$name] = $value;
            } else {
                $value = false;
            }
            return $value;
        }


        /**
         * 读取文件夹下的所有文件
         * @param $path
         * @param $basePath
         * @return array|mixed
         */
        public static function readDirAllFiles($path, $basePath = '')
        {
            list($list, $temp_list) = [[], scandir($path)];
            empty($basePath) && $basePath = $path;
            foreach ($temp_list as $file) {
                if ($file != ".." && $file != ".") {
                    if (is_dir($path . DIRECTORY_SEPARATOR . $file)) {
                        $childFiles = self::readDirAllFiles($path . DIRECTORY_SEPARATOR . $file, $basePath);
                        $list = array_merge($childFiles, $list);
                    } else {
                        $filePath = $path . DIRECTORY_SEPARATOR . $file;
                        $fileName = str_replace($basePath . DIRECTORY_SEPARATOR, '', $filePath);
                        $list[$fileName] = $filePath;
                    }
                }
            }
            return $list;
        }

    }