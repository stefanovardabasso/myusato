<?php

namespace App\Policies\Admin;

use App\Models\Admin\User;
use App\Models\Admin\Report;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReportPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function view_all(User $user)
    {
        return $user->hasPermissionTo('view_all reports');
    }

    /**
     * @param User $user
     * @return bool
     */
    public function view_index(User $user)
    {
        return $user->hasPermissionTo('view_all reports')
            || $user->hasPermissionTo('view_own reports');
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Report $report
     * @return bool
     * @throws \Exception
     */
    public function view(User $user, Report $report)
    {
        if($user->hasPermissionTo('view_all reports')) {
            return true;
        }

        if($user->hasPermissionTo('view_own reports')) {
            //TODO implement custom logic to define if @param Report $report is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Report $report
     * @param bool $viewAll
     * @param bool $viewOwn
     * @return bool
     */
    public function dt_view(User $user, Report $report, bool $viewAll, bool $viewOwn)
    {
        if($viewAll) {
            return true;
        }

        if($viewOwn) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create reports.
     *
     * @param  \App\Models\Admin\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return false;
    }

    /**
     * Determine whether the user can update the report.
     *
     * @param  \App\Models\Admin\User  $user
     * @param  \App\Models\Admin\Report  $report
     * @return mixed
     */
    public function update(User $user, Report $report)
    {
        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param Report $report
     * @param bool $updateAll
     * @param bool $updateOwn
     * @return bool
     */
    public function dt_update(User $user, Report $report, bool $updateAll, bool $updateOwn)
    {
        if($updateAll) {
            return true;
        }

        if($updateOwn) {
            //TODO implement custom logic to define if @param Report $report is owned by @param User $user
            return false;
        }

        return false;
    }

    /**
     * @param User $user
     * @param Report $report
     * @return bool
     * @throws \Exception
     */
    public function delete(User $user, Report $report)
    {
        if($report->state == 'in_progress') {
            return false;
        }

        if($user->hasPermissionTo('delete_all reports')) {
            return true;
        }

        if($user->hasPermissionTo('delete_own reports')) {
            return $report->creator_id == $user->id;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Report $report
     * @param $deleteAll
     * @param $deleteOwn
     * @return bool
     */
    public function dt_delete(User $user, Report $report, $deleteAll, $deleteOwn)
    {
        if($deleteAll) {
            return true;
        }

        if($deleteOwn) {
            return $report->creator_id == $user->id;
            return false;
        }

        return false;
    }

    /**
     * Determine whether the user can restore the report.
     *
     * @param  \App\Models\Admin\User  $user
     * @param  \App\Models\Admin\Report  $report
     * @return mixed
     */
    public function restore(User $user, Report $report)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the report.
     *
     * @param  \App\Models\Admin\User  $user
     * @param  \App\Models\Admin\Report  $report
     * @return mixed
     */
    public function forceDelete(User $user, Report $report)
    {
        //
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Report $report
     * @return bool
     * @throws \Exception
     */
    public function download(User $user, Report $report)
    {
        if($report->state != 'completed') {
            return false;
        }

        if($user->hasPermissionTo('download_all reports')) {
            return true;
        }

        if($user->hasPermissionTo('download_own reports')) {
            return $report->creator_id == $user->id;
        }

        return false;
    }

    /**
     * @param \App\Models\Admin\User $user
     * @param \App\Models\Admin\Report $report
     * @return bool
     * @throws \Exception
     */
    public function dt_download(User $user, Report $report, $downloadAll, $downloadOwn)
    {
        if($report->state != 'completed') {
            return false;
        }

        if($downloadAll) {
            return true;
        }

        if($downloadOwn) {
            return $report->creator_id == $user->id;
        }

        return false;
    }
}
