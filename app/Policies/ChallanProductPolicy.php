<?php

namespace App\Policies;

use App\ChallanProduct;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChallanProductPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any challan products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the challan product.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanProduct  $challanProduct
     * @return mixed
     */
    public function view(User $user, ChallanProduct $challanProduct)
    {
        //
    }

    /**
     * Determine whether the user can create challan products.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id, [1,2,3]);
    }

    /**
     * Determine whether the user can update the challan product.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanProduct  $challanProduct
     * @return mixed
     */
    public function update(User $user, ChallanProduct $challanProduct)
    {
        return in_array($user->role_id, [1,2]);
    }

    /**
     * Determine whether the user can delete the challan product.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanProduct  $challanProduct
     * @return mixed
     */
    public function delete(User $user, ChallanProduct $challanProduct)
    {
        return in_array($user->role_id, [1,2]);
    }

    /**
     * Determine whether the user can restore the challan product.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanProduct  $challanProduct
     * @return mixed
     */
    public function restore(User $user, ChallanProduct $challanProduct)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the challan product.
     *
     * @param  \App\User  $user
     * @param  \App\ChallanProduct  $challanProduct
     * @return mixed
     */
    public function forceDelete(User $user, ChallanProduct $challanProduct)
    {
        //
    }
}
