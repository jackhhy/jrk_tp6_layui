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

namespace Jrk;


class Tree
{
    private static $formatTree;//用于树型数组完成递归格式的全局变量

    /**
     * @param $arr
     * @param int $root
     * @return array
     * @author: hhygyl
     * @name: DeepTree
     * @describe:格式化数据
     */
    public static function DeepTree($arr, $child = "children", $root = 0)
    {
        if (empty($arr)) return [];
        $OriginalList = $arr;
        $tree = [];//最终数组
        $refer = [];//存储主键与数组单元的引用关系
        //遍历
        foreach ($OriginalList as $k => $v) {
            if (!isset($v['id']) || !isset($v['pid']) || isset($v[$child])) {
                unset($OriginalList[$k]);
                continue;
            }
            $refer[$v['id']] =& $OriginalList[$k];//为每个数组成员建立引用关系
        }
        //遍历2
        foreach ($OriginalList as $k => $v) {
            if ($v['pid'] == $root) {//根分类直接添加引用到tree中
                $tree[] =& $OriginalList[$k];
            } else {
                if (isset($refer[$v['pid']])) {
                    $parent =& $refer[$v['pid']];//获取父分类的引用
                    $parent[$child][] =& $OriginalList[$k];//在父分类的children中再添加一个引用成员
                }
            }
        }
        return $tree;
    }


    /**
     * @param $menu
     * @param int $id
     * @param int $level
     * @return array
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: menulist
     * @describe:菜单格式化
     */
    public static function menulist($menu, $id = 0, $level = 0)
    {
        static $menus = array();
        $size = count($menus) - 1;
        foreach ($menu as $value) {
            if ($value['pid'] == $id) {
                $value['level'] = $level + 1;
                if ($level == 0) {
                    $value['str'] = str_repeat('', $value['level']);
                    $menus[] = $value;
                } elseif ($level == 2) {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;' . '└ ';
                    $menus[$size]['list'][] = $value;
                } elseif ($level == 3) {
                    $value['str'] = '&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;' . '└ ';
                    $menus[$size]['list'][] = $value;
                } else {
                    $value['str'] = '&emsp;&emsp;' . '└ ';
                    $menus[$size]['list'][] = $value;
                }
                self::menulist($menu, $value['id'], $value['level']);
            }
        }
        return $menus;
    }


    /**
     * @param $data
     * @param int $pid
     * @param StringService $field
     * @param StringService $pk
     * @param StringService $html
     * @param int $level
     * @param bool $clear
     * @return array
     * @author: hhygyl
     * @name: sortListTier
     * @describe: 选择树形结构
     */
    public static function sortListTier($data, $pid = 0, $field = 'pid', $pk = 'id', $html = '|----', $level = 0, $clear = true)
    {
        static $list = [];
        if ($clear) $list = [];
        foreach ($data as $k => $res) {
            if ($res[$field] == $pid) {
                $res['html'] = str_repeat($html, $level) . $res['title'];
                $res['level'] = $level;
                $list[] = $res;
                unset($data[$k]);
                self::sortListTier($data, $res[$pk], $field, $pk, $html, $level + 1, false);
            }
        }
        return $list;
    }


    /**
     * @param $list
     * @param StringService $pk
     * @param StringService $pid
     * @param StringService $child
     * @param int $root
     * @return array
     * @author: hhygyl
     * @name: listToTree
     * @describe:把返回的数据集转换成Tree
     */
    public static function listToTree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
    {
        // 创建Tree
        $tree = [];
        if (is_array($list)) {
            // 创建基于主键的数组引用
            $refer = array();
            foreach ($list as $key => $data) {
                $refer[$data[$pk]] =& $list[$key];
            }
            foreach ($list as $key => $data) {
                // 判断是否存在parent
                $parentId = $data[$pid];
                if ($root == $parentId) {
                    $tree[] =& $list[$key];
                } else {
                    if (isset($refer[$parentId])) {
                        $parent =& $refer[$parentId];
                        $parent['childs'][] = $data[$pk];
                        $parent[$child][] =& $list[$key];
                    }
                }
            }
        }

        return $tree;
    }

    /**
     * 将树子节点加层级成列表
     */
    protected static function _toFormatTree($tree, $level = 1)
    {
        foreach ($tree as $key => $value) {
            $temp = $value;
            if (isset($temp['_child'])) {
                $temp['_child'] = true;
                $temp['level'] = $level;
            } else {
                $temp['_child'] = false;
                $temp['level'] = $level;
            }
            array_push(self::$formatTree, $temp);
            if (isset($value['_child'])) {
                self::_toFormatTree($value['_child'], ($level + 1));
            }
        }
    }


    /**
     * @param $cat
     * @param $next_parentid
     * @param StringService $pid
     * @param StringService $empty
     * @return StringService
     * @author: hhygyl
     * @name: catEmptyDeal
     * @describe:
     */
    public static function catEmptyDeal($cat, $next_parentid, $pid = 'pid', $empty = " ")
    {
        $str = "";
        if ($cat[$pid]) {
            for ($i = 2; $i < $cat['level']; $i++) {
                $str .= $empty . "│";
            }
            if ($cat[$pid] != $next_parentid && !$cat['_child']) {
                $str .= $empty . "└─ ";
            } else {
                $str .= $empty . "├─ ";
            }
        }
        return $str;
    }

    /**
     * @param $list
     * @param StringService $title
     * @param StringService $pk
     * @param StringService $pid
     * @param int $root
     * @return array|bool
     * @author: hhygyl
     * @name: toFormatTree
     * @describe:转换成树
     */
    public static function toFormatTree($list, $title = 'title', $pk = 'id', $pid = 'pid', $root = 0)
    {
        if (empty($list)) {
            return false;
        }
        $list = self::listToTree($list, $pk, $pid, '_child', $root);
        //dump($list);
        self::$formatTree = $data = [];
        self::_toFormatTree($list);
        foreach (self::$formatTree as $key => $value) {
            $index = ($key + 1);
            $next_parentid = isset(self::$formatTree[$index][$pid]) ? self::$formatTree[$index][$pid] : '';
            $value['level_show'] = self::catEmptyDeal($value, $next_parentid);
            $value['title_show'] = $value['level_show'] . $value[$title];
            $data[] = $value;
        }
        return $data;
    }


    /**
     * @param $data
     * @param int $pid
     * @param StringService $field
     * @param StringService $pk
     * @param int $level
     * @return array
     * @author: hhygyl
     * @name: getChindNode
     * @describe:分级返回多维数组
     */
    public static function getChindNode($data, $pid = 0, $field = 'pid', $pk = 'id', $level = 1)
    {

        static $list = [];
        foreach ($data as $k => $res) {
            if ($res['pid'] == $pid) {
                $list[] = $res;
                unset($data[$k]);
                self::getChindNode($data, $res['id'], $field, $pk, $level + 1);
            }
        }
        return $list;


    }


    /**
     * @param $data
     * @param $pid
     * @param string $field
     * @param string $pk
     * @return array
     * @author: hhygyl <hhygyl520@qq.com>
     * @name: getChildrenPid
     * @describe:分级返回下级所有分类ID
     */
    public static function getChildrenPid($data, $pid, $field = 'pid', $pk = 'id')
    {
        static $pids = [];
        foreach ($data as $k => $res) {
            if ($res[$field] == $pid) {
                $pids[] = $res[$pk];
                self::getChildrenPid($data, $res[$pk], $field, $pk);
            }
        }
        return $pids;
    }


    /**
     * @param $list
     * @param string $id
     * @param string $pid
     * @param string $son
     * @return array|mixed
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: arr2tree
     * @describe:一维数据数组生成数据树
     */
    public static function arr2tree($list, $id = 'id', $pid = 'pid', $son = 'sub')
    {
        list($tree, $map) = [[], []];
        foreach ($list as $item) $map[$item[$id]] = $item;
        foreach ($list as $item) if (isset($item[$pid]) && isset($map[$item[$pid]])) {
            $map[$item[$pid]][$son][] = &$map[$item[$id]];
        } else $tree[] = &$map[$item[$id]];
        unset($map);
        return $tree;
    }


    /**
     * 一维数据数组生成数据树
     * @param array $list 数据列表
     * @param string $id ID Key
     * @param string $pid 父ID Key
     * @param string $path
     * @param string $ppath
     * @return array
     * @author: LuckyHhy <jackhhy520@qq.com>
     * @name: arr2tree
     * @describe:一维数据数组生成数据树
     */
    public static function arr2table(array $list, $id = 'id', $pid = 'pid', $path = 'path', $ppath = '')
    {
        $tree = [];
        foreach (self::arr2tree($list, $id, $pid) as $attr) {
            $attr[$path] = "{$ppath}-{$attr[$id]}";
            $attr['sub'] = isset($attr['sub']) ? $attr['sub'] : [];
            $attr['spt'] = substr_count($ppath, '-');
            $attr['spl'] = str_repeat("　├　", $attr['spt']);
            $sub = $attr['sub'];
            unset($attr['sub']);
            $tree[] = $attr;
            if (!empty($sub)) $tree = array_merge($tree, self::arr2table($sub, $id, $pid, $path, $attr[$path]));
        }
        return $tree;
    }


}