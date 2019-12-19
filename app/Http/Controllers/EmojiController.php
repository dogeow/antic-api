<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Upyun\Upyun;
use Upyun\Config;

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
        if ($request->hasFile($key) === false) {
            return '没有文件';
        }
        if ($request->file($key)->isValid() === false) {
            return '上传失败';
        }

        $filename = $request->file($key)->getClientOriginalName();
        $extension = $request->file($key)->getClientOriginalExtension();
        // getClientOriginalExtension

        $path = $request->file($key)->storeAs(
            'images/emoji', $filename, 'public'
        );

        return response()->json(self::get());
    }

    public function index()
    {
        return response()->json(self::get());
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
