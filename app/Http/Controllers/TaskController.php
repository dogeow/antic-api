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
        if ($request->input('priority') && ! in_array($request->input('priority'), [1, 2, 3, '低', '中', '高'])) {
            return response()->json(['message' => '值在1（低）），2（中），3（高）范围'], 400);
        }

        $task->update($request->all());

        return $task;
    }
}
