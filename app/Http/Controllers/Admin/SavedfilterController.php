<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Savedfilter;
use App\Http\Requests\Admin\StoreSavedfilterRequest;
use App\Http\Requests\Admin\UpdateSavedfilterRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use App\Models\Admin\Savedfilters_line;
use App\Models\Admin\User;
use Yajra\DataTables\DataTables;

class SavedfilterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Savedfilter::class);

        $dataTableObject = Savedfilter::getDataTableObject('savedfilterDataTable', route('admin.datatables.savedfilters'));

        return view('admin.savedfilters.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Savedfilter::class);

        $savedfilter = Savedfilter::class;

        return view('admin.savedfilters.create', compact('savedfilter'));
    }

    /**
     * @param StoreSavedfilterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreSavedfilterRequest $request)
    {
        $this->authorize('create', Savedfilter::class);

        $savedfilter = Savedfilter::create($request->validated());

        return redirect()->route('admin.savedfilters.edit', [$savedfilter])
            ->with('success', Savedfilter::getMsgTrans('created'));
    }

    /**
     * @param Savedfilter $savedfilter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Savedfilter $savedfilter)
    {
        $this->authorize('view', $savedfilter);

         $lines = Savedfilters_line::query()->where('saved_id','=',$savedfilter->id)->get();
         $user = User::query()->where('id','=',$savedfilter->id_user)->first();
        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($savedfilter), 'model_id' => $savedfilter->id]));

        return view('admin.savedfilters.show', [
            'savedfilter' => $savedfilter,
            'revisionsDataTableObject' => $revisionsDataTableObject,
            'lines'=> $lines,
            'user' => $user
        ]);
    }

    /**
     * @param Savedfilter $savedfilter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Savedfilter $savedfilter)
    {
        $this->authorize('update', $savedfilter);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.savedfilters.edit', compact('savedfilter'));
    }

    /**
     * @param UpdateSavedfilterRequest $request
     * @param Savedfilter $savedfilter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSavedfilterRequest $request, Savedfilter $savedfilter)
    {
        $this->authorize('update', $savedfilter);

        $savedfilter->update($request->validated());

        return redirect()->route('admin.savedfilters.edit', [$savedfilter])
            ->with('success', Savedfilter::getMsgTrans('updated'));
    }

    /**
     * @param Savedfilter $savedfilter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Savedfilter $savedfilter)
    {
        $this->authorize('delete', $savedfilter);

        $savedfilter->delete();

        return redirect()->route('admin.savedfilters.index')
            ->with('success', Savedfilter::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Savedfilter::class);

        $query = Savedfilter::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Savedfilter::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Savedfilter::dataTableEditColumns($table);

            return $table->make(true);
        }

        Savedfilter::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
