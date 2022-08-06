<?php

namespace App\Policies;

use App\Complain;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComplainPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any complains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can view the complain.
     *
     * @param  \App\User  $user
     * @param  \App\Complain  $complain
     * @return mixed
     */
    public function view(User $user, Complain $complain)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can create complains.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can update the complain.
     *
     * @param  \App\User  $user
     * @param  \App\Complain  $complain
     * @return mixed
     */
    public function update(User $user, Complain $complain)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can delete the complain.
     *
     * @param  \App\User  $user
     * @param  \App\Complain  $complain
     * @return mixed
     */
    public function delete(User $user, Complain $complain)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can restore, the complain.
     *
     * @param  \App\User  $user
     * @param  \App\Complain  $complain
     * @return mixed
     */
    public function restore(User $user, Complain $complain)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the complain.
     *
     * @param  \App\User  $user
     * @param  \App\Complain  $complain
     * @return mixed
     */
    public function forceDelete(User $user, Complain $complain)
    {
       //
    }
}
