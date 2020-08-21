<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Upyun\Config;
use Upyun\Upyun;

class ImageController extends Controller
{
    public $client;

    public function __construct()
    {
        $serviceConfig = new Config(env('CDN_SERVICE_NAME'), env('CDN_OPERATOR_NAME'), env('CDN_OPERATOR_PASSWORD'));
        $this->client = new Upyun($serviceConfig);
    }

    public function store(Request $request)
    {
        $key = 'emoji';
        if (false === $request->hasFile($key)) {
            return '没有文件';
        }
        if (false === $request->file($key)->isValid()) {
            return '上传失败';
        }

        $originalName = $request->file($key)->getClientOriginalName();

        $existImage = Image::where('name', $originalName)->orderBy('id', 'desc')->first();
        if ($existImage) {
            // 获取文件名和扩展名
            preg_match('/^(.*)\.(.*?)$/', $originalName, $matches);
            $name = $matches[1];
            $extension = $matches[2];
            if ($existImage['name'] === $existImage['original_name']) { // 第二个同名文件
                $filename = $name.'@2.'.$extension;
            } else {
                // 获取相同文件名的编码
                preg_match('/^.*#(.*)\..*?$/', $existImage['name'], $matches);
                $number = $matches[1];
                $filename = $name.'@'.($number + 1).'.'.$extension;
            }
        } else {
            $filename = $originalName;
        }

        $path = $request->file($key)->storeAs(
            'images/emoji',
            $filename,
            'public'
        );

        Image::create([
            'user_id' => 1,
            'original_name' => $originalName,
            'name' => $filename,
        ]);

        return [
            'url' => $path ? config('app.url').'/storage/'.$path : false,
        ];
    }

    public function index()
    {
        return collect(\File::files(public_path().'/storage/images/emoji/'))->map(function ($item) {
            return '/storage/images/emoji/'.$item->getFilename();
        }) ?? [];
    }
}
