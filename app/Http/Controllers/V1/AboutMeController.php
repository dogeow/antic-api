<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;

class AboutMeController extends Controller
{
    public function index()
    {
        $newData = [];
        $data = collect(AboutMe::all())->groupBy('category')->toArray();
        foreach($data as $key => $value){
            $newData[] = [
                'category' => $key,
                'list' => $value
            ];
        }
        
        return $newData;
    }
}
