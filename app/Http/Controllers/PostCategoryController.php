<?php

namespace App\Http\Controllers;

use App\Models\PostCategory;
use Illuminate\Support\Collection;

class PostCategoryController extends Controller
{
    public function index(): Collection
    {
        return PostCategory::groupBy('name')->get(['id', 'name']);
    }
}
