<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reservation;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReservationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the reservation can view any models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('list reservations');
    }

    /**
     * Determine whether the reservation can view the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Reservation  $model
     * @return mixed
     */
    public function view(User $user, Reservation $model)
    {
        return $user->hasPermissionTo('view reservations');
    }

    /**
     * Determine whether the reservation can create models.
     *
     * @param  App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create reservations');
    }

    /**
     * Determine whether the reservation can update the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Reservation  $model
     * @return mixed
     */
    public function update(User $user, Reservation $model)
    {
        return $user->hasPermissionTo('update reservations');
    }

    /**
     * Determine whether the reservation can delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Reservation  $model
     * @return mixed
     */
    public function delete(User $user, Reservation $model)
    {
        return $user->hasPermissionTo('delete reservations');
    }

    /**
     * Determine whether the reservation can restore the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Reservation  $model
     * @return mixed
     */
    public function restore(User $user, Reservation $model)
    {
        return false;
    }

    /**
     * Determine whether the reservation can permanently delete the model.
     *
     * @param  App\Models\User  $user
     * @param  App\Models\Reservation  $model
     * @return mixed
     */
    public function forceDelete(User $user, Reservation $model)
    {
        return false;
    }
}
