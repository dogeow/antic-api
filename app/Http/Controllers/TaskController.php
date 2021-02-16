<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function store(Project $project, Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required',
            'priority' => ['nullable', Rule::in([1, 2, 3])],
        ]);

        return $project->tasks()->save(new Task([
            'title' => $validatedData['title'],
            'priority' => $request->priority,
        ]));
    }

    public function update(Task $task, Request $request)
    {
        $request->validate([
            'is_completed' => ['nullable', 'boolean'],
            'priority' => ['nullable', Rule::in([1, 2, 3])],
        ]);

        $task->update($request->all());

        return $task;
    }
}
