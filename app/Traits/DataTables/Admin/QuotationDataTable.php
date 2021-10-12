<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\User;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;

trait QuotationDataTable
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
            'id_user' => 'id_user',
            'title' => 'title',
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
        $query->orderBy('id','desc');
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all quotations');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own quotations');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all quotations');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own quotations');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all quotations');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own quotations');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.quotations';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        $table->addColumn('id_user', function ($row) {
            $user = User::query()->where('id','=',$row->id_user)->first();

            return $user->email;
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
                    'data' => 'id_user', 'className' => 'dt_col_id_user', 'label' =>  __('Utente'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'title', 'className' => 'dt_col_title', 'label' => __('Titolo'),
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
            'order' => [ ['id_user', 'asc'] ],
            'pageLength' => 25
        ];
    }

}
