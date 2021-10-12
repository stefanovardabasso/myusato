<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Macu;
use App\Http\Requests\Admin\StoreMacuRequest;
use App\Http\Requests\Admin\UpdateMacuRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class MacuController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Macu::class);

        $dataTableObject = Macu::getDataTableObject('macuDataTable', route('admin.datatables.macus'));

        return view('admin.macus.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Macu::class);

        $macu = Macu::class;

        return view('admin.macus.create', compact('macu'));
    }

    /**
     * @param StoreMacuRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMacuRequest $request)
    {
        $this->authorize('create', Macu::class);

        $macu = Macu::create($request->validated());

        return redirect()->route('admin.macus.edit', [$macu])
            ->with('success', Macu::getMsgTrans('created'));
    }

    /**
     * @param Macu $macu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Macu $macu)
    {
        $this->authorize('view', $macu);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($macu), 'model_id' => $macu->id]));

        return view('admin.macus.show', [
            'macu' => $macu,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Macu $macu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Macu $macu)
    {
        $this->authorize('update', $macu);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.macus.edit', compact('macu'));
    }

    /**
     * @param UpdateMacuRequest $request
     * @param Macu $macu
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMacuRequest $request, Macu $macu)
    {
        $this->authorize('update', $macu);

        $macu->update($request->validated());

        return redirect()->route('admin.macus.edit', [$macu])
            ->with('success', Macu::getMsgTrans('updated'));
    }

    /**
     * @param Macu $macu
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Macu $macu)
    {
        $this->authorize('delete', $macu);

        $macu->delete();

        return redirect()->route('admin.macus.index')
            ->with('success', Macu::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Macu::class);

        $query = Macu::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Macu::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Macu::dataTableEditColumns($table);

            return $table->make(true);
        }

        Macu::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function storenew($tar,$typeval,$pri,$offert_id){

        $record = new Macu();
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
        $rec=Macu::query()->where('id','=',$offert_id)->first();
        $rec->action = 3;
        $rec->update();
    }
}
