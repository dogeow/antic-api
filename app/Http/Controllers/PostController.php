<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        return Post::with('tags')->with('categories')->get();
    }

    public function store(Request $request)
    {
        \Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ])->validate();

        $content = $request->input('content');
        $title = $request->input('title');

        return auth()->user()->posts()->create([
            'title' => $title,
            'content' => $content,
        ]);
    }

    public function show(Post $post)
    {
        return $post;
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return [];
    }
}
