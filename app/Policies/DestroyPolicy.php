<?php

namespace App\Policies;

use App\Destroy;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DestroyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any destroys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the destroy.
     *
     * @param  \App\User  $user
     * @param  \App\Destroy  $destroy
     * @return mixed
     */
    public function view(User $user, Destroy $destroy)
    {
       //
    }

    /**
     * Determine whether the user can create destroys.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can update the destroy.
     *
     * @param  \App\User  $user
     * @param  \App\Destroy  $destroy
     * @return mixed
     */
    public function update(User $user, Destroy $destroy)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can delete the destroy.
     *
     * @param  \App\User  $user
     * @param  \App\Destroy  $destroy
     * @return mixed
     */
    public function delete(User $user, Destroy $destroy)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the destroy.
     *
     * @param  \App\User  $user
     * @param  \App\Destroy  $destroy
     * @return mixed
     */
    public function restore(User $user, Destroy $destroy)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the destroy.
     *
     * @param  \App\User  $user
     * @param  \App\Destroy  $destroy
     * @return mixed
     */
    public function forceDelete(User $user, Destroy $destroy)
    {
        //
    }
}
