<?php

namespace App\Http\Controllers;

use App\Models\Post\Category;
use Illuminate\Support\Collection;

class PostCategoryController extends Controller
{
    public function index(): Collection
    {
        return Category::groupBy('name')->get(['id', 'name']);
    }
}
