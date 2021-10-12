<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Moreinfo;
use Illuminate\Auth\Access\HandlesAuthorization;

class MoreinfoPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all moreinfos')
            || $user->hasPermissionTo('view_own moreinfos');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all moreinfos');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Moreinfo $moreinfo
     * @return bool
     */
    public function view(User $user, Moreinfo $moreinfo)
    {
        if($user->hasPermissionTo('view_all moreinfos')) {
            return true;
        }

        if($user->hasPermissionTo('view_all moreinfos')) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Moreinfo $moreinfo
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Moreinfo $moreinfo, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
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
        return $user->hasPermissionTo('create moreinfos');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Moreinfo $moreinfo
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Moreinfo $moreinfo)
    {
        if($user->hasPermissionTo('update_all moreinfos')) {
            return true;
        }

        if($user->hasPermissionTo('update_own moreinfos')) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Moreinfo $moreinfo
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Moreinfo $moreinfo, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Moreinfo $moreinfo
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Moreinfo $moreinfo)
    {
        if($user->hasPermissionTo('delete_all moreinfos')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own moreinfos')) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Moreinfo $moreinfo
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Moreinfo $moreinfo, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Moreinfo $moreinfo is owned by @param User $user
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
     * @param Moreinfo $moreinfo
     * @return bool
     */
    public function delete_media(User $user, Moreinfo $moreinfo)
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
        return $user->hasPermissionTo('export moreinfos');
    }
}
