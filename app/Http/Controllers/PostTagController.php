<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Http\Request;
use App\Http\Requests\TagAdd;

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

    public function store(TagAdd $request, Post $post)
    {
        return $post->tags()->create([
            'name' => $request->name,
        ]);
    }
}
