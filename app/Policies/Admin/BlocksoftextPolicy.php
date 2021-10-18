<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Blocksoftext;
use Illuminate\Auth\Access\HandlesAuthorization;

class BlocksoftextPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all blocksoftexts')
            || $user->hasPermissionTo('view_own blocksoftexts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all blocksoftexts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Blocksoftext $blocksoftext
     * @return bool
     */
    public function view(User $user, Blocksoftext $blocksoftext)
    {
        if($user->hasPermissionTo('view_all blocksoftexts')) {
            return true;
        }

        if($user->hasPermissionTo('view_all blocksoftexts')) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Blocksoftext $blocksoftext
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Blocksoftext $blocksoftext, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
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
        return $user->hasPermissionTo('create blocksoftexts');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Blocksoftext $blocksoftext
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Blocksoftext $blocksoftext)
    {
        if($user->hasPermissionTo('update_all blocksoftexts')) {
            return true;
        }

        if($user->hasPermissionTo('update_own blocksoftexts')) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Blocksoftext $blocksoftext
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Blocksoftext $blocksoftext, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Blocksoftext $blocksoftext
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Blocksoftext $blocksoftext)
    {
        if($user->hasPermissionTo('delete_all blocksoftexts')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own blocksoftexts')) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Blocksoftext $blocksoftext
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Blocksoftext $blocksoftext, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Blocksoftext $blocksoftext is owned by @param User $user
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
     * @param Blocksoftext $blocksoftext
     * @return bool
     */
    public function delete_media(User $user, Blocksoftext $blocksoftext)
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
        return $user->hasPermissionTo('export blocksoftexts');
    }
}
