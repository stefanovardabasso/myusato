<?php

namespace App\Traits\DataTables\Admin;

use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;

trait ContactformDataTable
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
            'from_email' => 'from_email',
            'company' => 'company',
            'phone' => 'phone',
            'created_at' => 'created_at',
            'privacy_flag' => 'privacy_flag',
            'markenting_flag' => 'markenting_flag'
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all contactforms');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own contactforms');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all contactforms');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own contactforms');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all contactforms');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own contactforms');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.contactforms';

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
                    'data' => 'from_email', 'className' => 'dt_col_from_email', 'label' => 'From email',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'company', 'className' => 'dt_col_from_email', 'label' => 'Azienda',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'phone', 'className' => 'dt_col_from_phone', 'label' => 'Cellulare',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'created_at', 'className' => 'dt_col_from_created_at', 'label' => 'Data',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'markenting_flag', 'className' => 'dt_col_from_markenting_flag', 'label' => 'Marketing',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'privacy_flag', 'className' => 'dt_col_from_privacy_flag', 'label' => 'Privacy',
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
            'order' => [ ['from_email', 'asc'] ],
            'pageLength' => 25
        ];
    }

}