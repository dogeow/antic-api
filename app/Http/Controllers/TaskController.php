<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function todo()
    {
        $project = Project::where('user_id', 1)->first();

        return $project ? $project->tasks()->where('is_completed', 0)->get() : [];
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['title' => 'required']);

        $project = Project::where('id', $request->project_id)->first();
        if ($request->user()->id !== $project->user_id) {
            return '兄弟你做啥？';
        }

        return Task::create([
            'title' => $validatedData['title'],
            'project_id' => $request->project_id,
            'is_completed' => 0,
        ]);
    }

    public function update(Task $task, Request $request)
    {
        if ($request->user()->id !== $task->project->user_id) {
            return '兄弟你做啥？';
        }

        $isCompleted = $request->get('is_completed');
        if (isset($isCompleted)) {
            $task->is_completed = true;
            $task->update();
        } else {
            $task->title = $request->get('title');
            $task->update();
        }

        return 'Task updated!';
    }

    public function delete($projectId)
    {
        Project::where('id', $projectId)->update(['is_completed' => 1]);

        return Project::where('is_completed', 0)->get();
    }
}
