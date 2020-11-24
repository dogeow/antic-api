<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function index()
    {
//        $path = __FUNCTION__;
//        $data = $this->client->read($path, null, []);
//
//        $fileAddSrc = array_map(function (&$file) use ($path) {
//            $file['src'] = env('CDN_URL')."/{$path}/{$file['name']}";
//
//            return $file;
//        }, $data['files']);
//        $data['files'] = $fileAddSrc;

        return Like::all();
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

//        $file = fopen($request->file($key), 'r');
    }
}
