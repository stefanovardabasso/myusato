<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Gallery;
use Illuminate\Auth\Access\HandlesAuthorization;

class GalleryPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all gallerys')
            || $user->hasPermissionTo('view_own gallerys');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all gallerys');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Gallery $gallery
     * @return bool
     */
    public function view(User $user, Gallery $gallery)
    {
        if($user->hasPermissionTo('view_all gallerys')) {
            return true;
        }

        if($user->hasPermissionTo('view_all gallerys')) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Gallery $gallery
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Gallery $gallery, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
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
        return $user->hasPermissionTo('create gallerys');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Gallery $gallery
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Gallery $gallery)
    {
        if($user->hasPermissionTo('update_all gallerys')) {
            return true;
        }

        if($user->hasPermissionTo('update_own gallerys')) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Gallery $gallery
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Gallery $gallery, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Gallery $gallery
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Gallery $gallery)
    {
        if($user->hasPermissionTo('delete_all gallerys')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own gallerys')) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Gallery $gallery
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Gallery $gallery, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Gallery $gallery is owned by @param User $user
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
     * @param Gallery $gallery
     * @return bool
     */
    public function delete_media(User $user, Gallery $gallery)
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
        return $user->hasPermissionTo('export gallerys');
    }
}
