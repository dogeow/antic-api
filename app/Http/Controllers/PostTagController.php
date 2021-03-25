<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Http\Request;

class PostTagController extends Controller
{
    public function index()
    {
        return PostTag::groupBy('name')->pluck('name');
    }

    public function delete(Request $request, Post $post)
    {
        return $post->tags()->where('name', $request->name)->delete();
    }

    public function store(Request $request, Post $post)
    {
        return $post->tags()->create([
            'name' => $request->name,
        ]);
    }
}
