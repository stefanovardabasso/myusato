<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Mymachine;
use App\Http\Requests\Admin\StoreMymachineRequest;
use App\Http\Requests\Admin\UpdateMymachineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;

class MymachineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Mymachine::class);

        $dataTableObject = Mymachine::getDataTableObject('mymachineDataTable', route('admin.datatables.mymachines'));

        return view('admin.mymachines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Mymachine::class);

        $mymachine = Mymachine::class;

        return view('admin.mymachines.create', compact('mymachine'));
    }

    /**
     * @param StoreMymachineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMymachineRequest $request)
    {
        $this->authorize('create', Mymachine::class);

        $mymachine = Mymachine::create($request->validated());

        return redirect()->route('admin.mymachines.edit', [$mymachine])
            ->with('success', Mymachine::getMsgTrans('created'));
    }

    /**
     * @param Mymachine $mymachine
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Mymachine $mymachine)
    {
        $this->authorize('view', $mymachine);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($mymachine), 'model_id' => $mymachine->id]));

        return view('admin.mymachines.show', [
            'mymachine' => $mymachine,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Mymachine $mymachine
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Mymachine $mymachine)
    {
        $this->authorize('update', $mymachine);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.mymachines.edit', compact('mymachine'));
    }

    /**
     * @param UpdateMymachineRequest $request
     * @param Mymachine $mymachine
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMymachineRequest $request, Mymachine $mymachine)
    {
        $this->authorize('update', $mymachine);

        $mymachine->update($request->validated());

        return redirect()->route('admin.mymachines.edit', [$mymachine])
            ->with('success', Mymachine::getMsgTrans('updated'));
    }

    /**
     * @param Mymachine $mymachine
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Mymachine $mymachine)
    {
        $this->authorize('delete', $mymachine);

        $mymachine->delete();

        return redirect()->route('admin.mymachines.index')
            ->with('success', Mymachine::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Mymachine::class);

        $query = Mymachine::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Mymachine::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Mymachine::dataTableEditColumns($table);

            return $table->make(true);
        }

        Mymachine::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
    public function addtomycatalog()
    {
        $check = Mymachine::query()->where('id_offert', '=', \request('id_offert'))->where('id_user', '=',Auth::id())->first();

        if(!$check){
            $record = new Mymachine();
            $record->id_offert =  \request('id_offert');;
            $record->id_user = Auth::id();
            $record->type = \request('type');
            $record->save();
            return redirect()->back()->with('message',  __('Questa scheda è stata aggiunta al tuo catalogo') );
        }else{
            return redirect()->back()->with('alert',  __('Questa scheda è già presente nel tuo catalogo') );
        }

    }
    public function deletemycatalog()
    {
        $check = Mymachine::query()->where('id_offert', '=', \request('idoffert'))->where('id_user', '=',Auth::id())->first();

        if ($check !== null) {
            $check->delete();
        }

        return redirect()->back()->with('message',  __('Questa scheda è stata eliminata dal tuo catalogo') );
    }
}
