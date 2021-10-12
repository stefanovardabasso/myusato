<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Place;
use Illuminate\Auth\Access\HandlesAuthorization;

class PlacePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all places')
            || $user->hasPermissionTo('view_own places');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all places');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Place $place
     * @return bool
     */
    public function view(User $user, Place $place)
    {
        if($user->hasPermissionTo('view_all places')) {
            return true;
        }

        if($user->hasPermissionTo('view_all places')) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Place $place
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Place $place, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function create(User $user)
    {
        return $user->hasPermissionTo('create places');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Place $place
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Place $place)
    {
        if($user->hasPermissionTo('update_all places')) {
            return true;
        }

        if($user->hasPermissionTo('update_own places')) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Place $place
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Place $place, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Place $place
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Place $place)
    {
        if($user->hasPermissionTo('delete_all places')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own places')) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Place $place
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Place $place, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Place $place is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function mass_delete(User $user)
    {
        return false;
    }

    /**
     * @param User $user
     * @param Place $place
     * @return bool
     */
    public function delete_media(User $user, Place $place)
    {
        return true;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function export(User $user)
    {
        return $user->hasPermissionTo('export places');
    }
}
