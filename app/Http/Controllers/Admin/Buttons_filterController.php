<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Buttons_filter;
use App\Http\Requests\Admin\StoreButtons_filterRequest;
use App\Http\Requests\Admin\UpdateButtons_filterRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Buttons_filterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Buttons_filter::class);

        $dataTableObject = Buttons_filter::getDataTableObject('buttons_filterDataTable', route('admin.datatables.buttons_filters'));

        return view('admin.buttons_filters.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Buttons_filter::class);

        $buttons_filter = Buttons_filter::class;

        return view('admin.buttons_filters.create', compact('buttons_filter'));
    }

    /**
     * @param StoreButtons_filterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreButtons_filterRequest $request)
    {
        $this->authorize('create', Buttons_filter::class);

        $buttons_filter = Buttons_filter::create($request->validated());

        return redirect()->route('admin.buttons_filters.edit', [$buttons_filter])
            ->with('success', Buttons_filter::getMsgTrans('created'));
    }

    /**
     * @param Buttons_filter $buttons_filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Buttons_filter $buttons_filter)
    {
        $this->authorize('view', $buttons_filter);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($buttons_filter), 'model_id' => $buttons_filter->id]));

        return view('admin.buttons_filters.show', [
            'buttons_filter' => $buttons_filter,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Buttons_filter $buttons_filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Buttons_filter $buttons_filter)
    {
        $this->authorize('update', $buttons_filter);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.buttons_filters.edit', compact('buttons_filter'));
    }

    /**
     * @param UpdateButtons_filterRequest $request
     * @param Buttons_filter $buttons_filter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateButtons_filterRequest $request, Buttons_filter $buttons_filter)
    {
        $this->authorize('update', $buttons_filter);

        $buttons_filter->update($request->validated());

        return redirect()->route('admin.buttons_filters.edit', [$buttons_filter])
            ->with('success', Buttons_filter::getMsgTrans('updated'));
    }

    /**
     * @param Buttons_filter $buttons_filter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Buttons_filter $buttons_filter)
    {
        $this->authorize('delete', $buttons_filter);

        $buttons_filter->delete();

        return redirect()->route('admin.buttons_filters.index')
            ->with('success', Buttons_filter::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Buttons_filter::class);

        $query = Buttons_filter::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Buttons_filter::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Buttons_filter::dataTableEditColumns($table);

            return $table->make(true);
        }

        Buttons_filter::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
