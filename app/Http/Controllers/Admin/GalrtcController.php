<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Galrtc;
use App\Http\Requests\Admin\StoreGalrtcRequest;
use App\Http\Requests\Admin\UpdateGalrtcRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class GalrtcController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Galrtc::class);

        $dataTableObject = Galrtc::getDataTableObject('galrtcDataTable', route('admin.datatables.galrtcs'));

        return view('admin.galrtcs.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Galrtc::class);

        $galrtc = Galrtc::class;

        return view('admin.galrtcs.create', compact('galrtc'));
    }

    /**
     * @param StoreGalrtcRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreGalrtcRequest $request)
    {
        $this->authorize('create', Galrtc::class);

        $galrtc = Galrtc::create($request->validated());

        return redirect()->route('admin.galrtcs.edit', [$galrtc])
            ->with('success', Galrtc::getMsgTrans('created'));
    }

    /**
     * @param Galrtc $galrtc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Galrtc $galrtc)
    {
        $this->authorize('view', $galrtc);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($galrtc), 'model_id' => $galrtc->id]));

        return view('admin.galrtcs.show', [
            'galrtc' => $galrtc,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Galrtc $galrtc
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Galrtc $galrtc)
    {
        $this->authorize('update', $galrtc);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.galrtcs.edit', compact('galrtc'));
    }

    /**
     * @param UpdateGalrtcRequest $request
     * @param Galrtc $galrtc
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateGalrtcRequest $request, Galrtc $galrtc)
    {
        $this->authorize('update', $galrtc);

        $galrtc->update($request->validated());

        return redirect()->route('admin.galrtcs.edit', [$galrtc])
            ->with('success', Galrtc::getMsgTrans('updated'));
    }

    /**
     * @param Galrtc $galrtc
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Galrtc $galrtc)
    {
        $this->authorize('delete', $galrtc);

        $galrtc->delete();

        return redirect()->route('admin.galrtcs.index')
            ->with('success', Galrtc::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Galrtc::class);

        $query = Galrtc::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Galrtc::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Galrtc::dataTableEditColumns($table);

            return $table->make(true);
        }

        Galrtc::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
