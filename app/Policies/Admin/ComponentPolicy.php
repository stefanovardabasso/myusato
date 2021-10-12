<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Component;
use Illuminate\Auth\Access\HandlesAuthorization;

class ComponentPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all components')
            || $user->hasPermissionTo('view_own components');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all components');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Component $component
     * @return bool
     */
    public function view(User $user, Component $component)
    {
        if($user->hasPermissionTo('view_all components')) {
            return true;
        }

        if($user->hasPermissionTo('view_all components')) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Component $component
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Component $component, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
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
        return $user->hasPermissionTo('create components');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Component $component
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Component $component)
    {
        if($user->hasPermissionTo('update_all components')) {
            return true;
        }

        if($user->hasPermissionTo('update_own components')) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Component $component
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Component $component, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Component $component
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Component $component)
    {
        if($user->hasPermissionTo('delete_all components')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own components')) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Component $component
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Component $component, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Component $component is owned by @param User $user
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
     * @param Component $component
     * @return bool
     */
    public function delete_media(User $user, Component $component)
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
        return $user->hasPermissionTo('export components');
    }
}
