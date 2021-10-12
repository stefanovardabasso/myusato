<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Suprlift;
use App\Http\Requests\Admin\StoreSuprliftRequest;
use App\Http\Requests\Admin\UpdateSuprliftRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class SuprliftController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Suprlift::class);

        $dataTableObject = Suprlift::getDataTableObject('suprliftDataTable', route('admin.datatables.suprlifts'));

        return view('admin.suprlifts.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Suprlift::class);

        $suprlift = Suprlift::class;

        return view('admin.suprlifts.create', compact('suprlift'));
    }

    /**
     * @param StoreSuprliftRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreSuprliftRequest $request)
    {
        $this->authorize('create', Suprlift::class);

        $suprlift = Suprlift::create($request->validated());

        return redirect()->route('admin.suprlifts.edit', [$suprlift])
            ->with('success', Suprlift::getMsgTrans('created'));
    }

    /**
     * @param Suprlift $suprlift
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Suprlift $suprlift)
    {
        $this->authorize('view', $suprlift);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($suprlift), 'model_id' => $suprlift->id]));

        return view('admin.suprlifts.show', [
            'suprlift' => $suprlift,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Suprlift $suprlift
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Suprlift $suprlift)
    {
        $this->authorize('update', $suprlift);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.suprlifts.edit', compact('suprlift'));
    }

    /**
     * @param UpdateSuprliftRequest $request
     * @param Suprlift $suprlift
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSuprliftRequest $request, Suprlift $suprlift)
    {
        $this->authorize('update', $suprlift);

        $suprlift->update($request->validated());

        return redirect()->route('admin.suprlifts.edit', [$suprlift])
            ->with('success', Suprlift::getMsgTrans('updated'));
    }

    /**
     * @param Suprlift $suprlift
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Suprlift $suprlift)
    {
        $this->authorize('delete', $suprlift);

        $suprlift->delete();

        return redirect()->route('admin.suprlifts.index')
            ->with('success', Suprlift::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Suprlift::class);

        $query = Suprlift::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Suprlift::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Suprlift::dataTableEditColumns($table);

            return $table->make(true);
        }

        Suprlift::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
    public function storenew($tar,$typeval,$pri,$offert_id){

        $record = new Suprlift();
        $record->offert_id = $offert_id;
        $record->target_user = $tar;
        $record->type_price = $typeval;
        $record->price = $pri;
        $record->action = 1;
        $record->save();

        return $record;
    }
    public function deleteoffert($offert_id)
    {
        $rec=Suprlift::query()->where('id','=',$offert_id)->first();
        $rec->action = 3;
        $rec->update();

    }
}
