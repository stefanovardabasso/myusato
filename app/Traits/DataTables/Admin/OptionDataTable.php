<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Offert;
use App\Models\Admin\Option;
use App\Models\Admin\User;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait OptionDataTable
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
            'id'    => 'options.id as id',
            'user_id' => 'options.user_id as user_id',
            'status' => 'options.status',
            'offer_id' => 'options.offer_id as offer_id',
            'target_user' =>'offerts.target_user as target_user',
            'type_off' => 'offerts.type_off as type_off',
            'productbrand'=>'products.brand as productbrand',
            'productmodel'=>'products.model as productmodel',
            'productcategory'=>'products.category as productcategory',
            'producttype'=>'products.types as producttype',
            'productclass'=>'products.class as productclass',
            'procutpartita' => 'products.partita as procutpartita'
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {
        $query->leftjoin('offerts','options.offer_id','=','offerts.id')
        ->where('offerts.status','=',1)
        ->leftjoin('products','offerts.id_product','=','products.id');
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


            if($keyword == 1 ||$keyword == 2){
                $query->where('offerts.target_user','=',$keyword);

            }elseif($keyword == 3){
                $query->where('options.id','!=',0);
            }


        });
        $table->filterColumn('user_id', function ($query, $keyword) {

            $users = User::query()->where('email','LIKE', '%' . $keyword . '%')->get();

            if($users){
                $a=0;
                foreach ($users as $user){
                    if($a == 0){
                        $query->where('options.user_id','=',$user->id);
                    }else{
                        $query->orWhere('options.user_id','=',$user->id);
                    }
                }
            }


        });
        $table->filterColumn('productbrand', function ($query, $keyword) {

            $query->where('products.brand','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('productmodel', function ($query, $keyword) {

            $query->where('products.model','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('productclass', function ($query, $keyword) {

            $query->where('products.class','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('productcategory', function ($query, $keyword) {

            $query->where('products.category','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('producttype', function ($query, $keyword) {

            $query->where('products.types','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('procutpartita', function ($query, $keyword) {

            $query->where('products.partita','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('type_off', function ($query, $keyword) {

            $query->where('offerts.type_off','LIKE','%'.$keyword.'%');

        });
        $table->filterColumn('status', function ($query, $keyword) {

            if(strtolower($keyword) === 'attiva'){
                $query->where('options.status','=','0');
            }elseif (strtolower($keyword) === 'scaduta'){
                $query->where('options.status','=','1');
            }elseif (strtolower($keyword) ===  'assegnata'){
                $query->where('options.status','=','3');
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all options');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own options');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all options');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own options');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all options');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own options');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.options';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        $table->editColumn('user_id', function ($row) {
            $user = User::query()->where('id','=',$row->user_id)->first();

            return $user->email;
        });

        $table->editColumn('status', function ($row) {

            if($row->status == 0) {
                return 'Attiva';
            }elseif($row->status == 1){
                return 'Scaduta';
            }elseif($row->status == 3){
                return 'Assegnata';
            }


        });

        $table->addColumn('target_user', function ($row) {
            if($row->target_user == '1'){
                return 'UTILIZZATORE FINALE';
            }elseif($row->target_user == '2'){
                return 'COMMERCIANTE';
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
    public static function getSelectsFilterTargetUser(): array
    {
        $targetuser = DB::table('target_offert')->get(); //Filter::get(['filters.name as label', 'filters.name as value']);
        // $states = self::dataTableBuildSelectFilter(self::getEnumsTrans('filter'));
        return [
            //'states' => $states,
            'targetuser' => $targetuser,
        ];
    }
    /**
     * @param $tableId
     * @param $route
     * @return array
     */
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
                    'data' => 'user_id', 'className' => 'dt_col_user_id', 'label' => __('User'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'status', 'className' => 'dt_col_status', 'label' => __('Status'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'target_user', 'className' => 'dt_col_target_user', 'label' => 'Listino MyUsato',
                    'filter' => [
                        'type' => "select",
                        'options' => $targetuser['targetuser']
                    ],
                ],
                [
                    'data' => 'type_off', 'className' => 'dt_col_type_off', 'label' => __('Tipo Offerta'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'productbrand', 'className' => 'dt_col_productbrand', 'label' => __('Marca'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'productmodel', 'className' => 'dt_col_productmodel', 'label' => __('Model'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'productcategory', 'className' => 'dt_col_productcategory', 'label' => __('Category'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'producttype', 'className' => 'dt_col_producttype', 'label' => __('Tipo'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'productclass', 'className' => 'dt_col_productclass', 'label' => __('Class'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'procutpartita', 'className' => 'dt_col_procutpartita', 'label' => __('Partita'),
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
