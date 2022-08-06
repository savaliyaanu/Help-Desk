<?php

namespace App\Policies;

use App\ReplacementExpense;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplacementExpensePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any replacement expenses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the replacement expense.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementExpense  $replacementExpense
     * @return mixed
     */
    public function view(User $user, ReplacementExpense $replacementExpense)
    {
        //
    }

    /**
     * Determine whether the user can create replacement expenses.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can update the replacement expense.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementExpense  $replacementExpense
     * @return mixed
     */
    public function update(User $user, ReplacementExpense $replacementExpense)
    {
        return (in_array($user->role_id,[1,2]));
    }

    /**
     * Determine whether the user can delete the replacement expense.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementExpense  $replacementExpense
     * @return mixed
     */
    public function delete(User $user, ReplacementExpense $replacementExpense)
    {
        return (in_array($user->role_id,[1]));
    }

    /**
     * Determine whether the user can restore the replacement expense.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementExpense  $replacementExpense
     * @return mixed
     */
    public function restore(User $user, ReplacementExpense $replacementExpense)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the replacement expense.
     *
     * @param  \App\User  $user
     * @param  \App\ReplacementExpense  $replacementExpense
     * @return mixed
     */
    public function forceDelete(User $user, ReplacementExpense $replacementExpense)
    {
        //
    }
}
