<?php

function status($status)
{
    $color = null;
    switch ($status) {
        case '新':
            $color = ' new';
            break;
        case '热':
            $color = ' hot';
            break;
        case '沸':
            $color = ' boil';
            break;
        default:
            $color = null;
    }

    return $color;
}

/**
 * 格式化字节大小.
 * @param  int  $size  字节数
 * @param  int  $base  MiB 或 MB，即 1024 或 1000
 * @param  string  $delimiter  数字和单位分隔符
 * @return string 格式化后的带单位的大小
 */
function bytesForHuman(int $size, int $base = 1024, string $delimiter = ''): string
{
    $units = ['B', 'KB', 'MB', 'GB', 'TB', 'PB'];
    for ($i = 0; $size >= $base && $i < 5; $i++) {
        $size /= $base;
    }

    return round($size, 2).$delimiter.$units[$i];
}

/**
 * 微博热度.
 * @param  int  $size  热度
 * @return string 格式化后的带单位的大小
 */
function weiboHotForHuman(int $size): string
{
    $units = ['', 'K', 'M', 'G'];
    for ($i = 0; $size >= 1000 && $i < 5; $i++) {
        $size /= 1000;
    }

    return round($size).$units[$i];
}

function topping($topping)
{
    if (count($topping) >= 2) {
        $diff = $topping[0]->created_at->diffInMinutes($topping[1]->created_at);
        if ($diff > 2) {
            $topping->pop();
        }
    }

    return $topping;
}

/**
 * 产生随机字符串.
 *
 * @param  int  $length  输出长度
 * @param  string  $chars  可选的 ，默认为 0123456789
 * @return   string     字符串
 */
function getRandom($length, $chars = '0123456789'): string
{
    $hash = '';
    $max = strlen($chars) - 1;
    for ($i = 0; $i < $length; $i++) {
        $hash .= $chars[mt_rand(0, $max)];
    }

    return $hash;
}

// 创建图片上传目录和缩略图目录
function my_mkdir($Folder)
{
    $d = '';
    if (! is_dir($Folder)) {
        $dir = explode('/', $Folder);
        foreach ($dir as $v) {
            if ($v) {
                $d .= $v.'/';
                if (! is_dir($d)) {
                    $state = mkdir($d);
                    if (! $state) {
                        die('在创建目录'.$d.'时出错！');
                    }
                }
            }
        }
    }
}

/**
 * 循环删除目录和文件函数.
 * @param  string  $dirName  路径
 * @param  bool  $bFlag  是否删除目录
 * @return void
 */
function del_dir_file($dirName, $bFlag = false)
{
    if ($handle = opendir("$dirName")) {
        while (false !== ($item = readdir($handle))) {
            if ($item != '.' && $item != '..') {
                if (is_dir("$dirName/$item")) {
                    del_dir_file("$dirName/$item", $bFlag);
                } else {
                    unlink("$dirName/$item");
                }
            }
        }
        closedir($handle);
        if ($bFlag) {
            rmdir($dirName);
        }
    }
}

/**
 * 删除目录及目录下所有文件或删除指定文件.
 * @param  string  $path  待删除目录路径
 * @param  bool  $delDir  是否删除目录，1或true删除目录，0或false则只删除文件保留目录（包含子目录）
 * @return bool 返回删除状态
 */
function del_dir_and_file($path, $delDir = false): bool
{
    $handle = opendir($path);
    if ($handle) {
        while (false !== ($item = readdir($handle))) {
            if ($item != '.' && $item != '..') {
                is_dir("$path/$item") ? del_dir_and_file("$path/$item", $delDir) : unlink("$path/$item");
            }
        }
        closedir($handle);
        if ($delDir) {
            return rmdir($path);
        }
    } else {
        if (file_exists($path)) {
            return unlink($path);
        } else {
            return false;
        }
    }

    return false;
}

/**
 *  作用：将xml转为array.
 */
function xmlToArray($xml)
{
    //将XML转为array
    $array_data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);

    return $array_data;
}

/**
 * 递归重组信息为多维.
 * @param  string  $dirName  路径
 * @param  bool  $fileFlag  是否删除目录
 * @return void
 */
function node_merge($attr, $arr)
{
    foreach ($attr as $v) {
        if (is_array($arr)) {
            $v['access'] = in_array($v['id'], $arr) ? 1 : 0;
        }
    }

    return $attr;
}

/**
 * 获取文件信息.
 * @param  string  $filepath  路径
 * @param  string  $key  指定返回某个键值信息
 * @return array
 */
function get_file_info($filepath = '', $key = '')
{
    //打开文件，r表示以只读方式打开
    $handle = fopen($filepath, 'r');
    //获取文件的统计信息
    $fstat = fstat($handle);

    fclose($handle);
    $fstat['filename'] = basename($filepath);
    if (! empty($key)) {
        return $fstat[$key];
    } else {
        return $fstat;
    }
}

/**
 * 获取文件目录列表.
 * @param  string  $pathname  路径
 * @param  int  $fileFlag  文件列表 0所有文件列表,1只读文件夹,2是只读文件(不包含文件夹)
 * @param  string  $pathname  路径
 * @return array
 */
function get_file_folder_List($pathname, $fileFlag = 0, $pattern = '*')
{
    $fileArray = [];
    $pathname = rtrim($pathname, '/').'/';
    $list = glob($pathname.$pattern);
    foreach ($list as $i => $file) {
        switch ($fileFlag) {
            case 0:
                $fileArray[] = basename($file);
                break;
            case 1:
                if (is_dir($file)) {
                    $fileArray[] = basename($file);
                }
                break;

            case 2:
                if (is_file($file)) {
                    $fileArray[] = basename($file);
                }
                break;

            default:
                break;
        }
    }

    if (empty($fileArray)) {
        $fileArray = null;
    }

    return $fileArray;
}

/**
 * PHP 非递归实现查询该目录下所有文件.
 * @param  unknown  $dir
 * @return multitype:|multitype:string
 */
function scanfiles($dir)
{
    if (! is_dir($dir)) {
        return [];
    }

    // 兼容各操作系统
    $dir = rtrim(str_replace('\\', '/', $dir), '/').'/';

    // 栈，默认值为传入的目录
    $dirs = [$dir];

    // 放置所有文件的容器
    $rt = [];
    do {
        // 弹栈
        $dir = array_pop($dirs);
        // 扫描该目录
        $tmp = scandir($dir);
        foreach ($tmp as $f) {

            // 过滤. ..
            if ($f == '.' || $f == '..') {
                continue;
            }

            // 组合当前绝对路径
            $path = $dir.$f;

            // 如果是目录，压栈。
            if (is_dir($path)) {
                array_push($dirs, $path.'/');
            } else {
                if (is_file($path)) { // 如果是文件，放入容器中
                    $rt[] = $path;
                }
            }
        }
    } while ($dirs); // 直到栈中没有目录

    return $rt;
}

/**
 * 反字符 去标签 自动加点 去换行 截取字符串.
 */
function cutstr($data, $no, $le = '')
{
    $data = strip_tags(htmlspecialchars_decode($data));
    $data = str_replace(["\r\n", "\n\n", "\r\r", "\n", "\r"], '', $data);
    $datal = strlen($data);
    $str = msubstr($data, 0, $no);
    $datae = strlen($str);
    if ($datal > $datae) {
        $str .= $le;
    }

    return $str;
}

/**
 * 将一个字符串转换成数组，支持中文.
 * @param  string  $string  待转换成数组的字符串
 * @return string   转换后的数组
 */
function strToArray($string)
{
    $strlen = mb_strlen($string);
    while ($strlen) {
        $array[] = mb_substr($string, 0, 1, 'utf8');
        $string = mb_substr($string, 1, $strlen, 'utf8');
        $strlen = mb_strlen($string);
    }

    return $array;
}

function object_array($array)
{
    if (is_object($array)) {
        $array = (array) $array;
    }
    if (is_array($array)) {
        foreach ($array as $key => $value) {
            $array[$key] = object_array($value);
        }
    }

    return $array;
}

/**
 * 对查询结果集进行排序.
 * @param  array  $list  查询结果
 * @param  string  $field  排序的字段名
 * @param  array  $sortby  排序类型
 * asc正向排序 desc逆向排序 nat自然排序
 * @return array
 */
function list_sort_by($list, $field, $sortby = 'asc')
{
    if (is_array($list)) {
        $refer = $resultSet = [];
        foreach ($list as $i => $data) {
            $refer[$i] = &$data[$field];
        }
        switch ($sortby) {
            case 'asc': // 正向排序
                asort($refer);
                break;
            case 'desc':// 逆向排序
                arsort($refer);
                break;
            case 'nat': // 自然排序
                natcasesort($refer);
                break;
        }
        foreach ($refer as $key => $val) {
            $resultSet[] = &$list[$key];
        }

        return $resultSet;
    }

    return false;
}

/**
 * 把返回的数据集转换成Tree.
 * @param  array  $list  要转换的数据集
 * @param  string  $pid  parent标记字段
 * @param  string  $level  level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk = 'id', $pid = 'pid', $child = '_child', $root = 0)
{
    // 创建Tree
    $tree = [];

    if (is_array($list)) {

        // 创建基于主键的数组引用
        $refer = [];
        foreach ($list as $key => $val) {
            $refer[$val[$pk]] = &$list[$key];
        }

        foreach ($list as $key => $val) {
            // 判断是否存在parent
            $parentId = $val[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }
    }

    return $tree;
}

/**
 * 将list_to_tree的树还原成列表.
 * @param  array  $tree  原来的树
 * @param  string  $child  孩子节点的键
 * @param  string  $order  排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order = 'id', &$list = [])
{
    if (is_array($tree)) {
        $refer = [];
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if (isset($reffer[$child])) {
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby = 'asc');
    }

    return $list;
}

function assoc_unique(&$arr, $key)
{
    $rAr = [];
    for ($i = 0; $i < count($arr); $i++) {
        if (! isset($rAr[$arr[$i][$key]])) {
            $rAr[$arr[$i][$key]] = $arr[$i];
        }
    }

    return array_values($rAr);
}

function array_sort($arrays, $sort_key, $sort_order = SORT_ASC, $sort_type = SORT_NUMERIC)
{
    if (is_array($arrays)) {
        foreach ($arrays as $array) {
            if (is_array($array)) {
                $key_arrays[] = $array[$sort_key];
            } else {
                return false;
            }
        }
    } else {
        return false;
    }
    array_multisort($key_arrays, $sort_order, $sort_type, $arrays);

    return $arrays;
}

function array_sort2($arr, $key, $value)
{
    $temp = [];
    foreach ($arr as $k => $v) {
        if ($v[$key] == $value) {
            $temp[] = $arr[$k];
            unset($arr[$k]);
        }
    }
    foreach ($temp as $m => $n) {
        array_push($arr, $n);
    }

    return $arr;
}

/**
 * 获取二维数组中的一个键的值的数组.
 * @param $input
 * @param $columnKey
 * @param  null  $indexKey
 * @return array
 */
function arrayColumn($input, $columnKey, $indexKey = null)
{
    $columnKeyIsNumber = (is_numeric($columnKey)) ? true : false;
    $indexKeyIsNull = (is_null($indexKey)) ? true : false;
    $indexKeyIsNumber = (is_numeric($indexKey)) ? true : false;
    $result = [];
    foreach ((array) $input as $key => $row) {
        if ($columnKeyIsNumber) {
            $tmp = array_slice($row, $columnKey, 1);
            $tmp = (is_array($tmp) && ! empty($tmp)) ? current($tmp) : null;
        } else {
            $tmp = isset($row[$columnKey]) ? $row[$columnKey] : null;
        }
        if (! $indexKeyIsNull) {
            if ($indexKeyIsNumber) {
                $key = array_slice($row, $indexKey, 1);
                $key = (is_array($key) && ! empty($key)) ? current($key) : null;
                $key = is_null($key) ? 0 : $key;
            } else {
                $key = isset($row[$indexKey]) ? $row[$indexKey] : 0;
            }
        }
        $result[$key] = $tmp;
    }

    return $result;
}

function searchDir($path, &$files)
{
    if (is_dir($path)) {
        $opendir = opendir($path);

        while ($file = readdir($opendir)) {
            if ($file != '.' && $file != '..') {
                searchDir($path.'/'.$file, $files);
            }
        }
        closedir($opendir);
    }
    if (! is_dir($path)) {
        $files[] = $path;
    }
}

function getDir($dir)
{
    $files = [];
    searchDir($dir, $files);

    return $files;
}
