<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Caract;
use App\Http\Requests\Admin\StoreCaractRequest;
use App\Http\Requests\Admin\UpdateCaractRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class CaractController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Caract::class);

        $dataTableObject = Caract::getDataTableObject('caractDataTable', route('admin.datatables.caracts'));

        return view('admin.caracts.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Caract::class);

        $caract = Caract::class;

        return view('admin.caracts.create', compact('caract'));
    }

    /**
     * @param StoreCaractRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCaractRequest $request)
    {
        $this->authorize('create', Caract::class);

        $caract = Caract::create($request->validated());

        return redirect()->route('admin.caracts.edit', [$caract])
            ->with('success', Caract::getMsgTrans('created'));
    }

    /**
     * @param Caract $caract
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Caract $caract)
    {
        $this->authorize('view', $caract);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($caract), 'model_id' => $caract->id]));

        return view('admin.caracts.show', [
            'caract' => $caract,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Caract $caract
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Caract $caract)
    {
        $this->authorize('update', $caract);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.caracts.edit', compact('caract'));
    }

    /**
     * @param UpdateCaractRequest $request
     * @param Caract $caract
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCaractRequest $request, Caract $caract)
    {
        $this->authorize('update', $caract);

        $caract->update($request->validated());

        return redirect()->route('admin.caracts.edit', [$caract])
            ->with('success', Caract::getMsgTrans('updated'));
    }

    /**
     * @param Caract $caract
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Caract $caract)
    {
        $this->authorize('delete', $caract);

        $caract->delete();

        return redirect()->route('admin.caracts.index')
            ->with('success', Caract::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Caract::class);

        $query = Caract::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Caract::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Caract::dataTableEditColumns($table);

            return $table->make(true);
        }

        Caract::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
