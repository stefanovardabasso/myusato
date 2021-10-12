<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Gallery;
use App\Models\Admin\Offert;
use App\Models\Admin\Product;
use App\Models\Admin\Quotation;
use App\Http\Requests\Admin\StoreQuotationRequest;
use App\Http\Requests\Admin\UpdateQuotationRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Relation_offert_product;
use App\Models\Admin\Revision;
use App\Models\Admin\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin\Quotation_line;
use App\Models\Admin\Mymachine;

class QuotationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Quotation::class);

        $dataTableObject = Quotation::getDataTableObject('quotationDataTable', route('admin.datatables.quotations'));

        return view('admin.quotations.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Quotation::class);

        $quotation = Quotation::class;

        return view('admin.quotations.create', compact('quotation'));
    }

    /**
     * @param StoreQuotationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuotationRequest $request)
    {
        $this->authorize('create', Quotation::class);

        $quotation = Quotation::create($request->validated());

        return redirect()->route('admin.quotations.edit', [$quotation])
            ->with('success', Quotation::getMsgTrans('created'));
    }

    /**
     * @param Quotation $quotation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Quotation $quotation)
    {
        $this->authorize('view', $quotation);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($quotation), 'model_id' => $quotation->id]));

        $user = User::query()->where('id','=',$quotation->id_user)->first();

        $lines_quo = Quotation_line::query()->where('id_quotation','=', $quotation->id)->get();
        $offerts = [];
        foreach ($lines_quo as $line){
            $offerts[$line->id] = Offert::query()->where('id','=',$line->id_offert)->first();
        }

        return view('admin.quotations.show', [
            'quotation' => $quotation,
            'revisionsDataTableObject' => $revisionsDataTableObject,
            'user' => $user,
            'lines' => $lines_quo,
            'offerts' => $offerts

        ]);
    }

    /**
     * @param Quotation $quotation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Quotation $quotation)
    {
        $this->authorize('update', $quotation);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.quotations.edit', compact('quotation'));
    }

    /**
     * @param UpdateQuotationRequest $request
     * @param Quotation $quotation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuotationRequest $request, Quotation $quotation)
    {
        $this->authorize('update', $quotation);

        $quotation->update($request->validated());

        return redirect()->route('admin.quotations.edit', [$quotation])
            ->with('success', Quotation::getMsgTrans('updated'));
    }

    /**
     * @param Quotation $quotation
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Quotation $quotation)
    {
        $this->authorize('delete', $quotation);

        $quotation->delete();

        return redirect()->route('admin.quotations.index')
            ->with('success', Quotation::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Quotation::class);

        $query = Quotation::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Quotation::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Quotation::dataTableEditColumns($table);

            return $table->make(true);
        }

        Quotation::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
    public function  formquotation(){
        $user_id = Auth::id();
        $myofferts_sing = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Single')->get();
        $myofferts_bun = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Bundle')->get();
        $offerts_sing = [];
        $offerts_bun = [];
        $offert = [];
        $images = [];
        $prods = [];


        foreach ($myofferts_sing as $off){

            $images[$off->id_offert] = Gallery::query()->where('offert_id', '=', $off->id_offert)->first();
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $prods[$off->id_offert] = Product::where('id', '=', $offert[$off->id_offert]->id_product)->first();
        }




        foreach ($myofferts_bun as $off){
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $images[$off->id_offert] = Gallery::where('offert_id', '=', $off->id_offert)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $off->id_offert)->get();
            $a = 0;
            foreach($relations as $re) {

                $prods[$off->id_offert][$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }

        }


        return view('site.formquotation', [
            'offerts' => $offert,
            'singleoff' => $myofferts_sing,
            'bunoff' => $myofferts_bun,
            'imgoff' => $images,
            'prods' => $prods
        ]);

    }

    public function addtoquotation()
    {



            $record = new Quotation();
            $record->id_user = Auth::id();
            $record->title = \request('title');
            $record->text = \request('message');
            $record->status = '1';
            $record->save();

            $mycatalog = Mymachine::query()->where('id_user','=', Auth::id())->get();

            foreach ($mycatalog as $mac){
                $record_line = new Quotation_line();
                $record_line->id_quotation = $record->id;
                $record_line->id_offert = $mac->id_offert;
                $record_line->save();

            }


            return redirect()->back()->with('message',  __('Richiesta di quotazione inviata') );




    }
    public function myquotations( )
    {
        $quotations = Quotation::query()->where('id_user','=',Auth::id())->get();
        return view('site.quotations',['quotations'=>$quotations]);
    }
    public function formquotationven( )
    {
        $user_id = Auth::id();
        $myofferts_sing = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Single')->get();
        $myofferts_bun = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Bundle')->get();
        $offerts_sing = [];
        $offerts_bun = [];
        $offert = [];
        $images = [];
        $prods = [];


        foreach ($myofferts_sing as $off){

            $images[$off->id_offert] = Gallery::query()->where('offert_id', '=', $off->id_offert)->first();
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $prods[$off->id_offert] = Product::where('id', '=', $offert[$off->id_offert]->id_product)->first();
        }




        foreach ($myofferts_bun as $off){
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $images[$off->id_offert] = Gallery::where('offert_id', '=', $off->id_offert)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $off->id_offert)->get();
            $a = 0;
            foreach($relations as $re) {

                $prods[$off->id_offert][$a] = Product::where('id', '=', $re->idproduct)->first();
                $a++;
            }

        }

        return view('site.formquotationven', [
            'offerts' => $offert,
            'singleoff' => $myofferts_sing,
            'bunoff' => $myofferts_bun,
            'imgoff' => $images,
            'prods' => $prods
        ]);
    }
}
