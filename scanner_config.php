<?php

$projectPath = __DIR__;

// 设置需要扫描的文件夹
$scanDirectories = [
    $projectPath.'/app/',
    $projectPath.'/resources/views/',
    $projectPath.'/routes/',
];

// 需扫描的独立文件
$scanFiles = [
    $projectPath.'/app/Helpers.php',
];

return [
    'composerJsonPath' => $projectPath.'/composer.json',
    'vendorPath' => $projectPath.'/vendor/',
    'scanDirectories' => $scanDirectories,
    'scanFiles'=>$scanFiles,
];
