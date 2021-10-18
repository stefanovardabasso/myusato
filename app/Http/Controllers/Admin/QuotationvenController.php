<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Gallery;
use App\Models\Admin\Offert;
use App\Models\Admin\Product;
use App\Models\Admin\Products_line;
use App\Models\Admin\Quotationven;
use App\Http\Requests\Admin\StoreQuotationvenRequest;
use App\Http\Requests\Admin\UpdateQuotationvenRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Quotationvens_line;
use App\Models\Admin\Relation_offert_product;
use App\Models\Admin\Revision;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;
use App\Models\Admin\Mymachine;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use Mail;



class QuotationvenController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Quotationven::class);

        $dataTableObject = Quotationven::getDataTableObject('quotationvenDataTable', route('admin.datatables.quotationvens'));

        return view('admin.quotationvens.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Quotationven::class);

        $quotationven = Quotationven::class;

        return view('admin.quotationvens.create', compact('quotationven'));
    }

    /**
     * @param StoreQuotationvenRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuotationvenRequest $request)
    {
        $this->authorize('create', Quotationven::class);

        $quotationven = Quotationven::create($request->validated());

        return redirect()->route('admin.quotationvens.edit', [$quotationven])
            ->with('success', Quotationven::getMsgTrans('created'));
    }

    /**
     * @param Quotationven $quotationven
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Quotationven $quotationven)
    {
        $this->authorize('view', $quotationven);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($quotationven), 'model_id' => $quotationven->id]));

        return view('admin.quotationvens.show', [
            'quotationven' => $quotationven,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Quotationven $quotationven
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Quotationven $quotationven)
    {
        $this->authorize('update', $quotationven);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.quotationvens.edit', compact('quotationven'));
    }

    /**
     * @param UpdateQuotationvenRequest $request
     * @param Quotationven $quotationven
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuotationvenRequest $request, Quotationven $quotationven)
    {
        $this->authorize('update', $quotationven);

        $quotationven->update($request->validated());

        return redirect()->route('admin.quotationvens.edit', [$quotationven])
            ->with('success', Quotationven::getMsgTrans('updated'));
    }

    /**
     * @param Quotationven $quotationven
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Quotationven $quotationven)
    {
        $this->authorize('delete', $quotationven);

        $quotationven->delete();

        return redirect()->route('admin.quotationvens.index')
            ->with('success', Quotationven::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Quotationven::class);

        $query = Quotationven::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Quotationven::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Quotationven::dataTableEditColumns($table);

            return $table->make(true);
        }

        Quotationven::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public  function addtoquotationven()
    {
        $prices = \request('price_');
        $titles = \request('title_');
        $user_id=Auth::id();
        $myofferts_sing = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Single')->get();
        $myofferts_bun = Mymachine::query()->where('id_user', '=', $user_id)->where('type', '=', 'Bundle')->get();
        $offerts_sing = [];
        $offerts_bun = [];
        $offert = [];
        $images = [];
        $prods = [];

        foreach ($myofferts_sing as $off) {

            $images[$off->id_offert] = Gallery::query()->where('offert_id', '=', $off->id_offert)->first();
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $prods[$off->id_offert] = Product::where('id', '=', $offert[$off->id_offert]->id_product)->first();
            $prods_lines[$off->id_offert] = Products_line::where('id', '=', $offert[$off->id_offert]->id_product)->get();
        }

        foreach ($myofferts_bun as $off) {
            $offert[$off->id_offert] = Offert::query()->where('id', '=', $off->id_offert)->first();
            $images[$off->id_offert] = Gallery::where('offert_id', '=', $off->id_offert)->first();
            $relations = Relation_offert_product::where('idoffert', '=', $off->id_offert)->get();
            $a = 0;
            foreach ($relations as $re) {

                $prods[$off->id_offert][$a] = Product::where('id', '=', $re->idproduct)->first();
                $prods_lines[$off->id_offert] = Products_line::where('id', '=', $offert[$off->id_offert]->id_product)->get();
                $a++;
            }

        }

        $pdf= '';

        $record = new Quotationven();
        $record->user_id = Auth::id();
        $record->title = \request('title');
        $record->text = \request('message');
        $record->email = \request('email');
        $record->filepdf = $pdf;
        $record->save();

        $num_ram = rand(5, 15);
        $hash_c = \auth()->user()->id.'_'.$num_ram.'_'.$record->id.''.uniqid(rand(), true);
        $pdf=$hash_c.'.pdf';

        $record->filepdf = $pdf;
        $record->update();

        $pdf = PDF::loadView('site.export-templates.valutation', [
            'offerts' => $offert,
            'singleoff' => $myofferts_sing,
            'bunoff' => $myofferts_bun,
            'imgoff' => $images,
            'prods' => $prods,
            'prods_lines'=>$prods_lines,
            'titles'=>$titles,
            'prices'=>$prices
        ]);



        $path = public_path('upload/');
        $pdf->save($path . $hash_c.'.pdf');
        $mycatalog = Mymachine::query()->where('id_user','=', Auth::id())->get();

        foreach ($mycatalog as $mac){
            $record_line = new Quotationvens_line();
            $record_line->id_quotationven = $record->id;
            $record_line->offert_id = $mac->id_offert;
            $record_line->save();

        }
            $email =  \request('email');
            $title = \request('title');

        $data = [
            'title' => \request('title'),
            'text' => \request('message'),
            'id' => $hash_c,
        ];


        Mail::send('site.mail_template.quotation_ven',['data'=>$data], function ($message) use($email,$title) {


            $message->from('noreply@cls.it', 'CLS');


            $message->subject($title);
            $message->to($email);
        });


        return redirect()->back()->with('message',  __('Richiesta di quotazione inviata') );
    }

    public function myquotationsven(){
       $myquotations = Quotationven::query()->where('user_id','=',Auth::id())->get();

        return view('site.quotations',['quotations' => $myquotations]);
    }
}
