<?php

namespace App\Policies;

use App\CreditNote;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CreditNotePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any credit notes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the credit note.
     *
     * @param  \App\User  $user
     * @param  \App\CreditNote  $creditNote
     * @return mixed
     */
    public function view(User $user, CreditNote $creditNote)
    {
        //
    }

    /**
     * Determine whether the user can create credit notes.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can update the credit note.
     *
     * @param  \App\User  $user
     * @param  \App\CreditNote  $creditNote
     * @return mixed
     */
    public function update(User $user, CreditNote $creditNote)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can delete the credit note.
     *
     * @param  \App\User  $user
     * @param  \App\CreditNote  $creditNote
     * @return mixed
     */
    public function delete(User $user, CreditNote $creditNote)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the credit note.
     *
     * @param  \App\User  $user
     * @param  \App\CreditNote  $creditNote
     * @return mixed
     */
    public function restore(User $user, CreditNote $creditNote)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the credit note.
     *
     * @param  \App\User  $user
     * @param  \App\CreditNote  $creditNote
     * @return mixed
     */
    public function forceDelete(User $user, CreditNote $creditNote)
    {
        //
    }
}
