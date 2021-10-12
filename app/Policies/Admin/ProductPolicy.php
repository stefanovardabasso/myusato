<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all products')
            || $user->hasPermissionTo('view_own products');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all products');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Product $product
     * @return bool
     */
    public function view(User $user, Product $product)
    {
        if($user->hasPermissionTo('view_all products')) {
            return true;
        }

        if($user->hasPermissionTo('view_all products')) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Product $product
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Product $product, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
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
        return $user->hasPermissionTo('create products');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Product $product
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Product $product)
    {
        if($user->hasPermissionTo('update_all products')) {
            return true;
        }

        if($user->hasPermissionTo('update_own products')) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Product $product
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Product $product, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Product $product
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Product $product)
    {
        if($user->hasPermissionTo('delete_all products')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own products')) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Product $product
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Product $product, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Product $product is owned by @param User $user
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
     * @param Product $product
     * @return bool
     */
    public function delete_media(User $user, Product $product)
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
        return $user->hasPermissionTo('export products');
    }
}
