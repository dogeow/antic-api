<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\AboutMe;

class AboutMeController extends Controller
{
    public function index()
    {
        return collect(AboutMe::all())->groupBy('category');
    }
}
