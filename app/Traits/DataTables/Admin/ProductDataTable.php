<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Component;
use App\Models\Admin\Offert;
use App\Models\Admin\Product;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait ProductDataTable
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
            'id'    => 'products.id',
            'types' => 'products.types',
            'category' => 'products.category',
            'class' => 'products.class',
            'subclass' => 'products.subclass',
            'brand' => 'products.brand',
            'model' => 'products.model',
            'year' => 'products.year',
            'serialnum' => 'products.serialnum',
            'location' => 'products.location',
            'macchinallestita' => 'products.macchinallestita',
            'typeallestimento' => 'products.typeallestimento',
            'totalecostoallestimenti'=>'products.totalecostoallestimenti',
            'noleggiata' => 'products.noleggiata',
            'venduta' => 'products.venduta',
            'opzionata' => 'products.opzionata',
            'prenotata' => 'products.prenotata',
            'riferimento_cls' => 'products.riferimento_cls',
            'fornitore' => 'products.fornitore',
            'data_em' => 'products.data_em',
            'partita' => 'products.partita',
            'created_at' => 'products.created_at',
            'scheda' => 'products.scheda as scheda',
            'stima_rtc'=> 'offerts.price_rtc_uf as stima_rtc',
            'pagato_cliente' => 'products.pagato_cliente',
            'overallowance' => 'products.overallowance',
            'trasporto' => 'offerts.cost_trasp_uf as trasporto',
            'price_uf' => 'offerts.list_price_uf as price_uf',
            'price_co' => 'offerts.list_price_co as price_co',
            'target_user' => 'offerts.target_user as target_user',
//            'date_finish_off_myusato' => 'offerts.date_finish_off as date_finish_off_myusato'


        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {
       $query->leftjoin('offerts','products.id','=','offerts.id_product')
           ->where('offerts.status','=',1)
           ->orWhereNull('offerts.status')
           ->where('offerts.type_off','=','single')
           ->orWhereNull('offerts.type_off');//->where('offerts.type_off','=','single');


        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableGroupBy($query)
    {
        $query->groupby('products.id');
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableFilterColumns($table)
    {
        $table->filterColumn('free', function ($query, $keyword) {
            $products = null;
                if($keyword == 'SI' | $keyword == 'Si' | $keyword == 'si' | $keyword == 'sI' | $keyword == 'S' | $keyword == 's' ){
                      $products = Product::query()
                          ->where('noleggiata','!=','X')
                          ->where('venduta','!=','X')
                          ->where('opzionata','!=','X')
                          ->get();
                }elseif($keyword == 'NO' | $keyword == 'No' | $keyword == 'no' | $keyword == 'nO' | $keyword == 'N' | $keyword == 'n' ){
                    $products = Product::query()
                        ->where('noleggiata','=','X')
                        ->orWhere('venduta','=','X')
                        ->orWhere('opzionata','=','X')
                        ->get();
                }

                if($products){
                    $a=0;
                    foreach ($products as $p){
                        if($a==0){
                            $query->where('products.id','=',$p->id);
                        }else{
                            $query->orWhere('products.id','=',$p->id);
                        }
                        $a++;
                    }
                }

        });



        $table->filterColumn('target_user', function ($query, $keyword) {

            $offerts = null;
            if($keyword == 1){
                $offerts = Offert::query()->where('offerts.target_user','=','1')->get();
                $a=0;
                if($offerts){
                    foreach ($offerts as $of){
                        if($a==0){
                            $query->where('products.id','=',$of->id_product);
                        }else{
                            $query->orWhere('products.id','=',$of->id_product);
                        }

                        $a++;

                    }
                }
            }elseif($keyword == 2){
                $offerts = Offert::query()->where('offerts.target_user','=','2')->get();
                $a=0;
                if($offerts){
                    foreach ($offerts as $of){
                        if($a==0){
                            $query->where('products.id','=',$of->id_product);
                        }else{
                            $query->orWhere('products.id','=',$of->id_product);
                        }

                        $a++;

                    }
                }
            }elseif($keyword == 3){
                $query->where('products.id','!=',0);
            }


        });

        $table->filterColumn('stima_rtc', function ($query, $keyword) {

            $offerts = Offert::query()->where('price_rtc_uf','=',$keyword)->get();

            if($offerts){
                $i=0;
                foreach($offerts as $of){
                    if($i==0){
                         $query->where('products.id','=',$of->id_product);
                    }else{
                         $query->orWhere('products.id','=',$of->id_product);
                    }
                    $i++;

                }
            }
        });

        $table->filterColumn('ol_di_allestimento', function ($query, $keyword) {

            $components = Component::get();
          if($components){
              $a=0;
              foreach ($components as $comp){
                  $sumas = Component::query()->where('offert_id','=', $comp->offert_id)->sum('value');
                  if($sumas){

                          if($sumas == $keyword){
                              $offert = Offert::query()->where('id','=',$comp->offert_id)->first();
                              if($a==0){
                                  $query->where('products.id','=',$offert->id_product);
                              }else{
                                  $query->orWhere('products.id','=',$offert->id_product);
                              }
                              $a++;

                      }
                  }

              }



          }

        });

        $table->filterColumn('trasporto', function ($query, $keyword) {

            $offerts = Offert::where('cost_trasp_uf','=',$keyword)->orWhere('cost_trasp_co','=',$keyword)->get();
            if($offerts) {
                $i=0;
                foreach ($offerts as $of) {
                    if($i==0){
                        $query->where('products.id','=',$of->id_product);
                    }else{
                        $query->orWhere('products.id','=',$of->id_product);
                    }
                    $i++;
                }
            }

        });

        $table->filterColumn('price_uf', function ($query, $keyword) {

            $offerts = Offert::where('list_price_uf','=',$keyword)->get();
            if($offerts) {
                $i=0;
                foreach ($offerts as $of) {
                    if($i==0){
                        $query->where('products.id','=',$of->id_product);
                    }else{
                        $query->orWhere('products.id','=',$of->id_product);
                    }
                    $i++;
                }
            }

        });

        $table->filterColumn('price_co', function ($query, $keyword) {

            $offerts = Offert::where('list_price_co','=',$keyword)->get();
            if($offerts) {
                $i=0;
                foreach ($offerts as $of) {
                    if($i==0){
                        $query->where('products.id','=',$of->id_product);
                    }else{
                        $query->orWhere('products.id','=',$of->id_product);
                    }
                    $i++;
                }
            }

        });

        $table->filterColumn('offertas', function ($query, $keyword) {

            $products = Product::get();
            $a = 0;
            if($keyword = 'SI' | $keyword = 'si' | $keyword= 's' | $keyword = 'S' | $keyword= 'i' | $keyword = 'I'){

                foreach ($products as $p){

                    $off = Offert::query()->where('id_product','=',$p->id)->first();
                    if($off){
                        if($a==0){
                            $query->where('products.id','=',$off->id_product);
                        }else{
                            $query->orWhere('products.id','=',$off->id_product);
                        }
                        $a++;
                    }

                }

            }elseif($keyword = 'NO' | $keyword = 'no' | $keyword= 'n' | $keyword = 'N' | $keyword= 'o' | $keyword = 'O'){

                foreach ($products as $p){

                    $off = Offert::query()->where('id_product','=',$p->id)->first();
                    if(!$off){
                        if($a==0){
                            $query->where('products.id','=',$p->id);
                        }else{
                            $query->orWhere('products.id','=',$p->id);
                        }
                        $a++;
                    }

                }

            }else{
                $query->where('products.id','<',0);
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all products');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own products');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all products');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own products');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all products');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own products');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.products';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });


        $table->addColumn('free', function ($row) {
            if($row->noleggiata == null & $row->venduta == null & $row->opzionata == null & $row->prenotata == null){
                return 'SI';
            }else{
                return 'NO';
            }
        });





        $table->addColumn('ol_di_allestimento', function ($row) {
             $offert = Offert::query()->where('id_product','=', $row->id)->first();
             if($offert){
                 if($offert->target_user == '1'){
                     $total = Component::query()->where('offert_id','=',$offert->id)
                         ->where('offert_type','=','UF')->sum('value');
                 }else{
                     $total = Component::query()->where('offert_id','=',$offert->id)
                         ->where('offert_type','=','CO')->sum('value');
                 }
                 return $total;
             }else{
                 return '';
             }


        });

        $table->addColumn('target_user', function ($row) {
            if($row->target_user == '1'){
                return 'UTILIZZATORE FINALE';
            }elseif($row->target_user == '2'){
                return 'COMMERCIANTE';
            }
        });
        $table->addColumn('free', function ($row) {
            if($row->noleggiata == null & $row->venduta == null & $row->opzionata == null & $row->prenotata == null){
                return 'SI';
            }else{
                return 'NO';
            }
        });

        $table->addColumn('offertas', function ($row) {
            if($row->price_uf != null |  $row->price_uf != null){
                return 'SI';
            }else{
                return 'NO';
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
                    'data' => 'partita', 'className' => 'dt_col_partita', 'label' => 'Partita',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'scheda', 'className' => 'dt_col_scheda', 'label' => 'RTC',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'offertas', 'className' => 'dt_col_offertas', 'label' => 'Offert',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'brand', 'className' => 'dt_col_brand', 'label' => 'Marca',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'model', 'className' => 'dt_col_model', 'label' => 'Modello',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'serialnum', 'className' => 'dt_col_serialnum', 'label' => 'N.serie',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'year', 'className' => 'dt_col_year', 'label' => 'Anno',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'category', 'className' => 'dt_col_category', 'label' => 'Categoria',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'types', 'className' => 'dt_col_type', 'label' => 'Tipo',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'class', 'className' => 'dt_col_class', 'label' => 'Classe',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'subclass', 'className' => 'dt_col_subclass', 'label' => 'Sottoclasse',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'location', 'className' => 'dt_col_location', 'label' => 'Ubicazione',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'typeallestimento', 'className' => 'dt_col_typeallestimento', 'label' => 'Tipo Allestimento',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'macchinallestita', 'className' => 'dt_col_macchinallestita', 'label' => 'Stato Allestimento',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'totalecostoallestimenti', 'className' => 'dt_col_totalecostoallestimenti', 'label' => 'Ol costi definitivi',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'ol_di_allestimento', 'className' => 'dt_col_ol_di_allestimento', 'label' => 'Ol di allestimento',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'free', 'className' => 'dt_col_free', 'label' => 'Libera',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'prenotata', 'className' => 'dt_col_prenotata', 'label' => 'Prenotata',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'venduta', 'className' => 'dt_col_venduta', 'label' => 'Venduta',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'noleggiata', 'className' => 'dt_col_noleggiata', 'label' => 'Noleggiata',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'opzionata', 'className' => 'dt_col_opzionata', 'label' => 'Opzionata',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'riferimento_cls', 'className' => 'dt_col_riferimento_cls', 'label' => 'Riferimento CLS',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'fornitore', 'className' => 'dt_col_fornitore', 'label' => 'Fornitore ODA',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'data_em', 'className' => 'dt_col_data_em', 'label' => 'Data entrata merce ODA',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'stima_rtc', 'className' => 'dt_col_stima_rtc', 'label' => 'Stima RTC',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'pagato_cliente', 'className' => 'dt_col_pagato_cliente', 'label' => 'Pagato a cliente',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'overallowance', 'className' => 'dt_col_overallowance', 'label' => 'Over allowance',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'trasporto', 'className' => 'dt_col_trasporto ', 'label' => 'Trasporto',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'price_uf', 'className' => 'dt_col_price_uf', 'label' => 'Prezzo UF',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'price_co', 'className' => 'dt_col_price_co', 'label' => 'Prezzo CO',
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'target_user', 'className' => 'dt_col_target_user', 'label' => 'Listino MyUsato',
                    'filter' => [
                        'type' => "select",
                        'options' => $targetuser['targetuser']
                    ],
                ],
//                [
//                    'data' => 'date_finish_off_myusato', 'className' => 'dt_col_date_finish_off_myusato', 'label' => 'SCADENZA MyUsato',
//                    'filter' => [ 'type' => "search" ]
//                ],


            ],
            'ajax' => [
                'url' => $route,
                'method' => 'POST',
                'data' => [
                    '_token' => csrf_token(),
                    'roles' => []
                ],
            ],
            'order' => [ ['brand', 'ASC'] ],
            'pageLength' => 25
        ];
    }

}
