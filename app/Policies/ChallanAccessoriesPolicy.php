<?php

namespace App\Policies;

use App\ChallanAccessories;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallanAccessoriesPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any challan accessories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the challan accessories.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanAccessories  $challanAccessories
     * @return mixed
     */
    public function view(User $user, ChallanAccessories $challanAccessories)
    {
        //
    }

    /**
     * Determine whether the user can create challan accessories.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1,2]);
    }

    /**
     * Determine whether the user can update the challan accessories.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanAccessories  $challanAccessories
     * @return mixed
     */
    public function update(User $user, ChallanAccessories $challanAccessories)
    {
        return in_array($user->role_id, [1,2]);
    }

    /**
     * Determine whether the user can delete the challan accessories.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanAccessories  $challanAccessories
     * @return mixed
     */
    public function delete(User $user, ChallanAccessories $challanAccessories)
    {
        return in_array($user->role_id, [1]);
    }

    /**
     * Determine whether the user can restore the challan accessories.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanAccessories  $challanAccessories
     * @return mixed
     */
    public function restore(User $user, ChallanAccessories $challanAccessories)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the challan accessories.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanAccessories  $challanAccessories
     * @return mixed
     */
    public function forceDelete(User $user, ChallanAccessories $challanAccessories)
    {
        //
    }
}
