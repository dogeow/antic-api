<?php

namespace App\Http\Controllers;

use App\Models\PostTag;

class PostTagController extends Controller
{
    public function index()
    {
        return PostTag::groupBy('name')->pluck('name');
    }
}
