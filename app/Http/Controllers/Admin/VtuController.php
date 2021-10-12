<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Vtu;
use App\Http\Requests\Admin\StoreVtuRequest;
use App\Http\Requests\Admin\UpdateVtuRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class VtuController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Vtu::class);

        $dataTableObject = Vtu::getDataTableObject('vtuDataTable', route('admin.datatables.vtus'));

        return view('admin.vtus.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Vtu::class);

        $vtu = Vtu::class;

        return view('admin.vtus.create', compact('vtu'));
    }

    /**
     * @param StoreVtuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreVtuRequest $request)
    {
        $this->authorize('create', Vtu::class);

        $vtu = Vtu::create($request->validated());

        return redirect()->route('admin.vtus.edit', [$vtu])
            ->with('success', Vtu::getMsgTrans('created'));
    }

    /**
     * @param Vtu $vtu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {

        $vtu = Vtu::where('id', '=', $id)->first();

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($vtu), 'model_id' => $vtu->id]));

        return view('admin.vtus.show', [

            'vtu' => $vtu,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Vtu $vtu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Vtu $vtu)
    {
        $this->authorize('update', $vtu);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.vtus.edit', compact('vtu'));
    }

    /**
     * @param UpdateVtuRequest $request
     * @param Vtu $vtu
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateVtuRequest $request, Vtu $vtu)
    {
        $this->authorize('update', $vtu);

        $vtu->update($request->validated());

        return redirect()->route('admin.vtus.edit', [$vtu])
            ->with('success', Vtu::getMsgTrans('updated'));
    }

    /**
     * @param Vtu $vtu
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Vtu $vtu)
    {
        $this->authorize('delete', $vtu);

        $vtu->delete();

        return redirect()->route('admin.vtus.index')
            ->with('success', Vtu::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Vtu::class);

        $query = Vtu::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Vtu::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Vtu::dataTableEditColumns($table);

            return $table->make(true);
        }

        Vtu::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function valuemy()
    {


        if(\request('brand') != NULL){ $brand = \request('brand'); }else{ $brand = NULL; }
        if(\request('model')  != NULL){ $model = \request('model'); }else{ $model = NULL; }
        if(\request('year') != NULL){ $year = \request('year'); }else{ $year = NULL; }
        if(\request('smin') != NULL){ $smin = \request('smin'); }else{ $smin = NULL; }
        if(\request('smax') != NULL){ $smax = \request('smax'); }else{ $smax = NULL; }

        $out = [
            'brand' =>$brand,
            'model' =>$model,
            'year' =>$year,
            'smin' =>$smin,
            'smax' => $smax
        ];
        return view('site.valuta',compact('out'));
    }

    public function storevtu()
    {
        $record = new Vtu();
        $record->name = \request('name');
        $record->surname = \request('surname');
        $record->company = \request('company');
        $record->address = \request('address');
        $record->comune = \request('comune');
        $record->province = \request('province');
        $record->phone = \request('phone');
        $record->email = \request('email');
        $record->type = \request('type');
        $record->brand = \request('brand');
        $record->model = \request('model');
        $record->year = \request('year');
        $record->mont = \request('mont');
        $record->smin = \request('smin');
        $record->smax = \request('smax');
        $record->port = \request('port');
        $record->price = \request('price');
        $record->fornitore = \request('fornitore');
        $record->notes = \request('notes');
        $record->privacy = \request('privacy');
        $record->save();


        return redirect()->back()->with('message',  __('Abbiamo ricevuto la tua richiesta, un nostro esperto la verificherà e ci metteremo in contatto') );
    }

}
