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

    public function update(Project $project, Task $task, Request $request): Task
    {
        $request->validate([
            'is_completed' => ['nullable', 'boolean'],
            'order' => ['nullable'], // todo
        ]);

        $tasksCount = $project->tasks()->count();

        if ($request->has('order')) {
            $newOrder = $tasksCount - $request->order - 1;
            if ($task->order < $newOrder) { // UI 上升
                $tasks = $project->tasks()->whereBetween('order', [$task->order + 1, $newOrder])->get();
                foreach ($tasks as $item) {
                    $item->order--;
                    $item->save();
                }
            } elseif ($task->order > $newOrder) {
                $tasks = $project->tasks()->whereBetween('order', [$newOrder, $task->order - 1])->get();
                foreach ($tasks as $item) {
                    $item->order++;
                    $item->save();
                }
            }

            $task->order = $newOrder;
            $task->save();

            return $task;
        }

        $task->update($request->all());

        return $task;
    }
}
