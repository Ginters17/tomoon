<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Auth\Access\HandlesAuthorization;

class commentPolicy
{
    use HandlesAuthorization;

    public function destroy(User $user, Comment $comment)
    {
        $canDestroy = 0;
        if($user->id === $comment->user_id) $canDestroy = 1;
        elseif ($user->role == 1) $canDestroy = 1;
        return $canDestroy;
    }

    public function update(User $user, Comment $comment)
    {
        return $user->id === $comment->user_id;
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
