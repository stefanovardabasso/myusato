<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Tuttocarrelli;
use App\Http\Requests\Admin\StoreTuttocarrelliRequest;
use App\Http\Requests\Admin\UpdateTuttocarrelliRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class TuttocarrelliController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Tuttocarrelli::class);

        $dataTableObject = Tuttocarrelli::getDataTableObject('tuttocarrelliDataTable', route('admin.datatables.tuttocarrellis'));

        return view('admin.tuttocarrellis.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Tuttocarrelli::class);

        $tuttocarrelli = Tuttocarrelli::class;

        return view('admin.tuttocarrellis.create', compact('tuttocarrelli'));
    }

    /**
     * @param StoreTuttocarrelliRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreTuttocarrelliRequest $request)
    {
        $this->authorize('create', Tuttocarrelli::class);

        $tuttocarrelli = Tuttocarrelli::create($request->validated());

        return redirect()->route('admin.tuttocarrellis.edit', [$tuttocarrelli])
            ->with('success', Tuttocarrelli::getMsgTrans('created'));
    }

    /**
     * @param Tuttocarrelli $tuttocarrelli
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Tuttocarrelli $tuttocarrelli)
    {
        $this->authorize('view', $tuttocarrelli);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($tuttocarrelli), 'model_id' => $tuttocarrelli->id]));

        return view('admin.tuttocarrellis.show', [
            'tuttocarrelli' => $tuttocarrelli,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Tuttocarrelli $tuttocarrelli
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Tuttocarrelli $tuttocarrelli)
    {
        $this->authorize('update', $tuttocarrelli);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.tuttocarrellis.edit', compact('tuttocarrelli'));
    }

    /**
     * @param UpdateTuttocarrelliRequest $request
     * @param Tuttocarrelli $tuttocarrelli
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTuttocarrelliRequest $request, Tuttocarrelli $tuttocarrelli)
    {
        $this->authorize('update', $tuttocarrelli);

        $tuttocarrelli->update($request->validated());

        return redirect()->route('admin.tuttocarrellis.edit', [$tuttocarrelli])
            ->with('success', Tuttocarrelli::getMsgTrans('updated'));
    }

    /**
     * @param Tuttocarrelli $tuttocarrelli
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Tuttocarrelli $tuttocarrelli)
    {
        $this->authorize('delete', $tuttocarrelli);

        $tuttocarrelli->delete();

        return redirect()->route('admin.tuttocarrellis.index')
            ->with('success', Tuttocarrelli::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Tuttocarrelli::class);

        $query = Tuttocarrelli::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Tuttocarrelli::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Tuttocarrelli::dataTableEditColumns($table);

            return $table->make(true);
        }

        Tuttocarrelli::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
    public function storenew($tar,$typeval,$pri,$offert_id){

        $record = new Tuttocarrelli();
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
        $rec=Tuttocarrelli::query()->where('id','=',$offert_id)->first();
        $rec->action = 3;
        $rec->update();
    }
}
