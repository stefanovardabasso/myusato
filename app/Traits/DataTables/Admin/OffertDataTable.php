<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Offert;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait OffertDataTable
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
            'date_finish_off ' => 'date_finish_off',
            'target_user' => 'target_user',
            'type_off' => 'type_off',
            'list_price_uf' => 'list_price_uf',
            'list_price_co' => 'list_price_co',
            'id_product ' => 'id_product',
            'desc_it_uf' => 'desc_it_uf',
            'desc_it_co' => 'desc_it_co'
        ])->where('type_off','=','Bundle');

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

        $table->filterColumn('target_user', function ($query, $keyword) {
            $offerts = null;
            if($keyword == 1){
                $offerts = Offert::query()->where('target_user','=','1')->get();

                if($offerts){

                    $query->where('target_user','=','1');
                }
            }elseif($keyword == 2){
                $offerts = Offert::query()->where('target_user','=','2')->get();

                if($offerts){

                            $query->where('target_user','=','2');
                }
            }elseif($keyword == 3){
                $query->where('target_user','!=','0');
            }


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

        $table->editColumn('target_user', function ($row) {
            if($row->target_user == '1'){
                return 'UTILIZZATORE FINALE';
            }elseif($row->target_user == '2'){
                return 'COMMERCIANTE';
            }
        });

        $table->editColumn('list_price_co', function ($row) {
            if($row->target_user == '1'){
                return '-';
            }elseif($row->target_user == '2'){
                return $row->list_price_co;
            }
        });

        $table->editColumn('list_price_uf', function ($row) {
            if($row->target_user == '1'){
                return $row->list_price_uf;
            }elseif($row->target_user == '2'){
                return '-';
            }
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
    public static function getSelectsFilterTargetUser(): array
    {
        $targetuser = DB::table('target_offert')->get(); //Filter::get(['filters.name as label', 'filters.name as value']);
        // $states = self::dataTableBuildSelectFilter(self::getEnumsTrans('filter'));
        return [
            //'states' => $states,
            'targetuser' => $targetuser,
        ];
    }
    public static function getDataTableObject($tableId, $route)
    {

        $targetuser = self::getSelectsFilterTargetUser();
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
                    'data' => 'date_finish_off', 'className' => 'dt_col_date_finish_off', 'label' => __('Data fine offerta'),
                    'filter' => [ 'type' => "search" ]
                ],

                [
                    'data' => 'target_user', 'className' => 'dt_col_target_user', 'label' => __('Listino Myusato'),
                    'filter' => [
                    'type' => "select",
                    'options' => $targetuser['targetuser']
                                 ],
                ],
                [
                    'data' => 'list_price_uf', 'className' => 'dt_col_list_price_uf', 'label' => __('Prezzo UF'),
                    'filter' => [ 'type' => "search" ]
                ],

                [
                    'data' => 'list_price_co', 'className' => 'dt_col_list_price_co', 'label' => __('Prezzo CO'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'desc_it_uf', 'className' => 'dt_col_desc_it_uf', 'label' => __('Desc. UF'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'desc_it_co', 'className' => 'dt_col_desc_it_co', 'label' => __('Desc. CO'),
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
            'order' => [ [1, 'asc'] ],
            'pageLength' => 25
        ];
    }

}
