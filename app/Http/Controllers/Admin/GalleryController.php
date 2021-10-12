<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Gallery;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class GalleryController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Gallery::class);

        $dataTableObject = Gallery::getDataTableObject('galleryDataTable', route('admin.datatables.gallerys'));

        return view('admin.gallerys.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Gallery::class);

        $gallery = Gallery::class;

        return view('admin.gallerys.create', compact('gallery'));
    }

    /**
     * @param StoreGalleryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreGalleryRequest $request)
    {
        $this->authorize('create', Gallery::class);

        $gallery = Gallery::create($request->validated());

        return redirect()->route('admin.gallerys.edit', [$gallery])
            ->with('success', Gallery::getMsgTrans('created'));
    }

    /**
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Gallery $gallery)
    {
        $this->authorize('view', $gallery);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($gallery), 'model_id' => $gallery->id]));

        return view('admin.gallerys.show', [
            'gallery' => $gallery,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Gallery $gallery)
    {
        $this->authorize('update', $gallery);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.gallerys.edit', compact('gallery'));
    }

    /**
     * @param UpdateGalleryRequest $request
     * @param Gallery $gallery
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $this->authorize('update', $gallery);

        $gallery->update($request->validated());

        return redirect()->route('admin.gallerys.edit', [$gallery])
            ->with('success', Gallery::getMsgTrans('updated'));
    }

    /**
     * @param Gallery $gallery
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Gallery $gallery)
    {
        $this->authorize('delete', $gallery);

        $gallery->delete();

        return redirect()->route('admin.gallerys.index')
            ->with('success', Gallery::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Gallery::class);

        $query = Gallery::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Gallery::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Gallery::dataTableEditColumns($table);

            return $table->make(true);
        }

        Gallery::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
