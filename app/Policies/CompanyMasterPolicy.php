<?php

namespace App\Policies;

use App\CompanyMaster;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CompanyMasterPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any company masters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the company master.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyMaster  $companyMaster
     * @return mixed
     */
    public function view(User $user, CompanyMaster $companyMaster)
    {
        //
    }

    /**
     * Determine whether the user can create company masters.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can update the company master.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyMaster  $companyMaster
     * @return mixed
     */
    public function update(User $user, CompanyMaster $companyMaster)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can delete the company master.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyMaster  $companyMaster
     * @return mixed
     */
    public function delete(User $user, CompanyMaster $companyMaster)
    {
//
    }

    /**
     * Determine whether the user can restore the company master.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyMaster  $companyMaster
     * @return mixed
     */
    public function restore(User $user, CompanyMaster $companyMaster)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the company master.
     *
     * @param  \App\User  $user
     * @param  \App\CompanyMaster  $companyMaster
     * @return mixed
     */
    public function forceDelete(User $user, CompanyMaster $companyMaster)
    {
        //
    }
}
