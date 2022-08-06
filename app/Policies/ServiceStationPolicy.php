<?php

namespace App\Policies;

use App\ServiceStation;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ServiceStationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any service stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the service station.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceStation  $serviceStation
     * @return mixed
     */
    public function view(User $user, ServiceStation $serviceStation)
    {
        //
    }

    /**
     * Determine whether the user can create service stations.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can update the service station.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceStation  $serviceStation
     * @return mixed
     */
    public function update(User $user, ServiceStation $serviceStation)
    {
        return in_array($user->role_id,[1]);
    }

    /**
     * Determine whether the user can delete the service station.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceStation  $serviceStation
     * @return mixed
     */
    public function delete(User $user, ServiceStation $serviceStation)
    {
        //
    }

    /**
     * Determine whether the user can restore the service station.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceStation  $serviceStation
     * @return mixed
     */
    public function restore(User $user, ServiceStation $serviceStation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the service station.
     *
     * @param  \App\User  $user
     * @param  \App\ServiceStation  $serviceStation
     * @return mixed
     */
    public function forceDelete(User $user, ServiceStation $serviceStation)
    {
        //
    }
}
