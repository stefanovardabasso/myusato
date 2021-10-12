<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\User;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

trait SavedfilterDataTable
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
            'created_at' => 'created_at'
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all savedfilters');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own savedfilters');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all savedfilters');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own savedfilters');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all savedfilters');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own savedfilters');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.savedfilters';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        $table->editColumn('id_user', function ($row) {
            $user = User::query()->where('id','=',$row->id_user)->first();
            if($user){
                return $user->email;
            }else{
                 return 'Utente eliminato';
            }
        });


        $table->editColumn('created_at', function ($row) {
            $date =  Carbon::parse($row->created_at)->format('d/m/Y');

            return $date;
        });

        $table->addColumn('name', function ($row) {
            $user = User::query()->where('id','=',$row->id_user)->first();
            if($user){
                return $user->name;
            }else{
                return '***';
            }
        });

        $table->addColumn('surname', function ($row) {
            $user = User::query()->where('id','=',$row->id_user)->first();
            if($user){
                return $user->surname;
            }else{
                return '***';
            }
        });
        $table->addColumn('role', function ($row) {

                return '***';

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
                    'data' => 'id_user', 'className' => 'dt_col_id_user', 'label' => __('Utente'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'name', 'className' => 'dt_col_name', 'label' => __('Nome'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'surname', 'className' => 'dt_col_id_user', 'label' => __('Cognome'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'role', 'className' => 'dt_col_role', 'label' => __('Role'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'created_at', 'className' => 'dt_col_created_at', 'label' => __('Data'),
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
