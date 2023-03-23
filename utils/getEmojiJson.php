<?php

function listFiles($dir)
{
    $files = glob($dir.'/*', GLOB_NOSORT);
    $whitelist = array('png', 'mp4', 'jpeg', 'jpg', 'gif'); // 如果需要只列出某些特定类型的文件

    $files = preg_grep('/\.('.implode('|', $whitelist).')$/i', $files);

    return array_map('basename', $files);
}

$data = listFiles('./public');

$face = [];
foreach ($data as $key => $value) {
    $tmp = preg_split('/[-_.]/', $value);
    $face[] = [
        'fileName' => $value,
        'name' => $tmp[2],
        'category' => substr($tmp[0], 1, -1),
        'tag' => explode(',', substr($tmp[1], 1, -1)),
    ];
}

file_put_contents('face.json', json_encode($face, JSON_UNESCAPED_UNICODE));
