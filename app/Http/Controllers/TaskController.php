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

        $maxOrder = $project->tasks()->max('order');

        return $project->tasks()->create([
            'title' => $validatedData['title'],
            'order' => $maxOrder === null ? 0 : $maxOrder + 1,
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
            'order' => ['nullable'], // todo
        ]);

        $tasksCount = $project->tasks()->count();

        if ($request->has('order')) {
            $task->order = $tasksCount - $request->order;
            $task->sorted_at = now();
            $task->save();

            return $task;
        }

        $task->update($request->all());

        return $task;
    }
}
