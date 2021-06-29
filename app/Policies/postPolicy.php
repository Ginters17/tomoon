<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class postPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Post $post)
    {
        $canDestroy = 0;
        if($user->id === $post->user_id) $canDestroy = 1;
        elseif ($user->role == 1) $canDestroy = 1;
        return $canDestroy;
    }
    public function update(User $user, Post $post)
    {
        return $user->id === $post->user_id;
    }


    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
