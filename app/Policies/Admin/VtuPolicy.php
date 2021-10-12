<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Vtu;
use Illuminate\Auth\Access\HandlesAuthorization;

class VtuPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all vtus')
            || $user->hasPermissionTo('view_own vtus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all vtus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vtu $vtu
     * @return bool
     */
    public function view(User $user, Vtu $vtu)
    {
        if($user->hasPermissionTo('view_all vtus')) {
            return true;
        }

        if($user->hasPermissionTo('view_all vtus')) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vtu $vtu
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Vtu $vtu, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
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
        return $user->hasPermissionTo('create vtus');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Vtu $vtu
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Vtu $vtu)
    {
        if($user->hasPermissionTo('update_all vtus')) {
            return true;
        }

        if($user->hasPermissionTo('update_own vtus')) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vtu $vtu
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Vtu $vtu, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Vtu $vtu
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Vtu $vtu)
    {
        if($user->hasPermissionTo('delete_all vtus')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own vtus')) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Vtu $vtu
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Vtu $vtu, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Vtu $vtu is owned by @param User $user
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
     * @param Vtu $vtu
     * @return bool
     */
    public function delete_media(User $user, Vtu $vtu)
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
        return $user->hasPermissionTo('export vtus');
    }
}
