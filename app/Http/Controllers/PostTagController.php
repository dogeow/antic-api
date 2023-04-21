<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagAdd;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostTagController extends Controller
{
    public function index(): Collection
    {
        return Tag::distinct()->get('name');
    }

    public function delete(Request $request, Post $post)
    {
        return $post->tags()->where('name', $request->name)->delete();
    }

    public function store(TagAdd $request, Post $post)
    {
        $names = [];
        foreach ((array) $request->name as $value) {
            $names[] = ['name' => $value];
        }

        $post->tags()->createMany($names);

        return $post->tags;
    }
}
