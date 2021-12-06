<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Project;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any projects.
     */
    public function viewAny(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can view the project.
     */
    public function view(User $user, Project $project): mixed
    {
        return $user->isAuthorOf($project);
    }

    /**
     * Determine whether the user can create projects.
     */
    public function create(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can update the project.
     */
    public function update(User $user, Project $project): mixed
    {
        return $user->isAuthorOf($project);
    }

    /**
     * Determine whether the user can delete the project.
     */
    public function delete(User $user, Project $project): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can restore the project.
     */
    public function restore(User $user, Project $project): mixed
    {
        return $user->id === $project->user_id;
    }

    /**
     * Determine whether the user can permanently delete the project.
     */
    public function forceDelete(User $user, Project $project): mixed
    {
        return $user->id === $project->user_id;
    }
}
