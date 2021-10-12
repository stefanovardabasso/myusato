<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Products_line;
use Illuminate\Auth\Access\HandlesAuthorization;

class Products_linePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all products_lines')
            || $user->hasPermissionTo('view_own products_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all products_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Products_line $products_line
     * @return bool
     */
    public function view(User $user, Products_line $products_line)
    {
        if($user->hasPermissionTo('view_all products_lines')) {
            return true;
        }

        if($user->hasPermissionTo('view_all products_lines')) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Products_line $products_line
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Products_line $products_line, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
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
        return $user->hasPermissionTo('create products_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Products_line $products_line
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Products_line $products_line)
    {
        if($user->hasPermissionTo('update_all products_lines')) {
            return true;
        }

        if($user->hasPermissionTo('update_own products_lines')) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Products_line $products_line
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Products_line $products_line, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Products_line $products_line
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Products_line $products_line)
    {
        if($user->hasPermissionTo('delete_all products_lines')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own products_lines')) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Products_line $products_line
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Products_line $products_line, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Products_line $products_line is owned by @param User $user
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
     * @param Products_line $products_line
     * @return bool
     */
    public function delete_media(User $user, Products_line $products_line)
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
        return $user->hasPermissionTo('export products_lines');
    }
}
