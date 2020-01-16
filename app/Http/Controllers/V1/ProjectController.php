<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;


class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::where('user_id', $request->user()->id)->where('is_completed', false)
            ->orderBy('created_at', 'desc')
            ->withCount(['tasks' => function ($query) {
                $query->where('is_completed', false);
            }])
            ->get();

        return response()->json($projects);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
        ]);

        $project = Project::create([
            'user_id' => $user->id,
            'name' => $validatedData['name'],
            'description' => $validatedData['description'],
        ]);

        return response()->json('Project created!');
    }

    public function show($id, Request $request)
    {
        $project = Project::where('user_id', $request->user()->id)->with(['tasks' => function ($query) {
            $query->where('is_completed', false);
        }])->find($id);

        return response()->json($project);
    }

    public function markAsCompleted(Project $project, Request $request)
    {
        if ($request->user()->id !== $project->user_id) {
            return response()->json('兄弟你做啥？');
        }
        $project->is_completed = true;
        $project->update();

        return response()->json('Project updated!');
    }
}
