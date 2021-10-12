<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Savedfilters_line;
use Illuminate\Auth\Access\HandlesAuthorization;

class Savedfilters_linePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all savedfilters_lines')
            || $user->hasPermissionTo('view_own savedfilters_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all savedfilters_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilters_line $savedfilters_line
     * @return bool
     */
    public function view(User $user, Savedfilters_line $savedfilters_line)
    {
        if($user->hasPermissionTo('view_all savedfilters_lines')) {
            return true;
        }

        if($user->hasPermissionTo('view_all savedfilters_lines')) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilters_line $savedfilters_line
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Savedfilters_line $savedfilters_line, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
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
        return $user->hasPermissionTo('create savedfilters_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Savedfilters_line $savedfilters_line
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Savedfilters_line $savedfilters_line)
    {
        if($user->hasPermissionTo('update_all savedfilters_lines')) {
            return true;
        }

        if($user->hasPermissionTo('update_own savedfilters_lines')) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Savedfilters_line $savedfilters_line
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Savedfilters_line $savedfilters_line, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Savedfilters_line $savedfilters_line
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Savedfilters_line $savedfilters_line)
    {
        if($user->hasPermissionTo('delete_all savedfilters_lines')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own savedfilters_lines')) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Savedfilters_line $savedfilters_line
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Savedfilters_line $savedfilters_line, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Savedfilters_line $savedfilters_line is owned by @param User $user
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
     * @param Savedfilters_line $savedfilters_line
     * @return bool
     */
    public function delete_media(User $user, Savedfilters_line $savedfilters_line)
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
        return $user->hasPermissionTo('export savedfilters_lines');
    }
}
