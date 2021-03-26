<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;

class PostCategoryController extends Controller
{
    public function index()
    {
        return PostCategory::groupBy('name')->get(['id', 'name']);
    }
}
