<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Contactform;
use Illuminate\Auth\Access\HandlesAuthorization;

class ContactformPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all contactforms')
            || $user->hasPermissionTo('view_own contactforms');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all contactforms');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Contactform $contactform
     * @return bool
     */
    public function view(User $user, Contactform $contactform)
    {
        if($user->hasPermissionTo('view_all contactforms')) {
            return true;
        }

        if($user->hasPermissionTo('view_all contactforms')) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Contactform $contactform
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Contactform $contactform, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
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
        return $user->hasPermissionTo('create contactforms');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Contactform $contactform
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Contactform $contactform)
    {
        if($user->hasPermissionTo('update_all contactforms')) {
            return true;
        }

        if($user->hasPermissionTo('update_own contactforms')) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Contactform $contactform
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Contactform $contactform, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Contactform $contactform
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Contactform $contactform)
    {
        if($user->hasPermissionTo('delete_all contactforms')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own contactforms')) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Contactform $contactform
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Contactform $contactform, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Contactform $contactform is owned by @param User $user
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
     * @param Contactform $contactform
     * @return bool
     */
    public function delete_media(User $user, Contactform $contactform)
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
        return $user->hasPermissionTo('export contactforms');
    }
}
