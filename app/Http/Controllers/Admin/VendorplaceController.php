<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Vendorplace;
use App\Http\Requests\Admin\StoreVendorplaceRequest;
use App\Http\Requests\Admin\UpdateVendorplaceRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class VendorplaceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Vendorplace::class);

        $dataTableObject = Vendorplace::getDataTableObject('vendorplaceDataTable', route('admin.datatables.vendorplaces'));

        return view('admin.vendorplaces.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Vendorplace::class);

        $vendorplace = Vendorplace::class;

        return view('admin.vendorplaces.create', compact('vendorplace'));
    }

    /**
     * @param StoreVendorplaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreVendorplaceRequest $request)
    {
        $this->authorize('create', Vendorplace::class);

        $vendorplace = Vendorplace::create($request->validated());

        return redirect()->route('admin.vendorplaces.edit', [$vendorplace])
            ->with('success', Vendorplace::getMsgTrans('created'));
    }

    /**
     * @param Vendorplace $vendorplace
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Vendorplace $vendorplace)
    {
        $this->authorize('view', $vendorplace);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($vendorplace), 'model_id' => $vendorplace->id]));

        return view('admin.vendorplaces.show', [
            'vendorplace' => $vendorplace,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Vendorplace $vendorplace
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Vendorplace $vendorplace)
    {
        $this->authorize('update', $vendorplace);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.vendorplaces.edit', compact('vendorplace'));
    }

    /**
     * @param UpdateVendorplaceRequest $request
     * @param Vendorplace $vendorplace
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateVendorplaceRequest $request, Vendorplace $vendorplace)
    {
        $this->authorize('update', $vendorplace);

        $vendorplace->update($request->validated());

        return redirect()->route('admin.vendorplaces.edit', [$vendorplace])
            ->with('success', Vendorplace::getMsgTrans('updated'));
    }

    /**
     * @param Vendorplace $vendorplace
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Vendorplace $vendorplace)
    {
        $this->authorize('delete', $vendorplace);

        $vendorplace->delete();

        return redirect()->route('admin.vendorplaces.index')
            ->with('success', Vendorplace::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Vendorplace::class);

        $query = Vendorplace::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Vendorplace::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Vendorplace::dataTableEditColumns($table);

            return $table->make(true);
        }

        Vendorplace::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
