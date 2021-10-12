<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Vendorbadge;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorbadgePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all vendorbadges')
            || $user->hasPermissionTo('view_own vendorbadges');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all vendorbadges');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorbadge $vendorbadge
     * @return bool
     */
    public function view(User $user, Vendorbadge $vendorbadge)
    {
        if($user->hasPermissionTo('view_all vendorbadges')) {
            return true;
        }

        if($user->hasPermissionTo('view_all vendorbadges')) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorbadge $vendorbadge
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Vendorbadge $vendorbadge, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
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
        return $user->hasPermissionTo('create vendorbadges');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Vendorbadge $vendorbadge
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Vendorbadge $vendorbadge)
    {
        if($user->hasPermissionTo('update_all vendorbadges')) {
            return true;
        }

        if($user->hasPermissionTo('update_own vendorbadges')) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vendorbadge $vendorbadge
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Vendorbadge $vendorbadge, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorbadge $vendorbadge
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Vendorbadge $vendorbadge)
    {
        if($user->hasPermissionTo('delete_all vendorbadges')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own vendorbadges')) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vendorbadge $vendorbadge
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Vendorbadge $vendorbadge, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Vendorbadge $vendorbadge is owned by @param User $user
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
     * @param Vendorbadge $vendorbadge
     * @return bool
     */
    public function delete_media(User $user, Vendorbadge $vendorbadge)
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
        return $user->hasPermissionTo('export vendorbadges');
    }
}
