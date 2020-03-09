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
 *  作用：将xml转为array.
 */
function xmlToArray($xml)
{
    return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
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
 * 反字符 去标签 自动加点 去换行 截取字符串.
 */
function cutstr($data, $no, $le = '')
{
    $data = strip_tags(htmlspecialchars_decode($data));
    $data = str_replace(["\r\n", "\n\n", "\r\r", "\n", "\r"], '', $data);
    $str = msubstr($data, 0, $no);
    if (strlen($data) > strlen($str)) {
        $str .= $le;
    }

    return $str;
}

/**
 * 将一个字符串转换成数组，支持中文.
 * @param  string  $string  待转换成数组的字符串
 * @return array   转换后的数组
 */
function strToArray($string)
{
    $array = [];
    $strLen = mb_strlen($string);
    while ($strLen) {
        $array[] = mb_substr($string, 0, 1, 'utf8');
        $string = mb_substr($string, 1, $strLen, 'utf8');
        $strLen = mb_strlen($string);
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
function list_sort_by(array $list, $field, $sortby = 'asc')
{
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

/**
 * 将list_to_tree的树还原成列表.
 * @param  array  $tree  原来的树
 * @param  string  $child  孩子节点的键
 * @param  string  $order  排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list(array $tree, $child = '_child', $order = 'id', &$list = [])
{
    foreach ($tree as $key => $value) {
        $refer = $value;
        if (isset($refer[$child])) {
            unset($refer[$child]);
            tree_to_list($value[$child], $child, $order, $list);
        }
        $list[] = $refer;
    }
    $list = list_sort_by($list, $order, $sortby = 'asc');

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
