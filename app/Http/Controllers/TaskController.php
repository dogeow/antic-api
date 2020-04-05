<?php

namespace App\Http\Controllers;

use App\Models\Project;
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
        $isCompleted = $request->get('is_completed');
        if (isset($isCompleted)) {
            $task->is_completed = true;
            $task->update();
        } else {
            $task->title = $request->get('title');

            return $task->update();
        }

        return $task;
    }
}