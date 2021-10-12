<?php

namespace App\Http\Controllers\Admin;

use App\Imports\OffertImport;
use App\Imports\ProductImport;
use App\Models\Admin\Galrtc;
use App\Models\Admin\Product;
use App\Http\Requests\Admin\StoreProductRequest;
use App\Http\Requests\Admin\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Maatwebsite\Excel\Excel;
use Yajra\DataTables\DataTables;
use App\Models\Admin\Offert;
use App\Models\Admin\Relation_offert_product;
use App\Models\Admin\Products_line;
use App\Models\Admin\Questions_sap;
use DB;
use GuzzleHttp\Client;




class ProductController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Product::class);

         $dataTableObject = Product::getDataTableObject('productDataTable', route('admin.datatables.products'));

        return view('admin.products.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Product::class);

        $product = Product::class;

        return view('admin.products.create', compact('product'));
    }

    /**
     * @param StoreProductRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProductRequest $request)
    {
        $this->authorize('create', Product::class);

        $product = Product::create($request->validated());

        return redirect()->route('admin.products.edit', [$product])
            ->with('success', Product::getMsgTrans('created'));
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Product $product)
    {
        $this->authorize('view', $product);

     $check_lines = Products_line::where('id_product', '=', $product->id)
            ->where('label_it','=',null)
            ->orWhere('id_product', '=', $product->id)
            ->where('label_en','=',null)
            ->get();

        if(count($check_lines)>0){

            if($check_lines[0]->label_it == null & $check_lines[0]->label_en == null){

                return redirect()->back()
                    ->with('error',__('Prima di creare un offerta i CC devono essere salvati in entrambe le lingue'));

            }elseif($check_lines[0]->label_it != null & $check_lines[0]->label_en == null){

                return redirect()->back()
                    ->with('error',__('Prima di creare un offerta i CC devono essere salvati anche in <Strong>inglese</Strong>'));

            }elseif($check_lines[0]->label_it == null & $check_lines[0]->label_en != null){

                return redirect()->back()
                    ->with('error',__('Prima di creare un offerta i CC devono essere salvati anche in <strong>italiano</strong>'));

            }



        }



        $relation_offerts = Relation_offert_product::where('idproduct', '=', $product->id)->get();
        $i=0;

           foreach ($relation_offerts as $key) {
               $offerts[$i]=Offert::where('id', '=', $key->idoffert)->get();
               $i++;
           }

        if(!isset($offerts[0])){
            $offerts[0] = 'empty';
        }
        $images = Galrtc::where('product_id',$product->id)->get();
        $lines = Products_line::where('id_product', '=', $product->id)->get();

        $label_false = NULL; $a=0;
        foreach ($lines as $line){

            $label = Questions_sap::where('cc', '=', $line->cc_sap)->first();

            if(!isset($label->label_it)){
                $label_false = $label_false.'   '.$line->cc_sap;

            }else{
                $q[$a] = [
                    'id' => $line->id,
                    'label_it' => $label->label_it,
                    'label_en' => $label->label_en,
                    'ans_it' => $line->ans_it,
                    'ans_en'=> $line->ans_en,
                    'required' => $label->required,
                    'type' => $label->type,
                    'pos_value' => $label->pos_values,
                    'cc_value_sap' => $line->cc_value_sap,
                    'filter' => $line->filter,
                ];
                $a++;
            }
        }

        if(!isset($q[0])){
            $q = NULL;
        }


        $rtc_valu = 'NP';
        if($product->scheda != 0 & $product->scheda != 1){

            $c  = new Client();
            $response1 = $c ->request('GET', 'http://rtc.cls.it/api/getstimartc/'.$product->scheda);
            $datac = json_decode($response1->getBody(), true);
            $rtc_valu = $datac['valu'];

        }

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($product), 'model_id' => $product->id]));

        return view('admin.products.show', [
            'product' => $product,
            'revisionsDataTableObject' => $revisionsDataTableObject,
            'offerts' => $offerts,
            'q'=> $q,
            'label_false' => $label_false,
            'images' =>    $images,
            'rtc_valu' =>$rtc_valu
        ]);
    }

    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Product $product)
    {
        $this->authorize('update', $product);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");
        $images = [];
        $lines = Products_line::where('id_product', '=', $product->id)->get();
        $images = Galrtc::where('product_id',$product->id)->get();
        $label_false = NULL; $a=0;
        foreach ($lines as $line){

            $label = Questions_sap::where('cc', '=', $line->cc_sap)->where('type','!=','range')->first();

            if(!isset($label->label_it)){
                $label_false = $label_false.'   '.$line->cc_sap;

            }else{
                $q[$a] = [
                    'id' => $line->id,
                    'label_it' => $label->label_it,
                    'label_en' => $label->label_en,
                    'ans_it' => $line->ans_it,
                    'ans_en'=> $line->ans_en,
                    'required' => $label->required,
                    'type' => $label->type,
                    'pos_value' => $label->pos_values,
                    'cc_value_sap' => $line->cc_value_sap,
                    'filter' => $line->filter,
                ];
                $a++;
            }
        }

        if(!isset($q[0])){
            $q = NULL;
        }
        $rtc_valu = 'NP';
        if($product->scheda != 0 & $product->scheda != 1){

                $c  = new Client();
                $response1 = $c ->request('GET', 'http://rtc.cls.it/api/getstimartc/'.$product->scheda);
                $datac = json_decode($response1->getBody(), true);
                $rtc_valu = $datac['valu'];

        }
        $dataTableObject = Offert::getDataTableObject('OffertperproductDataTable', route('admin.datatables.offerts', ['idproduct'=> '3']));

         return view('admin.products.edit', compact('product', 'dataTableObject', 'q', 'label_false','images','rtc_valu'));
    }

    /**
     * @param UpdateProductRequest $request
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->validated());

        return redirect()->route('admin.products.edit', [$product])
            ->with('success', 'Prodotto modificato con successo');
    }

    /**
     * @param Product $product
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', Product::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Product::class);

        $query = Product::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Product::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Product::dataTableEditColumns($table);

            return $table->make(true);
        }

        Product::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function importproduct($id)
    {
        //aqui hacemos el import de la informacion orginal enviada desde CLS y SAP a nuestro DB
     return $id;
    }

    public function datatableoff($id_offert)
    {
        $mycards = Product::query()
        ->leftjoin('offerts','products.id','=','offerts.id_product')
            ->where('offerts.type_off','=','single')->get();

   //      $offerts = Offert::query()->where('type_off','single')->get();
     //   $a=0;
      //  $mycards = [];
     //    foreach ($offerts as $of){
     //      $mycards[$a] = Product::where('id',$of->id_product)->LIMIT(100)->first();
     //        $a++;
     //    }




       return Datatables::of($mycards)
             ->addColumn('action', 'admin.products.partials._checkbox')
             ->editColumn('target_user',function ($row){
                 if($row->target_user == '1'){ return 'UTILIZZATORE FINALE'; }
                 if($row->target_user == '2'){  return 'COMMERCIANTE'; }
             })
             ->rawColumns(['action'])
             ->make(true);

    }


    public function editdata($id,$lang)
    {
        $inputs =  request()->post();

        $lines = Products_line::where('id_product', '=', $id)->get();

        foreach ($lines as $line) {
           if($lang == 'it'){
                $label = Questions_sap::where('cc', '=', $line->cc_sap)->first();
                $record = Products_line::where('id','=',$line->id)->first();
                $record->label_it = $label->label_it;
                $record->ans_it = $inputs["$line->id"];
                $record->update();
            }else{
               $label = Questions_sap::where('cc', '=', $line->cc_sap)->first();
               $record = Products_line::where('id','=',$line->id)->first();
               $record->label_en = $label->label_en;
               $record->ans_en = $inputs["$line->id"];
               $record->update();
           }
        }

        return redirect()->back()
            ->with('success', 'Prodotto modificato con successo');




        //aqui hacemos el import de la informacion orginal enviada desde CLS y SAP a nuestro DB
        //return $id;
    }

     public function importadhoc()
     {

//         $remote_file_url = 'http://185.97.156.38/sitocls/img/fotous/'.urlencode('RTC-UCE15724.pdf');
//         $name ='oldusato-'.urlencode('RTC-UCE15724.pdf');
//         $local_file = public_path().'/upload/oldusato-'.urlencode('RTC-UCE15724.pdf');
//         $imagen = file_get_contents($remote_file_url);
//         file_put_contents($local_file, $imagen);

        $file = 'xlsx/1042021.ods';


     \Excel::import(new OffertImport, $file);
         return 1;
     }


}
