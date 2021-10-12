<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Galrtc;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalrtcPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all galrtcs')
            || $user->hasPermissionTo('view_own galrtcs');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all galrtcs');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Galrtc $galrtc
     * @return bool
     */
    public function view(User $user, Galrtc $galrtc)
    {
        if($user->hasPermissionTo('view_all galrtcs')) {
            return true;
        }

        if($user->hasPermissionTo('view_all galrtcs')) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Galrtc $galrtc
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Galrtc $galrtc, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
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
        return $user->hasPermissionTo('create galrtcs');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Galrtc $galrtc
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Galrtc $galrtc)
    {
        if($user->hasPermissionTo('update_all galrtcs')) {
            return true;
        }

        if($user->hasPermissionTo('update_own galrtcs')) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Galrtc $galrtc
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Galrtc $galrtc, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Galrtc $galrtc
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Galrtc $galrtc)
    {
        if($user->hasPermissionTo('delete_all galrtcs')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own galrtcs')) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Galrtc $galrtc
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Galrtc $galrtc, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Galrtc $galrtc is owned by @param User $user
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
     * @param Galrtc $galrtc
     * @return bool
     */
    public function delete_media(User $user, Galrtc $galrtc)
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
        return $user->hasPermissionTo('export galrtcs');
    }
}