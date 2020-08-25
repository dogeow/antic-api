<?php

namespace App\Http\Controllers;

use App\models\PostCategory;

class PostCategoryController extends Controller
{
    public function index()
    {
        return PostCategory::groupBy('name')->pluck('name');
    }
}
