<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Vendorplace;
use Illuminate\Auth\Access\HandlesAuthorization;

class VendorplacePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all vendorplaces')
            || $user->hasPermissionTo('view_own vendorplaces');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all vendorplaces');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorplace $vendorplace
     * @return bool
     */
    public function view(User $user, Vendorplace $vendorplace)
    {
        if($user->hasPermissionTo('view_all vendorplaces')) {
            return true;
        }

        if($user->hasPermissionTo('view_all vendorplaces')) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorplace $vendorplace
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Vendorplace $vendorplace, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
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
        return $user->hasPermissionTo('create vendorplaces');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Vendorplace $vendorplace
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Vendorplace $vendorplace)
    {
        if($user->hasPermissionTo('update_all vendorplaces')) {
            return true;
        }

        if($user->hasPermissionTo('update_own vendorplaces')) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vendorplace $vendorplace
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Vendorplace $vendorplace, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vendorplace $vendorplace
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Vendorplace $vendorplace)
    {
        if($user->hasPermissionTo('delete_all vendorplaces')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own vendorplaces')) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vendorplace $vendorplace
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Vendorplace $vendorplace, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Vendorplace $vendorplace is owned by @param User $user
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
     * @param Vendorplace $vendorplace
     * @return bool
     */
    public function delete_media(User $user, Vendorplace $vendorplace)
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
        return $user->hasPermissionTo('export vendorplaces');
    }
}
