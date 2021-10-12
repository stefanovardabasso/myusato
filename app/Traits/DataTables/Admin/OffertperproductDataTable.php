<?php

namespace App\Traits\DataTables\Admin;

use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;

trait OffertperproductDataTable
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
         $query->select([
            'id'    => 'id',
            'title' => 'title',
            'createdby' => 'createdby',
            'date' => 'date',
            'status_preparation' => 'status_preparation',
            'target_user' => 'target_user',
            'number_mac' => 'number_mac',
        ])->where('id',  '2');

        return $query;
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all offerts');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own offerts');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all offerts');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own offerts');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all offerts');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own offerts');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.offerts';

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
                    'data' => 'title', 'className' => 'dt_col_title', 'label' => self::getAttrsTrans('title'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'createdby', 'className' => 'dt_col_title', 'label' => 'createdby',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'date', 'className' => 'dt_col_title', 'label' => 'date',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'status_preparation', 'className' => 'dt_col_title', 'label' => 'status_preparation',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'date_finish_off', 'className' => 'dt_col_title', 'label' => 'date_finish_off',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'target_user', 'className' => 'dt_col_title', 'label' => 'target_user',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'number_mac', 'className' => 'dt_col_title', 'label' => 'number_mac',
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
            'order' => [ ['id', 'asc'] ],
            'pageLength' => 25
        ];
    }

}
