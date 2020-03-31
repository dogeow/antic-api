<?php

namespace App\Http\Controllers;

use App\Models\AboutMe;

class AboutMeController extends Controller
{
    public function __invoke()
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
}
