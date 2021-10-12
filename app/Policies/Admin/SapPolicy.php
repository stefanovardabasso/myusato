<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Sap;
use Illuminate\Auth\Access\HandlesAuthorization;

class SapPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all saps')
            || $user->hasPermissionTo('view_own saps');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all saps');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Sap $sap
     * @return bool
     */
    public function view(User $user, Sap $sap)
    {
        if($user->hasPermissionTo('view_all saps')) {
            return true;
        }

        if($user->hasPermissionTo('view_all saps')) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Sap $sap
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Sap $sap, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
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
        return $user->hasPermissionTo('create saps');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Sap $sap
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Sap $sap)
    {
        if($user->hasPermissionTo('update_all saps')) {
            return true;
        }

        if($user->hasPermissionTo('update_own saps')) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Sap $sap
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Sap $sap, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Sap $sap
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Sap $sap)
    {
        if($user->hasPermissionTo('delete_all saps')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own saps')) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Sap $sap
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Sap $sap, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Sap $sap is owned by @param User $user
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
     * @param Sap $sap
     * @return bool
     */
    public function delete_media(User $user, Sap $sap)
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
        return $user->hasPermissionTo('export saps');
    }
}
