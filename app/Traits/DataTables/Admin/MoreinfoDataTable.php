<?php

namespace App\Traits\DataTables\Admin;

use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait MoreinfoDataTable
{
    use DataTable;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSelectRows($query)
    {
        return $query->select([
            'id'    => 'id',
            'email'=>'email',
            'name'=> 'name'
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableGroupBy($query)
    {
        return $query;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableFilterColumns($table)
    {
        return $table;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableEditColumns($table)
    {
        self::dataTableSetRawColumns($table);

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all moreinfos');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own moreinfos');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all moreinfos');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own moreinfos');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all moreinfos');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own moreinfos');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.moreinfos';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        return $table;
    }

    /**
     * @param $table
     */
    public static function dataTableExport($table)
    {
        $columns = self::dataTableExportColumns(['actions']);
        self::dataTableQueueExport($table, $columns);
    }

    /**
     * @param $tableId
     * @param $route
     * @return array
     */
    public static function getDataTableObject($tableId, $route)
    {
        return [
            'id' => $tableId,
            'columns' => [
                [
                    'data' => 'actions',
                    'searchable' => false,
                    'sortable' => false,
                    'className' => 'dt_col_actions',
                    'label' => __('Actions'),
                    'raw' => true
                ],
                [
                    'data' => 'email', 'className' => 'dt_col_email', 'label' => __('email'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'name', 'className' => 'dt_col_name', 'label' => __('name'),
                    'filter' => [ 'type' => "search" ]
                ],
            ],
            'ajax' => [
                'url' => $route,
                'method' => 'POST',
                'data' => [
                    '_token' => csrf_token(),
                    'roles' => []
                ],
            ],
            'order' => [ ['email', 'asc'] ],
            'pageLength' => 25
        ];
    }

}

