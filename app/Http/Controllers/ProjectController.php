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
        $user = auth()->user();

        return $user->projects()->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->withCount([
                'tasks' => function ($query) {
                    $query->where('is_completed', false);
                },
            ])
            ->get();
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        Project::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return 'Project created!';
    }

    public function show(Project $project, Request $request)
    {
        $tasks = $project->tasks()->where('is_completed', false)->get();
        $project['tasks'] = $tasks;

        return $project;
    }

    public function update(Project $project, Request $request)
    {
        $project->is_completed = true;
        $project->update();

        return 'Project updated!';
    }

    public function destroy(Project $project, Request $request)
    {
        $project->update(['is_completed' => 1]);

        return $request->user()->projects()->where('is_completed', 0)->get();
    }

    public function admin(Request $request)
    {
        $project = Project::where('user_id', 1)->first();

        $params = ['title', 'priority'];
        $query = $project->tasks()->where('is_completed', 0)->orderBy('priority', 'DESC')->when($request->search,
            function ($query) use ($request) {
                return $query->where('title', 'like', '%'.$request->search.'%');
            });

        return QueryBuilder::for($query)
            ->allowedSorts($params)
            ->allowedFilters($params)->jsonPaginate(request('size'));
    }
}
