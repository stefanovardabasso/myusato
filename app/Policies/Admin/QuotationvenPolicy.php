<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Quotationven;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationvenPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all quotationvens')
            || $user->hasPermissionTo('view_own quotationvens');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all quotationvens');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationven $quotationven
     * @return bool
     */
    public function view(User $user, Quotationven $quotationven)
    {
        if($user->hasPermissionTo('view_all quotationvens')) {
            return true;
        }

        if($user->hasPermissionTo('view_all quotationvens')) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationven $quotationven
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Quotationven $quotationven, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
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
        return $user->hasPermissionTo('create quotationvens');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Quotationven $quotationven
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Quotationven $quotationven)
    {
        if($user->hasPermissionTo('update_all quotationvens')) {
            return true;
        }

        if($user->hasPermissionTo('update_own quotationvens')) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotationven $quotationven
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Quotationven $quotationven, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationven $quotationven
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Quotationven $quotationven)
    {
        if($user->hasPermissionTo('delete_all quotationvens')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own quotationvens')) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotationven $quotationven
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Quotationven $quotationven, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Quotationven $quotationven is owned by @param User $user
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
     * @param Quotationven $quotationven
     * @return bool
     */
    public function delete_media(User $user, Quotationven $quotationven)
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
        return $user->hasPermissionTo('export quotationvens');
    }
}
