<?php

namespace App\Policies;

use App\Branch;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class BranchMasterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any branches.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the branch.
     *
     * @param  \App\User  $user
     * @param  \App\Branch  $branch
     * @return mixed
     */
    public function view(User $user, Branch $branch)
    {
        //
    }

    /**
     * Determine whether the user can create branches.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can update the branch.
     *
     * @param  \App\User  $user
     * @param  \App\Branch  $branch
     * @return mixed
     */
    public function update(User $user, Branch $branch)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can delete the branch.
     *
     * @param  \App\User  $user
     * @param  \App\Branch  $branch
     * @return mixed
     */
    public function delete(User $user, Branch $branch)
    {
        //
    }

    /**
     * Determine whether the user can restore the branch.
     *
     * @param  \App\User  $user
     * @param  \App\Branch  $branch
     * @return mixed
     */
    public function restore(User $user, Branch $branch)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the branch.
     *
     * @param  \App\User  $user
     * @param  \App\Branch  $branch
     * @return mixed
     */
    public function forceDelete(User $user, Branch $branch)
    {
        //
    }
}
