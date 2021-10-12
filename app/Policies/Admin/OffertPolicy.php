<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Offert;
use Illuminate\Auth\Access\HandlesAuthorization;

class OffertPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all offerts')
            || $user->hasPermissionTo('view_own offerts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all offerts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Offert $offert
     * @return bool
     */
    public function view(User $user, Offert $offert)
    {
        if($user->hasPermissionTo('view_all offerts')) {
            return true;
        }

        if($user->hasPermissionTo('view_all offerts')) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Offert $offert
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Offert $offert, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
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
        return $user->hasPermissionTo('create offerts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Offert $offert
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Offert $offert)
    {
        if($user->hasPermissionTo('update_all offerts')) {
            return true;
        }

        if($user->hasPermissionTo('update_own offerts')) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Offert $offert
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Offert $offert, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Offert $offert
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Offert $offert)
    {
        if($user->hasPermissionTo('delete_all offerts')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own offerts')) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Offert $offert
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Offert $offert, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Offert $offert is owned by @param User $user
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
     * @param Offert $offert
     * @return bool
     */
    public function delete_media(User $user, Offert $offert)
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
        return $user->hasPermissionTo('export offerts');
    }
}
