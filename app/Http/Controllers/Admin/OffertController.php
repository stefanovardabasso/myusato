<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MacuController;
use App\Http\Controllers\Admin\TuttocarrelliController;
use App\Http\Controllers\Admin\SuprliftController;
use App\Models\Admin\Component;
use App\Models\Admin\Galrtc;
use App\Models\Admin\Macu;
use App\Models\Admin\Offert;
use App\Http\Requests\Admin\StoreOffertRequest;
use App\Http\Requests\Admin\UpdateOffertRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Products_line;
use App\Models\Admin\Revision;
//use http\Env\Request;
use App\Models\Admin\Suprlift;
use App\Models\Admin\Tuttocarrelli;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Admin\Relation_offert_product;
use App\Models\Admin\Product;
use App\Models\Admin\Gallery;
use Auth;
use GuzzleHttp\Client;
use SimpleXMLElement;
use DOMDocument;
use DOMAttr;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;


class OffertController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Offert::class);

        $dataTableObject = Offert::getDataTableObject('offertDataTable', route('admin.datatables.offerts'));

        return view('admin.offerts.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {
        $this->authorize('create', Offert::class);

        $offert = Offert::class;

        $product = Product::query()->where('id',$request->get('product'))->first();
        $rtc_valu = 0;
        if($product->scheda != 0 & $product->scheda != 1){
            $c  = new Client();
            $response1 = $c ->request('GET', 'http://rtc.cls.it/api/getstimartc/'.$product->scheda);
            $datac = json_decode($response1->getBody(), true);
            $rtc_valu = $datac['valu'];
        }



        $offert = new Offert();
        $offert->createdby = Auth()->user()->id;
        $offert->id_product = $request->get('product');
        $offert->type_off = 'single';
        $offert->status = 0;

        $offert->price_rtc_co = $rtc_valu;
        $offert->payed_client_co = $product->pagato_cliente;
        $offert->ol_def_co = $product->totalecostoallestimenti;
        $offert->over_allowance_co = $product->overallowance;
        $offert->gp_ob_co = 20;
        $offert->disc_ob_co = 10;

        $offert->price_rtc_uf = $rtc_valu;
        $offert->payed_client_uf = $product->pagato_cliente;
        $offert->ol_def_uf = $product->totalecostoallestimenti;
        $offert->over_allowance_uf = $product->overallowance;
        $offert->gp_ob_uf = 30;
        $offert->disc_ob_uf = 10;

        $offert->save();

        $record = new Relation_offert_product();
        $record->idproduct = $offert->id_product;
        $record->idoffert = $offert->id;
        $record->created_by= Auth()->user()->id;
        $record->save();



        $rtc_img = Galrtc::query()->where('product_id','=',$product->id)->get();

             foreach ($rtc_img as $rtc){

                 $tt  = $rtc->image;
                 $pieces = explode("http://rtc.cls.it/upload/", $tt);

                 //resize_image('upload/rtc-'.$pieces[1], 500, 400);

                 $img_co = new Gallery();
                 $img_co->offert_id = $offert->id;
                 $img_co->name = 'rtc-'.$pieces[1];
                 $img_co->type = 'CO';
                 $img_co->position = 2;
                 $img_co->save();

                 $img_uf = new Gallery();
                 $img_uf->offert_id = $offert->id;
                 $img_uf->name = 'rtc-'.$pieces[1];
                 $img_uf->type = 'UF';
                 $img_uf->position = 2;
                 $img_uf->save();
             }


        return redirect()->route('admin.offerts.edit', [$offert])
            ->with('success', Offert::getMsgTrans('created'));
    }

    /**
     * @param StoreOffertRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreOffertRequest $request)
    {
        $this->authorize('create', Offert::class);

        $offert = Offert::create();

        $record = new Relation_offert_product();
        $record->idproduct = $offert->id_product;
        $record->idoffert = $offert->id;
        $record->created_by= 'TU';
        $record->save();


        return redirect()->route('admin.offerts.edit', [$offert])
            ->with('success', Offert::getMsgTrans('created'));
    }

    /**
     * @param Offert $offert
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Offert $offert)
    {
        $this->authorize('view', $offert);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($offert), 'model_id' => $offert->id]));

        return view('admin.offerts.show', [
            'offert' => $offert,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Offert $offert
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Offert $offert)
    {
        //$other_off = Offert::where('type_off','=','single')->()->first();


        $this->authorize('update', $offert);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        $offert = Offert::where('id',$offert->id)->first();
        $gallery = Gallery::where('offert_id', '=', $offert->id)->orderBy('position')->get();
        $relation_off =  Relation_offert_product::where('idoffert', '=', $offert->id)->get();

       $macus=[];
       $supra=[];
       $tuttocar=[];
        if(count($relation_off) == 1) {

            $prod = Product::query()->where('id','=',$offert->id_product)->first();

            if($prod->macchinallestita == 'D'){
                $target = 2;
            }else{
                $target = 1;
            }



            $macus = Macu::query()
                ->where('offert_id', '=', $offert->id)
                ->where('action', '!=', 0)->where('target_user','=',$target)->first();

            $supra = Suprlift::query()
                ->where('offert_id', '=', $offert->id)
                ->where('action', '!=', 0)->where('target_user','=',$target)->first();

            $tuttocar = Tuttocarrelli::query()
                ->where('offert_id', '=', $offert->id)
                ->where('action', '!=', 0)->where('target_user','=',$target)->first();
        }


        if(count($relation_off) >0) {
            $i = 0;
            foreach ($relation_off as $key) {

                $products[$i] = Product::where('id', '=', $key->idproduct)->first();
                $relation_offs[$products[$i]->id] = $key->id;
                $i++;

            }
        }else{
            $relation_off = null;
            $products = null;
        }
        $prods =  Product::get();
        //print_r($offert->id);
         return view('admin.offerts.edit', compact('offert','relation_offs','products','prods', 'gallery','macus','supra','tuttocar'));
    }

    /**
     * @param UpdateOffertRequest $request
     * @param Offert $offert
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Offert $offert)
    {
        $this->authorize('update', $offert);

        if($request->get('target_user') == null){

            return redirect()->route('admin.offerts.edit', [$offert])
                ->with('error', __('Errore: devi scegliere a quale tipo di utente è rivolta questa offerta'));

        }else{

            if($request->get('title_1_co')!=null){  $offert->title_1_co = $request->get('title_1_co'); }
            if($request->get('title_2_co')!=null){  $offert->title_2_co = $request->get('title_2_co'); }
            if($request->get('title_3_co')!=null){  $offert->title_3_co = $request->get('title_3_co'); }
            if($request->get('desc_it_co')!=null){  $offert->desc_it_co = $request->get('desc_it_co'); }
            if($request->get('desc_en_co')!=null){  $offert->desc_en_co = $request->get('desc_en_co'); }
            if($request->get('cost_trasp_co')!=null){  $offert->cost_trasp_co = $request->get('cost_trasp_co'); }
            if($request->get('price_rtc_co')!=null){  $offert->price_rtc_co = $request->get('price_rtc_co'); }
            if($request->get('ol_prevision_co')!=null){  $offert->ol_prevision_co = $request->get('ol_prevision_co'); }
            if($request->get('payed_client_co')!=null){  $offert->payed_client_co = $request->get('payed_client_co'); }
            if($request->get('ol_def_co')!=null){  $offert->ol_def_co = $request->get('ol_def_co'); }
            if($request->get('over_allowance_co')!=null){  $offert->over_allowance_co = $request->get('over_allowance_co'); }
            if($request->get('value_tt_co')!=null){  $offert->value_tt_co = $request->get('value_tt_co'); }
            if($request->get('gp_ob_co')!=null){  $offert->gp_ob_co = $request->get('gp_ob_co'); }
            if($request->get('disc_ob_co')!=null){  $offert->disc_ob_co = $request->get('disc_ob_co'); }
            if($request->get('calculated_price_co')!=null){  $offert->calculated_price_co = $request->get('calculated_price_co'); }
            if($request->get('min_price_co')!=null){  $offert->min_price_co = $request->get('min_price_co'); }
            if($request->get('gp_effective_co')!=null){  $offert->gp_effective_co = $request->get('gp_effective_co'); }
            if($request->get('list_price_co')!=null){  $offert->list_price_co = $request->get('list_price_co'); }
            if($request->get('new_list_price_co')!=null){  $offert->new_list_price_co = $request->get('new_list_price_co'); }else{ $offert->new_list_price_co = null; }

            if($request->get('title_1_uf')!=null){  $offert->title_1_uf = $request->get('title_1_uf'); }
            if($request->get('title_2_uf')!=null){  $offert->title_2_uf = $request->get('title_2_uf'); }
            if($request->get('title_3_uf')!=null){  $offert->title_3_uf = $request->get('title_3_uf'); }
            if($request->get('desc_it_uf')!=null){  $offert->desc_it_uf = $request->get('desc_it_uf'); }
            if($request->get('desc_en_uf')!=null){  $offert->desc_en_uf = $request->get('desc_en_uf'); }
            if($request->get('cost_trasp_uf')!=null){  $offert->cost_trasp_uf = $request->get('cost_trasp_uf'); }
            if($request->get('price_rtc_uf')!=null){  $offert->price_rtc_uf = $request->get('price_rtc_uf'); }
            if($request->get('ol_prevision_uf')!=null){  $offert->ol_prevision_uf = $request->get('ol_prevision_uf'); }
            if($request->get('payed_client_uf')!=null){  $offert->payed_client_uf = $request->get('payed_client_uf'); }
            if($request->get('ol_def_uf')!=null){  $offert->ol_def_uf = $request->get('ol_def_uf'); }
            if($request->get('over_allowance_uf')!=null){  $offert->over_allowance_uf = $request->get('over_allowance_uf'); }
            if($request->get('value_tt_uf')!=null){  $offert->value_tt_uf = $request->get('value_tt_uf'); }
            if($request->get('gp_ob_uf')!=null){  $offert->gp_ob_uf = $request->get('gp_ob_uf'); }
            if($request->get('disc_ob_uf')!=null){  $offert->disc_ob_uf = $request->get('disc_ob_uf'); }
            if($request->get('calculated_price_uf')!=null){  $offert->calculated_price_uf = $request->get('calculated_price_uf'); }
            if($request->get('min_price_uf')!=null){  $offert->min_price_uf = $request->get('min_price_uf'); }
            if($request->get('gp_effective_uf')!=null){  $offert->gp_effective_uf = $request->get('gp_effective_uf'); }
            if($request->get('list_price_uf')!=null){  $offert->list_price_uf = $request->get('list_price_uf'); }
            if($request->get('new_list_price_uf')!=null){  $offert->new_list_price_uf = $request->get('new_list_price_uf'); }else{ $offert->new_list_price_uf = null; }



            if($request->get('date_finish_off')!=null){  $offert->date_finish_off = $request->get('date_finish_off'); }
            if($request->get('target_user')!=null){  $offert->target_user = $request->get('target_user'); }
            $offert->update();

        }




        //$offert->update($request->validated());

        return redirect()->route('admin.offerts.edit', [$offert])
            ->with('success', Offert::getMsgTrans('updated'));
    }

    /**
     * @param Offert $offert
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Offert $offert)
    {
        $this->authorize('delete', $offert);

        $offert->delete();

        return redirect()->route('admin.offerts.index')
            ->with('success', Offert::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Offert::class);

        $query = Offert::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Offert::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Offert::dataTableEditColumns($table);

            return $table->make(true);
        }

        Offert::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function addtooffert(Request $request,$id_offert)
    {


        $relationes = Relation_offert_product::query()->where('idoffert','=',$id_offert)->count();



        if($relationes == 1){

            $record = new Relation_offert_product();
            $record->idproduct =  $request->get('macchina');
            $record->idoffert = $id_offert;
            $record->created_by = Auth()->user()->id;
            $record->save();

            $old_of = Offert::query()->where('id_product','=',$request->get('macchina'))->first();

            $offert = Offert::where('id', '=', $id_offert)->first();

            $newval_cost_trasp_uf = $offert->cost_trasp_uf + $old_of->cost_trasp_uf;
            $newval_price_rtc_uf = $offert->price_rtc_uf + $old_of->price_rtc_uf;

            if($offert->ol_def_uf != null & $old_of->ol_def_uf != null){

                $newval_ol_def_uf = $offert->ol_def_uf + $old_of->ol_def_uf;

            }elseif($offert->ol_def_uf != null  & $old_of->ol_def_uf == null){

                $newval_ol_def_uf = $offert->ol_def_uf + $old_of->ol_prevision_uf;

            }elseif($offert->ol_def_uf == null  & $old_of->ol_def_uf != null){

                $newval_ol_def_uf = $offert->ol_prevision_uf + $old_of->ol_def_uf;

            }elseif($offert->ol_def_uf == null  & $old_of->ol_def_uf == null){

                $newval_ol_def_uf = $offert->ol_prevision_uf + $old_of->ol_prevision_uf;
            }

            $newval_payed_client_uf = $offert->payed_client_uf + $old_of->payed_client_uf;
            $newval_over_allowance_uf = $offert->over_allowance_uf + $old_of->over_allowance_uf;
            $newval_value_tt_uf = $offert->value_tt_uf + $old_of->value_tt_uf;
            $newval_gp_ob_uf = ($offert->gp_ob_uf + $old_of->gp_ob_uf)/2;
            $newval_disc_ob_uf = ($offert->disc_ob_uf + $old_of->disc_ob_uf)/2;
            $newval_calculated_price_uf = $offert->calculated_price_uf + $old_of->calculated_price_uf;
            $newval_min_price_uf = $offert->min_price_uf + $old_of->min_price_uf;
            $newval_list_price_uf = $offert->list_price_uf + $old_of->list_price_uf;
            $newval_new_list_price_uf = $offert->new_list_price_uf + $old_of->new_list_price_uf;

            $offert->cost_trasp_uf = $newval_cost_trasp_uf;
            $offert->price_rtc_uf = $newval_price_rtc_uf;
            $offert->ol_def_uf = $newval_ol_def_uf;
            $offert->payed_client_uf = $newval_payed_client_uf;
            $offert->over_allowance_uf = $newval_over_allowance_uf;
            $offert->value_tt_uf = $newval_value_tt_uf;
            $offert->gp_ob_uf = $newval_gp_ob_uf;
            $offert->disc_ob_uf = $newval_disc_ob_uf;
            $offert->calculated_price_uf = $newval_calculated_price_uf;
            $offert->min_price_uf = $newval_min_price_uf;
            $offert->list_price_uf = $newval_list_price_uf;
            $offert->list_price_uf = $newval_new_list_price_uf;

            $newval_cost_trasp_co = $offert->cost_trasp_co + $old_of->cost_trasp_co;
            $newval_price_rtc_co = $offert->price_rtc_co + $old_of->price_rtc_co;

            if($offert->ol_def_co != null & $old_of->ol_def_co != null){

                $newval_ol_def_co = $offert->ol_def_co + $old_of->ol_def_co;

            }elseif($offert->ol_def_co != null  & $old_of->ol_def_co == null){

                $newval_ol_def_co = $offert->ol_def_co + $old_of->ol_prevision_co;

            }elseif($offert->ol_def_co == null  & $old_of->ol_def_co != null){

                $newval_ol_def_co = $offert->ol_prevision_co + $old_of->ol_def_co;

            }elseif($offert->ol_def_co == null  & $old_of->ol_def_co == null){

                $newval_ol_def_co = $offert->ol_prevision_co + $old_of->ol_prevision_co;
            }

            $newval_payed_client_co = $offert->payed_client_co + $old_of->payed_client_co;
            $newval_over_allowance_co = $offert->over_allowance_co + $old_of->over_allowance_co;
            $newval_value_tt_co = $offert->value_tt_co + $old_of->value_tt_co;
            $newval_gp_ob_co = ($offert->gp_ob_co + $old_of->gp_ob_co)/2;
            $newval_disc_ob_co = ($offert->disc_ob_co + $old_of->disc_ob_co)/2;
            $newval_calculated_price_co = $offert->calculated_price_co + $old_of->calculated_price_co;
            $newval_min_price_co = $offert->min_price_co + $old_of->min_price_co;
            $newval_list_price_co = $offert->list_price_co + $old_of->list_price_co;
            $newval_new_list_price_co = $offert->new_list_price_co + $old_of->new_list_price_co;

            $offert->cost_trasp_co = $newval_cost_trasp_co;
            $offert->price_rtc_co = $newval_price_rtc_co;
            $offert->ol_def_co = $newval_ol_def_co;
            $offert->payed_client_co = $newval_payed_client_co;
            $offert->over_allowance_co = $newval_over_allowance_co;
            $offert->value_tt_co = $newval_value_tt_co;
            $offert->gp_ob_co = $newval_gp_ob_co;
            $offert->disc_ob_co = $newval_disc_ob_co;
            $offert->calculated_price_co = $newval_calculated_price_co;
            $offert->min_price_co = $newval_min_price_co;
            $offert->list_price_co = $newval_list_price_co;
            $offert->list_price_co = $newval_new_list_price_co;

            $offert->type_off = 'Bundle';
            $offert->update();


            $old_of = Offert::query()->where('id_product','=',$request->get('macchina'))->first();
            $newgals = Gallery::query()->where('offert_id','=',$old_of->id)->get();

            foreach ($newgals as $gal){

                $mygal = new Gallery();
                $mygal->type = $gal->type;
                $mygal->position = 2;
                $mygal->offert_id = $id_offert;
                $mygal->name = $gal->name;
                $mygal->save();

            }

            $components = Component::query()->where('offert_id','=',$old_of->id)->get();

            foreach ($components as $comp){

                $reccomp = new Component();
                $reccomp->offert_id = $id_offert;
                $reccomp->offert_type = $comp->offert_type;
                $reccomp->code = $comp->code;
                $reccomp->type = $comp->type;
                $reccomp->material = $comp->material;
                $reccomp->value = $comp->value;
                $reccomp->save();

            }


            echo json_encode($record->id);
        }else{




            $offert_old = Offert::query()->where('id_product','=',$request->get('macchina'))->first();
            $relations = Relation_offert_product::query()->where('idoffert','=',$id_offert)->first();
            $org_pro = Product::query()->where('id','=',$relations->idproduct)->first();
            $org_off = Offert::where('id_product','=',$org_pro->id)->first();

            if($org_off->target_user == $offert_old->target_user){

                $final_check = Relation_offert_product::query()->where('idoffert','=',$id_offert)->where('idproduct','=',$request->get('macchina'))->first();
                if(!$final_check){

                    $record = new Relation_offert_product();
                    $record->idproduct =  $request->get('macchina');
                    $record->idoffert = $id_offert;
                    $record->created_by = Auth()->user()->id;
                    $record->save();

                    $old_of = Offert::query()->where('id_product','=',$request->get('macchina'))->first();

                    $offert = Offert::where('id', '=', $id_offert)->first();

                    $newval_cost_trasp_uf = $offert->cost_trasp_uf + $old_of->cost_trasp_uf;
                    $newval_price_rtc_uf = $offert->price_rtc_uf + $old_of->price_rtc_uf;

                    if($offert->ol_def_uf != null & $old_of->ol_def_uf != null){

                        $newval_ol_def_uf = $offert->ol_def_uf + $old_of->ol_def_uf;

                    }elseif($offert->ol_def_uf != null  & $old_of->ol_def_uf == null){

                        $newval_ol_def_uf = $offert->ol_def_uf + $old_of->ol_prevision_uf;

                    }elseif($offert->ol_def_uf == null  & $old_of->ol_def_uf != null){

                        $newval_ol_def_uf = $offert->ol_prevision_uf + $old_of->ol_def_uf;

                    }elseif($offert->ol_def_uf == null  & $old_of->ol_def_uf == null){

                        $newval_ol_def_uf = $offert->ol_prevision_uf + $old_of->ol_prevision_uf;
                    }

                    $newval_payed_client_uf = $offert->payed_client_uf + $old_of->payed_client_uf;
                    $newval_over_allowance_uf = $offert->over_allowance_uf + $old_of->over_allowance_uf;
                    $newval_value_tt_uf = $offert->value_tt_uf + $old_of->value_tt_uf;
                    $newval_gp_ob_uf = ($offert->gp_ob_uf + $old_of->gp_ob_uf)/2;
                    $newval_disc_ob_uf = ($offert->disc_ob_uf + $old_of->disc_ob_uf)/2;
                    $newval_calculated_price_uf = $offert->calculated_price_uf + $old_of->calculated_price_uf;
                    $newval_min_price_uf = $offert->min_price_uf + $old_of->min_price_uf;
                    $newval_list_price_uf = $offert->list_price_uf + $old_of->list_price_uf;
                    $newval_new_list_price_uf = $offert->new_list_price_uf + $old_of->new_list_price_uf;

                    $offert->cost_trasp_uf = $newval_cost_trasp_uf;
                    $offert->price_rtc_uf = $newval_price_rtc_uf;
                    $offert->ol_def_uf = $newval_ol_def_uf;
                    $offert->payed_client_uf = $newval_payed_client_uf;
                    $offert->over_allowance_uf = $newval_over_allowance_uf;
                    $offert->value_tt_uf = $newval_value_tt_uf;
                    $offert->gp_ob_uf = $newval_gp_ob_uf;
                    $offert->disc_ob_uf = $newval_disc_ob_uf;
                    $offert->calculated_price_uf = $newval_calculated_price_uf;
                    $offert->min_price_uf = $newval_min_price_uf;
                    $offert->list_price_uf = $newval_list_price_uf;
                    $offert->list_price_uf = $newval_new_list_price_uf;

                    $newval_cost_trasp_co = $offert->cost_trasp_co + $old_of->cost_trasp_co;
                    $newval_price_rtc_co = $offert->price_rtc_co + $old_of->price_rtc_co;

                    if($offert->ol_def_co != null & $old_of->ol_def_co != null){

                        $newval_ol_def_co = $offert->ol_def_co + $old_of->ol_def_co;

                    }elseif($offert->ol_def_co != null  & $old_of->ol_def_co == null){

                        $newval_ol_def_co = $offert->ol_def_co + $old_of->ol_prevision_co;

                    }elseif($offert->ol_def_co == null  & $old_of->ol_def_co != null){

                        $newval_ol_def_co = $offert->ol_prevision_co + $old_of->ol_def_co;

                    }elseif($offert->ol_def_co == null  & $old_of->ol_def_co == null){

                        $newval_ol_def_co = $offert->ol_prevision_co + $old_of->ol_prevision_co;
                    }

                    $newval_payed_client_co = $offert->payed_client_co + $old_of->payed_client_co;
                    $newval_over_allowance_co = $offert->over_allowance_co + $old_of->over_allowance_co;
                    $newval_value_tt_co = $offert->value_tt_co + $old_of->value_tt_co;
                    $newval_gp_ob_co = ($offert->gp_ob_co + $old_of->gp_ob_co)/2;
                    $newval_disc_ob_co = ($offert->disc_ob_co + $old_of->disc_ob_co)/2;
                    $newval_calculated_price_co = $offert->calculated_price_co + $old_of->calculated_price_co;
                    $newval_min_price_co = $offert->min_price_co + $old_of->min_price_co;
                    $newval_list_price_co = $offert->list_price_co + $old_of->list_price_co;
                    $newval_new_list_price_co = $offert->new_list_price_co + $old_of->new_list_price_co;

                    $offert->cost_trasp_co = $newval_cost_trasp_co;
                    $offert->price_rtc_co = $newval_price_rtc_co;
                    $offert->ol_def_co = $newval_ol_def_co;
                    $offert->payed_client_co = $newval_payed_client_co;
                    $offert->over_allowance_co = $newval_over_allowance_co;
                    $offert->value_tt_co = $newval_value_tt_co;
                    $offert->gp_ob_co = $newval_gp_ob_co;
                    $offert->disc_ob_co = $newval_disc_ob_co;
                    $offert->calculated_price_co = $newval_calculated_price_co;
                    $offert->min_price_co = $newval_min_price_co;
                    $offert->list_price_co = $newval_list_price_co;
                    $offert->list_price_co = $newval_new_list_price_co;

                    $offert->type_off = 'Bundle';
                    $offert->update();

                    $old_of = Offert::query()->where('id_product','=',$request->get('macchina'))->first();
                    $newgals = Gallery::query()->where('offert_id','=',$old_of->id)->get();

                    foreach ($newgals as $gal){

                        $mygal = new Gallery();
                        $mygal->type = $gal->type;
                        $mygal->position = 2;
                        $mygal->offert_id = $id_offert;
                        $mygal->name = $gal->name;
                        $mygal->save();

                    }

                    $components = Component::query()->where('offert_id','=',$old_of->id)->get();

                    foreach ($components as $comp){

                        $reccomp = new Component();
                        $reccomp->offert_id = $id_offert;
                        $reccomp->offert_type = $comp->offert_type;
                        $reccomp->code = $comp->code;
                        $reccomp->type = $comp->type;
                        $reccomp->material = $comp->material;
                        $reccomp->value = $comp->value;
                        $reccomp->save();

                    }

                    echo json_encode($record->id);
                }
            }
        }


    }

    public function deleterelation(Request $request)
    {


        $record = Relation_offert_product::where('id','=',$request->get('id'))->first();

        $check = Relation_offert_product::where('idoffert','=',$record->idoffert)->get();

        $count=-1;

        foreach ($check as $c){
            $count++;
        }

        if($count < 2){
            $offert = Offert::where('id', '=', $record->idoffert)->first();
            $offert->type_off = 'single';
            $offert->update();
        }


        $record->delete();




        echo json_encode($record->id);
    }

    public function uploadimage($id)
    {


         $position = \request('position');
        if($_FILES["file"]["name"] != '')
        {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = rand(100, 999) . '.' . $ext;
            $location = './upload/' . $name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);

            if(\request('position') == 1){
                $record =  Gallery::query()->where('offert_id','=',$id)
                    ->where('type','=', 'CO')
                    ->where('position','=','1')
                    ->first();
                $record->offert_id = $id;
                $record->name = $name;
                $record->update();

            }elseif (\request('position') == 2){

                $record = New Gallery();
                $record->offert_id = $id;
                $record->name = $name;
                $record->type = 'CO';
                $record->position = 2;
                $record->save();


            }elseif (\request('position') == 3){

                $record =  Gallery::query()->where('offert_id','=',$id)
                    ->where('type','=', 'UF')
                    ->where('position','=','1')
                    ->first();
                $record->offert_id = $id;
                $record->name = $name;
                $record->update();

            }elseif (\request('position') == 4){
                $record = New Gallery();
                $record->offert_id = $id;
                $record->name = $name;
                $record->type = 'UF';
                $record->position = 2;
                $record->save();

            }




            echo '<div id="img'.$record->id.'" class="col-lg-2" style="margin-top: 2%;">
          <button onclick="deleteimage('.$record->id.')" class="delete-file" style="background: rgb(255, 4, 4) none repeat scroll 0% 0%; padding: 0.09rem 0.25em 0px; text-align: center; border-radius: 50%; z-index: 199; color: rgb(255, 255, 255);">
          <i class="glyphicon glyphicon-remove"></i></button>
               <img src="/upload/'.$name.'" style=" width: 150px;height: 150px; border: 3px solid yellow;">
               </div>';
        }else{
            echo "Problem";
        }




    }
    public function deleteimage()
    {
        $rec = Gallery::query()->where('id',\request('id'))->first();
        $rec->delete();
    }

    public function changestatus()
    {
        $offert_id = \request('id_offert');

        $offert = Offert::query()->where('id','=',$offert_id)->first();

        $actual_stat = $offert->status;

        if($offert->type_off == 'single'){
    if($actual_stat == 0){
        $other_offert = Offert::query()
            ->where('id_product','=',$offert->id_product)
            ->where('status','=',1)
            ->where('id','!=', $offert_id)
            ->first();

        if($other_offert){
            return redirect()->back()
                ->with('error',__('Ci sono altre offerte attive'));
        }else{
            $offert->status = 1;
            $offert->update();

            return redirect()->back()
                ->with('success',__('Offerta online'));
        }
    }else{
        $offert->status = 0;
        $offert->update();

        return redirect()->back()
            ->with('success',__('Offerta offline'));
    }

        }else{

            $offert->status = 1;
            $offert->update();

            return redirect()->back()
                ->with('success',__('Offerta offline'));
        }
    }

    public  function setordersgal(){

        $offert = \request('offertid');
        $target = \request('target');

        if( $target == 1){ $type = 'UF'; }else{ $type = 'CO';  }

        $images = Gallery::query()->where('offert_id','=',$offert)->where('type','=', $type)->orderBy('position','ASC')->get();

        return view('admin.offerts.gall',compact('offert','target','images'));
    }

    public  function setordersgalleries(){

        $imageIdsArray =\request('imageIds');

        $count = 1;
        foreach ($imageIdsArray as $id) {


            $gallery = Gallery::query()->where('id','=',$id)->first();
            $gallery->position = $count;
            $gallery->update();

            $count ++;

        }

        return $imageIdsArray;

    }


    public function generatexml()
    {

        $offerts = Offert::query()->where('id','=',3)->get();


        $dom = new DomDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

//        $dom = new DOMDocument();

        $dom->encoding = 'utf-8';

        $dom->xmlVersion = '1.0';

        $dom->formatOutput = true;

        $xml_file_name = 'movies_list.xml';
        $root = $dom->createElement('products');
        //--------------------------------------------------

        foreach ($offerts as $off){

            $product = Product::query()->where('id','=',$off->id_product)->first();
             $product_lines = Products_line::query()->where('id_product','=',$off->id_product)->get();


            $product_node = $dom->createElement('product');

            foreach ($product_lines as $line) {

                $movie_nodes = $dom->createElement('property');
                $attr_movie_id = new DOMAttr(str_replace(' ', '', $line->label_it), $line->ans_it);
                $movie_nodes->setAttributeNode($attr_movie_id);
                $product_node->appendChild($movie_nodes);

//                $child_node_title = $dom->createElement('Title', 'The Campaign');
//                $movie_node->appendChild($child_node_title);
            }

            $root->appendChild($product_node);
        }

        //--------------------------------------------------
         $dom->appendChild($root);

         $dom->save($xml_file_name);



        echo "$xml_file_name has been successfully created";


        $xml_string = $dom->saveXML();
        header('Content-Type: text/plain');
        echo $xml_string;
        echo htmlentities('your xml strings');
    }

    public function storenewapioffert()
    {
        $site =  \request('site');
        switch ($site) {
            case 'ttcar':
                $response = new TuttocarrelliController();
                $response->storenew(\request('tar'),\request('typeval'),\request('pri'),\request('offert_id'));
                break;
            case 'macus':
                $response = new MacuController();
               $response->storenew(\request('tar'),\request('typeval'),\request('pri'),\request('offert_id'));
                // $response->storenew(\request('tar'),\request('typeval'),\request('pri'),\request('offert_id'));
                break;
            case 'supra':
                $response = new SuprliftController();
                $response->storenew(\request('tar'),\request('typeval'),\request('pri'),\request('offert_id'));
                break;
        }

        $data =[
            'ans' => 'ok'
        ];

        return json_encode($data);
    }

    public function deleteoffert()
    {
         $site =  \request('site');

        switch ($site) {
            case 'ttcar':
                $response = new TuttocarrelliController();
                $response->deleteoffert(\request('id'));
                break;
            case 'macus':
                $response = new MacuController();
                $response->deleteoffert(\request('id'));
                break;
            case 'supra':
                $response = new SuprliftController();
                $response->deleteoffert(\request('id'));
                break;

        }
        $data =[
            'ans' => 'ok'
        ];

        return json_encode($data);
    }

    public function sendoption()
    {
        $type = 'O';
        $config = [ 'ashost' => config('main.sap_host'), 'sysnr'  => config('main.sap_sysnr'), 'client' => config('main.sap_client'), 'user' => config('main.sap_user'), 'passwd' => config('main.sap_pass'), ];
        $c = new SapConnection($config);

        $f = $c->getFunction('ZRICEZ_CAMPAGNA_MACCH_RFC');
        $result = $f->invoke([
            'IV_TIPO ' => "$type",
            'IV_KUNNR ' => " ",
            'IV_EQUNR ' => "",
            'IV_BADGE ' => "",
            'EV_VBELN ' => ""
        ],['rtrim' => true]);
        print_r($result);
    }

}
