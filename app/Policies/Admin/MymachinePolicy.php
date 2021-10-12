<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Mymachine;
use Illuminate\Auth\Access\HandlesAuthorization;

class MymachinePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all mymachines')
            || $user->hasPermissionTo('view_own mymachines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all mymachines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Mymachine $mymachine
     * @return bool
     */
    public function view(User $user, Mymachine $mymachine)
    {
        if($user->hasPermissionTo('view_all mymachines')) {
            return true;
        }

        if($user->hasPermissionTo('view_all mymachines')) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Mymachine $mymachine
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Mymachine $mymachine, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
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
        return $user->hasPermissionTo('create mymachines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Mymachine $mymachine
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Mymachine $mymachine)
    {
        if($user->hasPermissionTo('update_all mymachines')) {
            return true;
        }

        if($user->hasPermissionTo('update_own mymachines')) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Mymachine $mymachine
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Mymachine $mymachine, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Mymachine $mymachine
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Mymachine $mymachine)
    {
        if($user->hasPermissionTo('delete_all mymachines')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own mymachines')) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Mymachine $mymachine
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Mymachine $mymachine, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Mymachine $mymachine is owned by @param User $user
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
     * @param Mymachine $mymachine
     * @return bool
     */
    public function delete_media(User $user, Mymachine $mymachine)
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
        return $user->hasPermissionTo('export mymachines');
    }
}
