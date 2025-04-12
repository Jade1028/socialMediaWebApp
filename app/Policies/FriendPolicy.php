<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FriendPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function before(User $user)
    {
        if ($user->is_banned) {
            abort(403, 'Your account has been permanently banned.');
        }
        return null;
    }

    public function viewAny(User $user)
    {
        return true;
    }

    public function create(User $user)
    {
        return true;
    }

    public function delete(User $user){
        return true;
    }

    public function accept(User $user){
        return true;
    }
    public function reject(User $user){
        return true;
    }
}
