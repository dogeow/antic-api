<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Laravel\Scout\Searchable;
use Spatie\QueryBuilder\QueryBuilder;

class PostController extends Controller
{
    use Searchable;

    public function __construct()
    {
        $this->authorizeResource(Post::class, 'post', ['except' => ['index', 'show']]);
    }

    public function index()
    {
        $query = Post::with(['tags:id,post_id,name', 'category:id,post_id,name']);

        if ((auth('api')->user()->id ?? null) !== 1) {
            $query = $query->public();
        }

        return QueryBuilder::for($query)->allowedFilters(['category.name', 'tags.name'])->jsonPaginate(10);
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

        $post->category()->updateOrCreate(['post_id' => $post->id], ['name' => $request->category]);

        return $post;
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return [];
    }
}
