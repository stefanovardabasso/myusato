<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Fam_select;
use App\Http\Requests\Admin\StoreFam_selectRequest;
use App\Http\Requests\Admin\UpdateFam_selectRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Fam_selectController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Fam_select::class);

        $dataTableObject = Fam_select::getDataTableObject('fam_selectDataTable', route('admin.datatables.fam_selects'));

        return view('admin.fam_selects.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Fam_select::class);

        $fam_select = Fam_select::class;

        return view('admin.fam_selects.create', compact('fam_select'));
    }

    /**
     * @param StoreFam_selectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreFam_selectRequest $request)
    {
        $this->authorize('create', Fam_select::class);

        $fam_select = Fam_select::create($request->validated());

        return redirect()->route('admin.fam_selects.edit', [$fam_select])
            ->with('success', Fam_select::getMsgTrans('created'));
    }

    /**
     * @param Fam_select $fam_select
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Fam_select $fam_select)
    {
        $this->authorize('view', $fam_select);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($fam_select), 'model_id' => $fam_select->id]));

        return view('admin.fam_selects.show', [
            'fam_select' => $fam_select,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Fam_select $fam_select
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Fam_select $fam_select)
    {
        $this->authorize('update', $fam_select);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.fam_selects.edit', compact('fam_select'));
    }

    /**
     * @param UpdateFam_selectRequest $request
     * @param Fam_select $fam_select
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateFam_selectRequest $request, Fam_select $fam_select)
    {
        $this->authorize('update', $fam_select);

        $fam_select->update($request->validated());

        return redirect()->route('admin.fam_selects.edit', [$fam_select])
            ->with('success', Fam_select::getMsgTrans('updated'));
    }

    /**
     * @param Fam_select $fam_select
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Fam_select $fam_select)
    {
        $this->authorize('delete', $fam_select);

        $fam_select->delete();

        return redirect()->route('admin.fam_selects.index')
            ->with('success', Fam_select::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Fam_select::class);

        $query = Fam_select::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Fam_select::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Fam_select::dataTableEditColumns($table);

            return $table->make(true);
        }

        Fam_select::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
