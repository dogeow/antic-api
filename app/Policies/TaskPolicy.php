<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tasks.
     */
    public function viewAny(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can view the task.
     */
    public function view(User $user, Task $task): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can create tasks.
     */
    public function create(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can update the task.
     */
    public function update(User $user, Task $task): mixed
    {
        return $user->isAuthorOf($task->project);
    }

    /**
     * Determine whether the user can delete the task.
     */
    public function delete(User $user, Task $task): mixed
    {
        return $user->isAuthorOf($task->project);
    }

    /**
     * Determine whether the user can restore the task.
     */
    public function restore(User $user, Task $task): mixed
    {
        return $user->isAuthorOf($task->project);
    }

    /**
     * Determine whether the user can permanently delete the task.
     */
    public function forceDelete(User $user, Task $task): mixed
    {
        return $user->isAuthorOf($task->project);
    }
}
