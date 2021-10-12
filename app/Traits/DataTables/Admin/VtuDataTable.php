<?php

namespace App\Traits\DataTables\Admin;

use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;

trait VtuDataTable
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
            'email' => 'email',
            'name' => 'name',
            'surname' => 'surname',
            'company' => 'company',
            'brand' => 'brand',
            'model' => 'model'
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all vtus');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own vtus');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all vtus');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own vtus');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all vtus');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own vtus');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.vtus';

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
                    'data' => 'email', 'className' => 'dt_col_email', 'label' => __('Email'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'name', 'className' => 'dt_col_name', 'label' => __('Nome'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'surname', 'className' => 'dt_col_surname', 'label' => __('Cognome'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'company', 'className' => 'dt_col_company', 'label' => __('Azienda'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'brand', 'className' => 'dt_col_brand', 'label' => __('Marca'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'model', 'className' => 'dt_col_model', 'label' => __('Model'),
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
