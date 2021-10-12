<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Caract;
use Illuminate\Auth\Access\HandlesAuthorization;

class CaractPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all caracts')
            || $user->hasPermissionTo('view_own caracts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all caracts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Caract $caract
     * @return bool
     */
    public function view(User $user, Caract $caract)
    {
        if($user->hasPermissionTo('view_all caracts')) {
            return true;
        }

        if($user->hasPermissionTo('view_all caracts')) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Caract $caract
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Caract $caract, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
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
        return $user->hasPermissionTo('create caracts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Caract $caract
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Caract $caract)
    {
        if($user->hasPermissionTo('update_all caracts')) {
            return true;
        }

        if($user->hasPermissionTo('update_own caracts')) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Caract $caract
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Caract $caract, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Caract $caract
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Caract $caract)
    {
        if($user->hasPermissionTo('delete_all caracts')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own caracts')) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Caract $caract
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Caract $caract, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Caract $caract is owned by @param User $user
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
     * @param Caract $caract
     * @return bool
     */
    public function delete_media(User $user, Caract $caract)
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
        return $user->hasPermissionTo('export caracts');
    }
}
