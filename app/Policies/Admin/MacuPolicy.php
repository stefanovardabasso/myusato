<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Macu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MacuPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all macus')
            || $user->hasPermissionTo('view_own macus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all macus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Macu $macu
     * @return bool
     */
    public function view(User $user, Macu $macu)
    {
        if($user->hasPermissionTo('view_all macus')) {
            return true;
        }

        if($user->hasPermissionTo('view_all macus')) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Macu $macu
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Macu $macu, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
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
        return $user->hasPermissionTo('create macus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Macu $macu
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Macu $macu)
    {
        if($user->hasPermissionTo('update_all macus')) {
            return true;
        }

        if($user->hasPermissionTo('update_own macus')) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Macu $macu
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Macu $macu, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Macu $macu
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Macu $macu)
    {
        if($user->hasPermissionTo('delete_all macus')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own macus')) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Macu $macu
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Macu $macu, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Macu $macu is owned by @param User $user
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
     * @param Macu $macu
     * @return bool
     */
    public function delete_media(User $user, Macu $macu)
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
        return $user->hasPermissionTo('export macus');
    }
}
