<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate(['title' => 'required']);

        return Task::create([
            'title' => $validatedData['title'],
            'project_id' => $request->project_id,
            'is_completed' => 0,
        ]);
    }

    public function update(Task $task, Request $request)
    {
        $task->update($request->all());

        return $task;
    }
}
