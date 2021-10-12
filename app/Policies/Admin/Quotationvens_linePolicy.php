<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Quotationvens_line;
use Illuminate\Auth\Access\HandlesAuthorization;

class Quotationvens_linePolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all quotationvens_lines')
            || $user->hasPermissionTo('view_own quotationvens_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all quotationvens_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationvens_line $quotationvens_line
     * @return bool
     */
    public function view(User $user, Quotationvens_line $quotationvens_line)
    {
        if($user->hasPermissionTo('view_all quotationvens_lines')) {
            return true;
        }

        if($user->hasPermissionTo('view_all quotationvens_lines')) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationvens_line $quotationvens_line
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Quotationvens_line $quotationvens_line, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
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
        return $user->hasPermissionTo('create quotationvens_lines');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Quotationvens_line $quotationvens_line
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Quotationvens_line $quotationvens_line)
    {
        if($user->hasPermissionTo('update_all quotationvens_lines')) {
            return true;
        }

        if($user->hasPermissionTo('update_own quotationvens_lines')) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotationvens_line $quotationvens_line
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Quotationvens_line $quotationvens_line, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Quotationvens_line $quotationvens_line
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Quotationvens_line $quotationvens_line)
    {
        if($user->hasPermissionTo('delete_all quotationvens_lines')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own quotationvens_lines')) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Quotationvens_line $quotationvens_line
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Quotationvens_line $quotationvens_line, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Quotationvens_line $quotationvens_line is owned by @param User $user
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
     * @param Quotationvens_line $quotationvens_line
     * @return bool
     */
    public function delete_media(User $user, Quotationvens_line $quotationvens_line)
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
        return $user->hasPermissionTo('export quotationvens_lines');
    }
}
