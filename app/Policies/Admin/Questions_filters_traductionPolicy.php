<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Questions_filters_traduction;
use Illuminate\Auth\Access\HandlesAuthorization;

class Questions_filters_traductionPolicy
{
    use HandlesAuthorization;

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all questions_filters_traductions')
            || $user->hasPermissionTo('view_own questions_filters_traductions');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all questions_filters_traductions');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Questions_filters_traduction $questions_filters_traduction
     * @return bool
     */
    public function view(User $user, Questions_filters_traduction $questions_filters_traduction)
    {
        if($user->hasPermissionTo('view_all questions_filters_traductions')) {
            return true;
        }

        if($user->hasPermissionTo('view_all questions_filters_traductions')) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Questions_filters_traduction $questions_filters_traduction
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Questions_filters_traduction $questions_filters_traduction, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
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
        return $user->hasPermissionTo('create questions_filters_traductions');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return bool
     * @throws \Exception
     */
    public function update(User $user, Questions_filters_traduction $questions_filters_traduction)
    {
        if($user->hasPermissionTo('update_all questions_filters_traductions')) {
            return true;
        }

        if($user->hasPermissionTo('update_own questions_filters_traductions')) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Questions_filters_traduction $questions_filters_traduction
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Questions_filters_traduction $questions_filters_traduction, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Questions_filters_traduction $questions_filters_traduction
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Questions_filters_traduction $questions_filters_traduction)
    {
        if($user->hasPermissionTo('delete_all questions_filters_traductions')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own questions_filters_traductions')) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Questions_filters_traduction $questions_filters_traduction
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Questions_filters_traduction $questions_filters_traduction, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            //TODO implement custom logic to define if @param Questions_filters_traduction $questions_filters_traduction is owned by @param User $user
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
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return bool
     */
    public function delete_media(User $user, Questions_filters_traduction $questions_filters_traduction)
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
        return $user->hasPermissionTo('export questions_filters_traductions');
    }
}
