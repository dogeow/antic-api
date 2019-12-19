<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function todo(){
        $project = Project::where('user_id', 1)->first();
        return response()->json($project->tasks()->where('is_completed', '0')->get());
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['title' => 'required']);

        $project = Project::where('id', $request->project_id)->first();
        if ($request->user()->id !== $project->user_id) {
            return response()->json('兄弟你做啥？');
        }

        $task = Task::create([
            'title' => $validatedData['title'],
            'project_id' => $request->project_id,
            'is_completed' => 0,
        ]);

        return response()->json($task);
    }

    public function markAsCompleted(Task $task, Request $request)
    {
        if ($request->user()->id !== $task->project->user_id) {
            return response()->json('兄弟你做啥？');
        }
        $task->is_completed = true;
        $task->update();

        return response()->json('Task updated!');
    }
}
