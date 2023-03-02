<?php

declare(strict_types=1);

function listFiles($dir)
{
    $files = glob($dir.'/*', GLOB_NOSORT);
    $whitelist = array('txt'); // 如果需要只列出某些特定类型的文件

    return preg_grep('/\.('.implode('|', $whitelist).')$/i', $files);
}

$data = listFiles('./public/images/face/');

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

file_put_contents('./src/resources/face.json', json_encode($face, JSON_UNESCAPED_UNICODE));
