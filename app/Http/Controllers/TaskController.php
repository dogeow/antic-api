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
            'order' => ['nullable'], // todo
        ]);

        if ($request->has('order')) {
            if ($task->order < $request->order) {
                $tasks = Task::whereBetween('order', [$task->order + 1, $request->order])->get();
                foreach ($tasks as $item) {
                    $item->order--;
                    $item->save();
                }
            } else {
                $tasks = Task::whereBetween('order', [$request->order, $task->order - 1])->get();
                foreach ($tasks as $item) {
                    $item->order++;
                    $item->save();
                }
            }

            $task->order = $request->order;
            $task->save();

            return $task;
        }

        $task->update($request->all());

        return $task;
    }
}
