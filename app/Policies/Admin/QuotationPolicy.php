<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Quotation;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuotationPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all quotations')
            || $user->hasPermissionTo('view_own quotations');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all quotations');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotation $quotation
     * @return bool
     */
    public function view(User $user, Quotation $quotation)
    {
        if($user->hasPermissionTo('view_all quotations')) {
            return true;
        }

        if($user->hasPermissionTo('view_all quotations')) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotation $quotation
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Quotation $quotation, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
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
        return $user->hasPermissionTo('create quotations');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Quotation $quotation
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Quotation $quotation)
    {
        if($user->hasPermissionTo('update_all quotations')) {
            return true;
        }

        if($user->hasPermissionTo('update_own quotations')) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotation $quotation
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Quotation $quotation, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotation $quotation
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Quotation $quotation)
    {
        if($user->hasPermissionTo('delete_all quotations')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own quotations')) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotation $quotation
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Quotation $quotation, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Quotation $quotation is owned by @param User $user
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
     * @param Quotation $quotation
     * @return bool
     */
    public function delete_media(User $user, Quotation $quotation)
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
        return $user->hasPermissionTo('export quotations');
    }
}
