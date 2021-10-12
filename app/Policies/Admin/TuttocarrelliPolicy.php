<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Tuttocarrelli;
use Illuminate\Auth\Access\HandlesAuthorization;

class TuttocarrelliPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all tuttocarrellis')
            || $user->hasPermissionTo('view_own tuttocarrellis');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all tuttocarrellis');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Tuttocarrelli $tuttocarrelli
     * @return bool
     */
    public function view(User $user, Tuttocarrelli $tuttocarrelli)
    {
        if($user->hasPermissionTo('view_all tuttocarrellis')) {
            return true;
        }

        if($user->hasPermissionTo('view_all tuttocarrellis')) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Tuttocarrelli $tuttocarrelli
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Tuttocarrelli $tuttocarrelli, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
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
        return $user->hasPermissionTo('create tuttocarrellis');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Tuttocarrelli $tuttocarrelli
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Tuttocarrelli $tuttocarrelli)
    {
        if($user->hasPermissionTo('update_all tuttocarrellis')) {
            return true;
        }

        if($user->hasPermissionTo('update_own tuttocarrellis')) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Tuttocarrelli $tuttocarrelli
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Tuttocarrelli $tuttocarrelli, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Tuttocarrelli $tuttocarrelli
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Tuttocarrelli $tuttocarrelli)
    {
        if($user->hasPermissionTo('delete_all tuttocarrellis')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own tuttocarrellis')) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Tuttocarrelli $tuttocarrelli
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Tuttocarrelli $tuttocarrelli, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Tuttocarrelli $tuttocarrelli is owned by @param User $user
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
     * @param Tuttocarrelli $tuttocarrelli
     * @return bool
     */
    public function delete_media(User $user, Tuttocarrelli $tuttocarrelli)
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
        return $user->hasPermissionTo('export tuttocarrellis');
    }
}
