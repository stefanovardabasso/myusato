<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Cms;
use Illuminate\Auth\Access\HandlesAuthorization;

class CmsPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all cmss')
            || $user->hasPermissionTo('view_own cmss');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all cmss');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Cms $cms
     * @return bool
     */
    public function view(User $user, Cms $cms)
    {
        if($user->hasPermissionTo('view_all cmss')) {
            return true;
        }

        if($user->hasPermissionTo('view_all cmss')) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Cms $cms
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Cms $cms, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
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
        return $user->hasPermissionTo('create cmss');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Cms $cms
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Cms $cms)
    {
        if($user->hasPermissionTo('update_all cmss')) {
            return true;
        }

        if($user->hasPermissionTo('update_own cmss')) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Cms $cms
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Cms $cms, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Cms $cms
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Cms $cms)
    {
        if($user->hasPermissionTo('delete_all cmss')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own cmss')) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Cms $cms
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Cms $cms, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Cms $cms is owned by @param User $user
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
     * @param Cms $cms
     * @return bool
     */
    public function delete_media(User $user, Cms $cms)
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
        return $user->hasPermissionTo('export cmss');
    }
}
