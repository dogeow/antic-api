<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $query = Post::with(['category:id,name', 'tags:id,post_id,name']);

        if ((auth('api')->user()->id ?? null) !== 1) {
            $query = $query->public();
        }

        return QueryBuilder::for($query)->allowedFilters(['category.name', 'tags.name'])->jsonPaginate(10);
    }

    public function show($id)
    {
        $post = Post::with(['category:id,name', 'tags:post_id,name'])->where('id', $id)->firstOrFail();
        $data = $post->toArray();
        $data['tags'] = $post->tags;
        $data['category'] = $post->category->name ?? '';

        return $data;
    }

    public function store(Request $request)
    {
        Validator::make($request->all(), [
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

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        if ($request->category) {
            $post->category()->updateOrCreate(['post_id' => $post->id], ['name' => $request->category]);
        }

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return [];
    }

    public function search(Request $request)
    {
        return Post::search($request->search)->get();
    }
}
