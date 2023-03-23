<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): mixed
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): mixed
    {
        return $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can restore the post.
     */
    public function restore(User $user, Post $post): mixed
    {
        return $user->isAuthorOf($post);
    }

    /**
     * Determine whether the user can permanently delete the post.
     */
    public function forceDelete(User $user, Post $post): mixed
    {
        return $user->isAuthorOf($post);
    }
}
