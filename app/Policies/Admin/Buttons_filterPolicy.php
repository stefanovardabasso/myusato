<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Buttons_filter;
use Illuminate\Auth\Access\HandlesAuthorization;

class Buttons_filterPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all buttons_filters')
            || $user->hasPermissionTo('view_own buttons_filters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all buttons_filters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Buttons_filter $buttons_filter
     * @return bool
     */
    public function view(User $user, Buttons_filter $buttons_filter)
    {
        if($user->hasPermissionTo('view_all buttons_filters')) {
            return true;
        }

        if($user->hasPermissionTo('view_all buttons_filters')) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Buttons_filter $buttons_filter
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Buttons_filter $buttons_filter, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
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
        return $user->hasPermissionTo('create buttons_filters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Buttons_filter $buttons_filter
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Buttons_filter $buttons_filter)
    {
        if($user->hasPermissionTo('update_all buttons_filters')) {
            return true;
        }

        if($user->hasPermissionTo('update_own buttons_filters')) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Buttons_filter $buttons_filter
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Buttons_filter $buttons_filter, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Buttons_filter $buttons_filter
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Buttons_filter $buttons_filter)
    {
        if($user->hasPermissionTo('delete_all buttons_filters')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own buttons_filters')) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Buttons_filter $buttons_filter
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Buttons_filter $buttons_filter, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Buttons_filter $buttons_filter is owned by @param User $user
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
     * @param Buttons_filter $buttons_filter
     * @return bool
     */
    public function delete_media(User $user, Buttons_filter $buttons_filter)
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
        return $user->hasPermissionTo('export buttons_filters');
    }
}
