<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use function dd;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all users');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all users')
            || $user->hasPermissionTo('view_own users');
    }

    /**
     * @param User $user
     * @param \App\Models\Admin\User $model
     * @return bool
     * @throws \Exception
     */
    public function view(User $user, User $model)
    {
        if($user->hasPermissionTo('view_all users')) {
            return true;
        }

        if($user->hasPermissionTo('view_own users')) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\User $model
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, User $model, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
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
        return $user->hasPermissionTo('create users');
    }

    /**
     * @param User $user
     * @param User $model
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, User $model)
    {
        if($user->hasPermissionTo('update_all users')) {
            return true;
        }

        if($user->hasPermissionTo('update_own users')) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param User $model
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, User $model, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\User $model
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, User $model)
    {
        if($user->hasPermissionTo('delete_all users')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own users')) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\User $model
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, User $model, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param User $model is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\Admin\User  $user
     * @param  \App\Models\Admin\User  $model
     * @return mixed
     */
    public function restore(User $user, User $model)
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\Admin\User  $user
     * @param  \App\Models\Admin\User  $model
     * @return mixed
     */
    public function forceDelete(User $user, User $model)
    {
        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function assign_roles(User $user)
    {
        return $user->hasPermissionTo('update_sensitive_data users');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function change_active_status(User $user)
    {
        return $user->hasPermissionTo('update_sensitive_data users');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_sensitive_data(User $user)
    {
        return $user->hasPermissionTo('view_sensitive_data users');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function update_sensitive_data(User $user)
    {
        return $user->hasPermissionTo('update_sensitive_data users');
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function export(User $user)
    {
        return $user->hasPermissionTo('export users');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view_permissions(User $user)
    {
        return $user->hasRole('Administrator');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function update_permissions(User $user)
    {
        return $user->hasRole('Administrator');
    }
}
