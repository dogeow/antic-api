<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

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
        return Project::with([
            'tasks' => function ($query) {
                $query->where('is_completed', false);
            },
        ])->first();
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

    public function admin()
    {
        $project = Project::where('user_id', 1)->first();

        return $project ? $project->tasks()->where('is_completed', 0)->get() : [];
    }
}
