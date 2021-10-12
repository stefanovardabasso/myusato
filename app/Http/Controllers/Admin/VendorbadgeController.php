<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Vendorbadge;
use App\Http\Requests\Admin\StoreVendorbadgeRequest;
use App\Http\Requests\Admin\UpdateVendorbadgeRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class VendorbadgeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Vendorbadge::class);

        $dataTableObject = Vendorbadge::getDataTableObject('vendorbadgeDataTable', route('admin.datatables.vendorbadges'));

        return view('admin.vendorbadges.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Vendorbadge::class);

        $vendorbadge = Vendorbadge::class;

        return view('admin.vendorbadges.create', compact('vendorbadge'));
    }

    /**
     * @param StoreVendorbadgeRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreVendorbadgeRequest $request)
    {
        $this->authorize('create', Vendorbadge::class);

        $vendorbadge = Vendorbadge::create($request->validated());

        return redirect()->route('admin.vendorbadges.edit', [$vendorbadge])
            ->with('success', Vendorbadge::getMsgTrans('created'));
    }

    /**
     * @param Vendorbadge $vendorbadge
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Vendorbadge $vendorbadge)
    {
        $this->authorize('view', $vendorbadge);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($vendorbadge), 'model_id' => $vendorbadge->id]));

        return view('admin.vendorbadges.show', [
            'vendorbadge' => $vendorbadge,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Vendorbadge $vendorbadge
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Vendorbadge $vendorbadge)
    {
        $this->authorize('update', $vendorbadge);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.vendorbadges.edit', compact('vendorbadge'));
    }

    /**
     * @param UpdateVendorbadgeRequest $request
     * @param Vendorbadge $vendorbadge
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateVendorbadgeRequest $request, Vendorbadge $vendorbadge)
    {
        $this->authorize('update', $vendorbadge);

        $vendorbadge->update($request->validated());

        return redirect()->route('admin.vendorbadges.edit', [$vendorbadge])
            ->with('success', Vendorbadge::getMsgTrans('updated'));
    }

    /**
     * @param Vendorbadge $vendorbadge
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Vendorbadge $vendorbadge)
    {
        $this->authorize('delete', $vendorbadge);

        $vendorbadge->delete();

        return redirect()->route('admin.vendorbadges.index')
            ->with('success', Vendorbadge::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Vendorbadge::class);

        $query = Vendorbadge::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Vendorbadge::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Vendorbadge::dataTableEditColumns($table);

            return $table->make(true);
        }

        Vendorbadge::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
