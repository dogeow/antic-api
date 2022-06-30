<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\AboutMe;
use App\Models\Like;
use App\Models\Quote;
use Illuminate\Database\Eloquent\Collection;

class MyStuffController extends Controller
{
    public function aboutMe(): array
    {
        $newData = [];

        $data = collect(AboutMe::all())->groupBy('category')->toArray();
        
        foreach ($data as $key => $value) {
            $newData[] = [
                'category' => $key,
                'list' => $value,
            ];
        }

        return $newData;
    }

    public function Likes(): Collection|array
    {
        return Like::all();
    }

    public function quotes(): Collection|array
    {
        return Quote::all();
    }

    public function quote()
    {
        return Quote::all()->random(1)->first()->content;
    }
}
