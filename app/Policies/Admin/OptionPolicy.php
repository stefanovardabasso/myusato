<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Option;
use Illuminate\Auth\Access\HandlesAuthorization;

class OptionPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all options')
            || $user->hasPermissionTo('view_own options');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all options');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Option $option
     * @return bool
     */
    public function view(User $user, Option $option)
    {
        if($user->hasPermissionTo('view_all options')) {
            return true;
        }

        if($user->hasPermissionTo('view_all options')) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Option $option
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Option $option, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
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
        return $user->hasPermissionTo('create options');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Option $option
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Option $option)
    {
        if($user->hasPermissionTo('update_all options')) {
            return true;
        }

        if($user->hasPermissionTo('update_own options')) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Option $option
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Option $option, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Option $option
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Option $option)
    {
        if($user->hasPermissionTo('delete_all options')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own options')) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Option $option
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Option $option, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Option $option is owned by @param User $user
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
     * @param Option $option
     * @return bool
     */
    public function delete_media(User $user, Option $option)
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
        return $user->hasPermissionTo('export options');
    }
}
