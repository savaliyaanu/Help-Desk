<?php

namespace App\Policies;

use App\DeliveryChallanOut;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DeliveryChallanOutPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any delivery challan outs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the delivery challan out.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryChallanOut  $deliveryChallanOut
     * @return mixed
     */
    public function view(User $user, DeliveryChallanOut $deliveryChallanOut)
    {
        //
    }

    /**
     * Determine whether the user can create delivery challan outs.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can update the delivery challan out.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryChallanOut  $deliveryChallanOut
     * @return mixed
     */
    public function update(User $user, DeliveryChallanOut $deliveryChallanOut)
    {
        return in_array($user->role_id,[1,2,3]);
    }

    /**
     * Determine whether the user can delete the delivery challan out.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryChallanOut  $deliveryChallanOut
     * @return mixed
     */
    public function delete(User $user, DeliveryChallanOut $deliveryChallanOut)
    {
        return in_array($user->role_id,[1,2]);
    }

    /**
     * Determine whether the user can restore the delivery challan out.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryChallanOut  $deliveryChallanOut
     * @return mixed
     */
    public function restore(User $user, DeliveryChallanOut $deliveryChallanOut)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the delivery challan out.
     *
     * @param  \App\User  $user
     * @param  \App\DeliveryChallanOut  $deliveryChallanOut
     * @return mixed
     */
    public function forceDelete(User $user, DeliveryChallanOut $deliveryChallanOut)
    {
        //
    }
}
