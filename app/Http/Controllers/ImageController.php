<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public string $folder = 'images/emoji';

    public function store(Request $request): array
    {
        $key = 'emoji';
        if (false === $request->hasFile($key)) {
            return [
                'url' => '',
            ];
        }
        if (false === $request->file($key)->isValid()) {
            return [
                'url' => '',
            ];
        }

        $originalName = $request->file($key)->getClientOriginalName();

        $existImage = Image::where('original_name', $originalName)->orderByDesc('id')->first();
        if ($existImage) {
            // 获取文件名和扩展名
            $name = $request->file($key)->getClientOriginalName();
            $extension = $request->file($key)->extension();
            if ($existImage['name'] === $existImage['original_name']) { // 第二个同名文件
                $filename = $name.'@2.'.$extension;
            } else {
                // 获取相同文件名的编码
                preg_match('/^.*@(.*)\..*?$/', $existImage['name'], $matches);
                $number = $matches[1];
                $filename = $name.'@'.($number + 1).'.'.$extension;
            }
        } else {
            $filename = $originalName;
        }

        Image::create([
            'user_id' => 1,
            'original_name' => $originalName,
            'name' => $filename,
        ]);

        $request->file($key)->storeAs($this->folder, $filename, 'oss');

        $filenameWithPath = $this->folder.'/'.$filename;

        return [
            'url' => "https://oss.gugelong.com/{$filenameWithPath}",
        ];
    }
}
