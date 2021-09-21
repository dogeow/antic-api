<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public string $folderType = 'images';

    /**
     * @return Image[]|Collection
     */
    public function index(): Collection|array
    {
        return Image::all();
    }

    /**
     * @param  Request  $request
     * @return string[]
     */
    public function store(Request $request): array
    {
        $key = $request->input('key');

        if (false === $request->hasFile($key) || is_null($file = $request->file($key))) {
            return [
                'url' => '',
            ];
        }
        
        $originalName = $file->getClientOriginalName();

        $existImage = Image::where('original_name', $originalName)->orderByDesc('id')->first();
        if ($existImage) {
            // 获取文件名和扩展名
            $name = $file->getClientOriginalName();
            $extension = $file->extension();
            if ($existImage['name'] === $existImage['original_name']) { // 第二个同名文件
                $filename = $name.'@2.'.$extension;
            } elseif (preg_match('/^.*@(?<number>.*)\..*?$/', $existImage['name'], $matches)) {
                $number = $matches['number'] + 1;
                $filename = "$name@$number.$extension";
            }
        } else {
            $filename = $originalName;
        }

        $fullFolder = "$this->folderType/$key";

        Image::create([
            'user_id' => 1,
            'original_name' => $originalName,
            'folder' => $fullFolder,
            'name' => $filename,
        ]);

        $file->storeAs($fullFolder, $filename, 'oss');

        $filenameWithPath = "$fullFolder/$filename";

        return [
            'url' => "https://oss.dogeow.com/{$filenameWithPath}",
        ];
    }
}
