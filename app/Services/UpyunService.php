<?php
namespace App\Services;

use Illuminate\Support\Str;
use Upyun\Config;
use Upyun\Upyun;

class UpyunService
{
    private Upyun $upyun;

    public function __construct()
    {
        $bucketName = config('services.upyun.bucket_name');
        $operatorName = config('services.upyun.operator_name');
        $operatorPassword = config('services.upyun.operator_password');

        $config = new Config($bucketName, $operatorName, $operatorPassword);

        $this->upyun = new Upyun($config);
    }

    public function getInstance(): Upyun
    {
        return $this->upyun;
    }

    /**
     * 获取文件名，递归两层
     */
    public function getFiles(string $path, $onlyImages = false): array
    {
        $upyunInstance = $this->getInstance();
        $data = $upyunInstance->read($path);

        // 筛选出文件
        $files = array_filter($data['files'], function ($item) {
            return $item['type'] == 'N';
        });
        // 只要文件名
        $files = array_map(function ($item) {
            return $item['name'];
        }, $files);

        // 判断有存在目录时，还需要进行获取
        foreach ($data['files'] as $file) {
            if ($file['type'] == 'F') {
                $data = $upyunInstance->read($path.'/'.$file['name']);
                $files = array_merge($files, array_map(function ($item) use ($file) {
                    return $file['name'].'/'.$item['name'];
                }, $data['files']));
            }
        }

        // 过滤不是图片后缀的
        if ($onlyImages) {
            $files = array_filter($files, function ($item) {
                return in_array(Str::afterLast($item, '.'), ['jpg', 'jpeg', 'png', 'gif']);
            });
        }

        return $files;
    }
}
