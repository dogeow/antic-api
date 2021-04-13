<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $query = Post::with(['category:id,name', 'tags:id,post_id,name'])->orderByDesc('updated_at');

        if ((auth('api')->user()->id ?? null) !== 1) {
            $query = $query->public();
        }

        return QueryBuilder::for($query)->allowedFilters(['category.name', 'tags.name'])->jsonPaginate(10);
    }

    public function show($id)
    {
        $userId = auth()->user()->id ?? 0;
        if ($userId === 1) {
            return Post::with(['category:id,name', 'tags:id,post_id,name'])
                ->where('id', $id)
                ->firstOrFail();
        }

        return Post::with(['category:id,name', 'tags:id,post_id,name'])
            ->where('id', $id)
            ->where('public',
            1)->firstOrFail();
    }

    public function store(Request $request)
    {
        $validData = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
            'category_id' => 'required',
            'tags' => 'nullable|array',
            'public' => 'required|boolean',
        ])->validate();

        $post = auth()->user()->posts()->create($validData);
        if ($validData['tags']) {
            $post->tags()->createMany($validData['tags']);
        }

        return Post::with(['category:id,name', 'tags:id,post_id,name'])->where('id', $post->id)->first();
    }

    public function update(Request $request, Post $post)
    {
        $post->update($request->all());

        return Post::with(['category:id,name', 'tags:id,post_id,name'])->where('id', $post->id)->first();
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

    public function categoriesCount(): array
    {
        $categoriesWithCount = \App\Models\Post::leftJoin('post_categories as category', 'category.id', '=',
            'posts.category_id')
            ->select('category.id', 'category.name', DB::raw('count(*) as count'))
            ->groupBy('category.name')
            ->get();

        return array_values(collect($categoriesWithCount)
            ->sortByDesc('count')
            ->toArray()
        );
    }

    public function tagsCount(): array
    {
        $tagsWithCount = \App\Models\PostTag::select([
            'name', DB::raw('count(*) as count'),
        ])->groupBy('name')->get();

        return array_values(collect($tagsWithCount)->sortByDesc('count')->toArray());
    }
}
