<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Report;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait RoleDataTable
{
    use DataTable;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        $query->where('roles_trans.locale', app()->getLocale());
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSelectRows($query)
    {
        return $query->select([
            'id'    => 'roles.id as id',
            'name'  => 'roles_trans.role_name as name',
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
        $table->filterColumn('name', function ($query, $keyword) {
            return $query->where('roles_trans.role_name', 'like', DB::raw("'%$keyword%'"));
        });

        return $table;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableEditColumns($table)
    {
        self::dataTableSetRawColumns($table);

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all roles');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own roles');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all roles');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own roles');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all roles');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own roles');

        $table->addColumn('actions', '&nbsp;');
        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.roles';

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
                    'raw'   => true
                ],
                [
                    'data' => 'name', 'className' => 'dt_col_name', 'label' => self::getAttrsTrans('name'),
                    'filter' => [ 'type' => "search" ],
                    'raw'   => true
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
            'order' => [ ['name', 'asc'] ],
            'pageLength' => 25
        ];
    }
}
