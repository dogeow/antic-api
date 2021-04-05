<?php

namespace App\Http\Controllers;

use App\Http\Requests\TagAdd;
use App\Models\Post;
use App\Models\PostTag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class PostTagController extends Controller
{
    public function index(): Collection
    {
        return PostTag::distinct()->get('name');
    }

    public function delete(Request $request, Post $post)
    {
        return $post->tags()->where('name', $request->name)->delete();
    }

    public function store(TagAdd $request, Post $post): \Illuminate\Database\Eloquent\Collection
    {
        $names =[];
        foreach($request->name as $value){
            $names[] = ['name' => $value];
        }

        $post->tags()->delete();

        return $post->tags()->createMany($names);
    }
}
