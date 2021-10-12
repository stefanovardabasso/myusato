<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Savedfilter;
use Illuminate\Auth\Access\HandlesAuthorization;

class SavedfilterPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all savedfilters')
            || $user->hasPermissionTo('view_own savedfilters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all savedfilters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilter $savedfilter
     * @return bool
     */
    public function view(User $user, Savedfilter $savedfilter)
    {
        if($user->hasPermissionTo('view_all savedfilters')) {
            return true;
        }

        if($user->hasPermissionTo('view_all savedfilters')) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilter $savedfilter
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Savedfilter $savedfilter, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
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
        return $user->hasPermissionTo('create savedfilters');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Savedfilter $savedfilter
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Savedfilter $savedfilter)
    {
        if($user->hasPermissionTo('update_all savedfilters')) {
            return true;
        }

        if($user->hasPermissionTo('update_own savedfilters')) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Savedfilter $savedfilter
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Savedfilter $savedfilter, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilter $savedfilter
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Savedfilter $savedfilter)
    {
        if($user->hasPermissionTo('delete_all savedfilters')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own savedfilters')) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Savedfilter $savedfilter
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Savedfilter $savedfilter, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Savedfilter $savedfilter is owned by @param User $user
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
     * @param Savedfilter $savedfilter
     * @return bool
     */
    public function delete_media(User $user, Savedfilter $savedfilter)
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
        return $user->hasPermissionTo('export savedfilters');
    }
}
