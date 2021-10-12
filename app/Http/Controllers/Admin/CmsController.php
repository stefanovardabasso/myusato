<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Cms;
use App\Http\Requests\Admin\StoreCmsRequest;
use App\Http\Requests\Admin\UpdateCmsRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class CmsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Cms::class);

        $dataTableObject = Cms::getDataTableObject('cmsDataTable', route('admin.datatables.cmss'));

        return view('admin.cmss.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Cms::class);

        $cms = Cms::class;

        return view('admin.cmss.create', compact('cms'));
    }

    /**
     * @param StoreCmsRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreCmsRequest $request)
    {
        $this->authorize('create', Cms::class);

        $cms = Cms::create($request->validated());

        return redirect()->route('admin.cmss.edit', [$cms])
            ->with('success', Cms::getMsgTrans('created'));
    }

    /**
     * @param Cms $cms
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Cms $cms)
    {
        $this->authorize('view', $cms);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($cms), 'model_id' => $cms->id]));

        return view('admin.cmss.show', [
            'cms' => $cms,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Cms $cms
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Cms $cms)
    {
        $this->authorize('update', $cms);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.cmss.edit', compact('cms'));
    }

    /**
     * @param UpdateCmsRequest $request
     * @param Cms $cms
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateCmsRequest $request, Cms $cms)
    {
        $this->authorize('update', $cms);

        $cms->update($request->validated());

        return redirect()->route('admin.cmss.edit', [$cms])
            ->with('success', Cms::getMsgTrans('updated'));
    }

    /**
     * @param Cms $cms
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Cms $cms)
    {
        $this->authorize('delete', $cms);

        $cms->delete();

        return redirect()->route('admin.cmss.index')
            ->with('success', Cms::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Cms::class);

        $query = Cms::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Cms::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Cms::dataTableEditColumns($table);

            return $table->make(true);
        }

        Cms::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
