<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Productline;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductlinePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all productlines')
            || $user->hasPermissionTo('view_own productlines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all productlines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Productline $productline
     * @return bool
     */
    public function view(User $user, Productline $productline)
    {
        if($user->hasPermissionTo('view_all productlines')) {
            return true;
        }

        if($user->hasPermissionTo('view_all productlines')) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Productline $productline
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Productline $productline, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
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
        return $user->hasPermissionTo('create productlines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Productline $productline
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Productline $productline)
    {
        if($user->hasPermissionTo('update_all productlines')) {
            return true;
        }

        if($user->hasPermissionTo('update_own productlines')) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Productline $productline
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Productline $productline, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Productline $productline
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Productline $productline)
    {
        if($user->hasPermissionTo('delete_all productlines')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own productlines')) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Productline $productline
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Productline $productline, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Productline $productline is owned by @param User $user
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
     * @param Productline $productline
     * @return bool
     */
    public function delete_media(User $user, Productline $productline)
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
        return $user->hasPermissionTo('export productlines');
    }
}
