<?php

namespace App\Policies;

use App\AdvanceReplacement;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdvanceReplacementPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any advance replacements.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the advance replacement.
     *
     * @param \App\User $user
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return mixed
     */
    public function view(User $user, AdvanceReplacement $advanceReplacement)
    {
        //
    }

    /**
     * Determine whether the user can create advance replacements.
     *
     * @param \App\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can update the advance replacement.
     *
     * @param \App\User $user
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return mixed
     */
    public function update(User $user, AdvanceReplacement $advanceReplacement)
    {
        return in_array($user->role_id, [1,2]);
    }

    /**
     * Determine whether the user can delete the advance replacement.
     *
     * @param \App\User $user
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return mixed
     */
    public function delete(User $user, AdvanceReplacement $advanceReplacement)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the advance replacement.
     *
     * @param \App\User $user
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return mixed
     */
    public function restore(User $user, AdvanceReplacement $advanceReplacement)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the advance replacement.
     *
     * @param \App\User $user
     * @param \App\AdvanceReplacement $advanceReplacement
     * @return mixed
     */
    public function forceDelete(User $user, AdvanceReplacement $advanceReplacement)
    {
        //
    }
}
