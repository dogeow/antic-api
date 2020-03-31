<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        return Project::where('user_id', $request->user()->id)->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->withCount(['tasks' => function ($query) {
                $query->where('is_completed', false);
            }])
            ->get();
    }

    public function store(Request $request)
    {
        $user = $request->user();

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

    public function show($id, Request $request)
    {
        return Project::where('user_id', $request->user()->id)->with(['tasks' => function ($query) {
            $query->where('is_completed', false);
        }])->find($id);
    }

    public function markAsCompleted(Project $project, Request $request)
    {
        if ($request->user()->id !== $project->user_id) {
            return '兄弟你做啥？';
        }
        $project->is_completed = true;
        $project->update();

        return 'Project updated!';
    }
}
