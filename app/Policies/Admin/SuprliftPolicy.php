<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Suprlift;
use Illuminate\Auth\Access\HandlesAuthorization;

class SuprliftPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all suprlifts')
            || $user->hasPermissionTo('view_own suprlifts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all suprlifts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Suprlift $suprlift
     * @return bool
     */
    public function view(User $user, Suprlift $suprlift)
    {
        if($user->hasPermissionTo('view_all suprlifts')) {
            return true;
        }

        if($user->hasPermissionTo('view_all suprlifts')) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Suprlift $suprlift
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Suprlift $suprlift, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
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
        return $user->hasPermissionTo('create suprlifts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Suprlift $suprlift
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Suprlift $suprlift)
    {
        if($user->hasPermissionTo('update_all suprlifts')) {
            return true;
        }

        if($user->hasPermissionTo('update_own suprlifts')) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Suprlift $suprlift
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Suprlift $suprlift, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Suprlift $suprlift
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Suprlift $suprlift)
    {
        if($user->hasPermissionTo('delete_all suprlifts')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own suprlifts')) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Suprlift $suprlift
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Suprlift $suprlift, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Suprlift $suprlift is owned by @param User $user
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
     * @param Suprlift $suprlift
     * @return bool
     */
    public function delete_media(User $user, Suprlift $suprlift)
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
        return $user->hasPermissionTo('export suprlifts');
    }
}
