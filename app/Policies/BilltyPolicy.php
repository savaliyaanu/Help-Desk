<?php

namespace App\Policies;

use App\Billty;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BilltyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any billties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the billty.
     *
     * @param  \App\User  $user
     * @param  \App\Billty  $billty
     * @return mixed
     */
    public function view(User $user, Billty $billty)
    {
        //
    }

    /**
     * Determine whether the user can create billties.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can update the billty.
     *
     * @param  \App\User  $user
     * @param  \App\Billty  $billty
     * @return mixed
     */
    public function update(User $user, Billty $billty)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can delete the billty.
     *
     * @param  \App\User  $user
     * @param  \App\Billty  $billty
     * @return mixed
     */
    public function delete(User $user, Billty $billty)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the billty.
     *
     * @param  \App\User  $user
     * @param  \App\Billty  $billty
     * @return mixed
     */
    public function restore(User $user, Billty $billty)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the billty.
     *
     * @param  \App\User  $user
     * @param  \App\Billty  $billty
     * @return mixed
     */
    public function forceDelete(User $user, Billty $billty)
    {
        //
    }
}
