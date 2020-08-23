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
        $posts = Post::with(['tags:post_id,name', 'category:post_id,name'])->get();
        $data = $posts->toArray();
        foreach ($posts as $key => $post) {
            $data[$key]['tags'] = $post->tags->pluck('name');
            $data[$key]['category'] = $post->category ? $post->category->value('name') : null;
        }

        return $data;
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

    public function show($id)
    {
        $post = Post::where('id', $id)->with(['tags:post_id,name', 'category:post_id,name'])->firstOrFail();
        $data = $post->toArray();
        $data['tags'] = $post->tags->pluck('name');
        $data['category'] = $post->category ? $post->category->value('name') : null;

        return $data;
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        $post->category()->update([
            'name' => $request->category
        ]);

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return [];
    }
}
