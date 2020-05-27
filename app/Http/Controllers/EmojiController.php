<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Upyun\Config;
use Upyun\Upyun;

class EmojiController extends Controller
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

        $filename = $request->file($key)->getClientOriginalName();

        $path = $request->file($key)->storeAs(
            'images/emoji',
            $filename,
            'public'
        );

        return [
            'url' => config('app.url').'/storage/'.$path,
        ];
    }

    public function index()
    {
        return $this->get();
    }

    public function get()
    {
        // 获取现有文件
        $data = [];
        $wallpaperFolder = public_path().'/storage/images/emoji/';
        $wallpapers = \File::files($wallpaperFolder);
        foreach ($wallpapers as $wallpaper) {
            $data[] = '/storage/images/emoji/'.$wallpaper->getFilename();
        }

        return $data;
    }
}
