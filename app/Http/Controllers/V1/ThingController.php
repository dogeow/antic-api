<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Thing;
use Illuminate\Http\Request;
use Upyun\Config;
use Upyun\Upyun;

class ThingController extends Controller
{
    public $client;

    public function __construct()
    {
        $serviceConfig = new Config(env('CDN_SERVICE_NAME'), env('CDN_OPERATOR_NAME'), env('CDN_OPERATOR_PASSWORD'));
        $this->client = new Upyun($serviceConfig);
    }

    public function love()
    {
        $path = __FUNCTION__;
        $data = $this->client->read($path, null, []);

        $fileAddSrc = array_map(function (&$file) use ($path) {
            $file['src'] = env('CDN_URL')."/{$path}/{$file['name']}";

            return $file;
        }, $data['files']);
        $data['files'] = $fileAddSrc;

        return $data;
    }

    public function store(Request $request)
    {
        $key = 'love';

        if (false === $request->hasFile($key)) {
            return '没有文件';
        }
        if (false === $request->file($key)->isValid()) {
            return '上传失败';
        }

        $filename = $request->file($key)->getClientOriginalName();

        // 放到又拍云
        $file = fopen($request->file($key), 'r');

        return $this->client->write($key.'/'.$filename, $file);
    }
}
