<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\CRUD_filename;
use Illuminate\Auth\Access\HandlesAuthorization;

class CRUD_filenamePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all CRUD_permission')
            || $user->hasPermissionTo('view_own CRUD_permission');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all CRUD_permission');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\CRUD_filename $CRUD_lcfirst
     * @return bool
     */
    public function view(User $user, CRUD_filename $CRUD_lcfirst)
    {
        if($user->hasPermissionTo('view_all CRUD_permission')) {
            return true;
        }

        if($user->hasPermissionTo('view_all CRUD_permission')) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\CRUD_filename $CRUD_lcfirst
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, CRUD_filename $CRUD_lcfirst, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
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
        return $user->hasPermissionTo('create CRUD_permission');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param CRUD_filename $CRUD_lcfirst
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, CRUD_filename $CRUD_lcfirst)
    {
        if($user->hasPermissionTo('update_all CRUD_permission')) {
            return true;
        }

        if($user->hasPermissionTo('update_own CRUD_permission')) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param CRUD_filename $CRUD_lcfirst
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, CRUD_filename $CRUD_lcfirst, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\CRUD_filename $CRUD_lcfirst
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, CRUD_filename $CRUD_lcfirst)
    {
        if($user->hasPermissionTo('delete_all CRUD_permission')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own CRUD_permission')) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param CRUD_filename $CRUD_lcfirst
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, CRUD_filename $CRUD_lcfirst, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param CRUD_filename $CRUD_lcfirst is owned by @param User $user
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
     * @param CRUD_filename $CRUD_lcfirst
     * @return bool
     */
    public function delete_media(User $user, CRUD_filename $CRUD_lcfirst)
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
        return $user->hasPermissionTo('export CRUD_permission');
    }
}
