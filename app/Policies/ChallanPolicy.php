<?php

namespace App\Policies;

use App\Challan;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallanPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any challans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the challan.
     *
     * @param  \App\User  $user
     * @param  \App\Challan  $challan
     * @return mixed
     */
    public function view(User $user, Challan $challan)
    {
        //
    }

    /**
     * Determine whether the user can create challans.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can update the challan.
     *
     * @param  \App\User  $user
     * @param  \App\Challan  $challan
     * @return mixed
     */
    public function update(User $user, Challan $challan)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can delete the challan.
     *
     * @param  \App\User  $user
     * @param  \App\Challan  $challan
     * @return mixed
     */
    public function delete(User $user, Challan $challan)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the challan.
     *
     * @param  \App\User  $user
     * @param  \App\Challan  $challan
     * @return mixed
     */
    public function restore(User $user, Challan $challan)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the challan.
     *
     * @param  \App\User  $user
     * @param  \App\Challan  $challan
     * @return mixed
     */
    public function forceDelete(User $user, Challan $challan)
    {
        //
    }
}
