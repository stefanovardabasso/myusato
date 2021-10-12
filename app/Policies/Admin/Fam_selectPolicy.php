<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Fam_select;
use Illuminate\Auth\Access\HandlesAuthorization;

class Fam_selectPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all fam_selects')
            || $user->hasPermissionTo('view_own fam_selects');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all fam_selects');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Fam_select $fam_select
     * @return bool
     */
    public function view(User $user, Fam_select $fam_select)
    {
        if($user->hasPermissionTo('view_all fam_selects')) {
            return true;
        }

        if($user->hasPermissionTo('view_all fam_selects')) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Fam_select $fam_select
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Fam_select $fam_select, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
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
        return $user->hasPermissionTo('create fam_selects');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Fam_select $fam_select
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Fam_select $fam_select)
    {
        if($user->hasPermissionTo('update_all fam_selects')) {
            return true;
        }

        if($user->hasPermissionTo('update_own fam_selects')) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Fam_select $fam_select
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Fam_select $fam_select, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Fam_select $fam_select
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Fam_select $fam_select)
    {
        if($user->hasPermissionTo('delete_all fam_selects')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own fam_selects')) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Fam_select $fam_select
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Fam_select $fam_select, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Fam_select $fam_select is owned by @param User $user
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
     * @param Fam_select $fam_select
     * @return bool
     */
    public function delete_media(User $user, Fam_select $fam_select)
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
        return $user->hasPermissionTo('export fam_selects');
    }
}
