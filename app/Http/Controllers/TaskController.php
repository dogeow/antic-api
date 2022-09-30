<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Task::class, 'task');
    }

    /**
     * @param  Project  $project
     * @param  Request  $request
     * @return Model
     */
    public function store(Project $project, Request $request): Model
    {
        $validatedData = $request->validate([
            'title' => 'required',
        ]);

        $count = $project->tasks()->count();
        $order = $project->tasks()->latest('order')->first();

        return $project->tasks()->create([
            'title' => $validatedData['title'],
            'order' => $count === 0 ? 65535 : $order + 65535,
        ]);
    }

    /**
     * @param  Project  $project
     * @param  Task  $task
     * @param  Request  $request
     * @return Task
     */
    public function update(Project $project, Task $task, Request $request): Task
    {
        $request->validate([
            'is_completed' => ['nullable', 'boolean'],
            'order' => ['nullable'],
        ]);

        $tasksCount = $project->tasks()->count();
        $orders = $project->tasks()->orderBy('order', 'desc')->get();

        if ($request->has('order')) {
            if ($request->order == 0) {
                $task->order = $orders[$tasksCount - 1]->order + 65535;
            } elseif ($request->order + 1 == $tasksCount) {
                $task->order = $orders[0]->order / 2;
            } else {
                $task->order = ($orders[$request->order - 1]->order + $orders[$request->order + 1]->order) / 2;
            }

            $task->save();

            return $task;
        }

        $task->update($request->all());

        return $task;
    }
}
