<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Project::class, 'project');
    }

    public function index()
    {
        return auth()->user()->projects()
            ->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->withCount(['tasks' => function ($query) {
                $query->where('is_completed', false);
            }])
            ->get();
    }

    public function store(Request $request): string
    {
        $validatedData = $request->validate([
            'name' => ['required', 'unique:App\Models\Project,user_id,name', 'max:255'],
            'description' => ['nullable', 'max:255'],
        ]);

        auth()->user()->projects()->create($validatedData);

        return 'Project created!';
    }

    public function show(Project $project): Project
    {
        $project['tasks'] = $project->tasks()->where('is_completed', false)->get();

        return $project;
    }

    public function update(Project $project): string
    {
        $project->update(['is_completed' => true]);

        return 'Project updated!';
    }

    public function destroy(Project $project): array
    {
        $project->update(['is_completed' => 1]);

        return auth()->user()->projects()->where('is_completed', 0)->get();
    }

    public function admin(Request $request)
    {
        $project = Project::where('user_id', 1)->firstOrFail();

        $params = ['title'];
        $query = $project->tasks()
            ->where('is_completed', 0)
            ->when($request->search, fn ($query, $search) => $query->where('title', 'like', '%' . $search . '%'))
            ->when(empty($request->sort), fn ($query) => $query->orderBy('order', 'ASC'));

        return QueryBuilder::for($query)
            ->allowedSorts($params)
            ->allowedFilters($params)
            ->jsonPaginate(request('size'));
    }
}
