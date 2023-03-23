<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public string $folderType = 'images';

    /**
     * @return array<Image>|Collection
     */
    public function index(): Collection|array
    {
        return Image::all();
    }

    /**
     * @return array<string>
     */
    public function store(Request $request): array
    {
        $key = $request->input('key');

        if (! $request->hasFile($key) || is_null($file = $request->file($key))) {
            return [
                'url' => '',
            ];
        }

        // 获取文件名和扩展名
        $originalName = $file->getClientOriginalName();
        $filename = $originalName;

        $existImage = Image::where('original_name', $originalName)->orderByDesc('id')->first();
        if ($existImage) {
            // 获取文件名和扩展名
            $name = $file->getClientOriginalName();
            $extension = $file->extension();
            if ($existImage['name'] === $existImage['original_name']) { // 第二个同名文件
                $filename = $name.'@2.'.$extension;
            } elseif (preg_match('/^.*@(?<number>.*)\..*?$/', (string) $existImage['name'], $matches)) {
                $number = $matches['number'] + 1;
                $filename = "${name}@${number}.${extension}";
            }
        }

        $fullFolder = "$this->folderType/$key";
        $filenameWithPath = "$fullFolder/$filename";

        if($key !== 'things'){
            Image::create([
                'user_id' => 1,
                'original_name' => $originalName,
                'path_name' => $filenameWithPath,
            ]);
        }

        $file->storeAs($fullFolder, $filename, 'oss');

        return [
            'url' => config('services.oss_endpoint').'/'.$filenameWithPath,
            'thumbnailUrl' => config('services.oss_endpoint').'/'.$filenameWithPath,
            'extra' => '',
            'key' => sha1($fullFolder.$originalName),
        ];
    }
}
