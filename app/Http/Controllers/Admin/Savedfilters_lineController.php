<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Savedfilters_line;
use App\Http\Requests\Admin\StoreSavedfilters_lineRequest;
use App\Http\Requests\Admin\UpdateSavedfilters_lineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Savedfilters_lineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Savedfilters_line::class);

        $dataTableObject = Savedfilters_line::getDataTableObject('savedfilters_lineDataTable', route('admin.datatables.savedfilters_lines'));

        return view('admin.savedfilters_lines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Savedfilters_line::class);

        $savedfilters_line = Savedfilters_line::class;

        return view('admin.savedfilters_lines.create', compact('savedfilters_line'));
    }

    /**
     * @param StoreSavedfilters_lineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreSavedfilters_lineRequest $request)
    {
        $this->authorize('create', Savedfilters_line::class);

        $savedfilters_line = Savedfilters_line::create($request->validated());

        return redirect()->route('admin.savedfilters_lines.edit', [$savedfilters_line])
            ->with('success', Savedfilters_line::getMsgTrans('created'));
    }

    /**
     * @param Savedfilters_line $savedfilters_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Savedfilters_line $savedfilters_line)
    {
        $this->authorize('view', $savedfilters_line);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($savedfilters_line), 'model_id' => $savedfilters_line->id]));

        return view('admin.savedfilters_lines.show', [
            'savedfilters_line' => $savedfilters_line,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Savedfilters_line $savedfilters_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Savedfilters_line $savedfilters_line)
    {
        $this->authorize('update', $savedfilters_line);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.savedfilters_lines.edit', compact('savedfilters_line'));
    }

    /**
     * @param UpdateSavedfilters_lineRequest $request
     * @param Savedfilters_line $savedfilters_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSavedfilters_lineRequest $request, Savedfilters_line $savedfilters_line)
    {
        $this->authorize('update', $savedfilters_line);

        $savedfilters_line->update($request->validated());

        return redirect()->route('admin.savedfilters_lines.edit', [$savedfilters_line])
            ->with('success', Savedfilters_line::getMsgTrans('updated'));
    }

    /**
     * @param Savedfilters_line $savedfilters_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Savedfilters_line $savedfilters_line)
    {
        $this->authorize('delete', $savedfilters_line);

        $savedfilters_line->delete();

        return redirect()->route('admin.savedfilters_lines.index')
            ->with('success', Savedfilters_line::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Savedfilters_line::class);

        $query = Savedfilters_line::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Savedfilters_line::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Savedfilters_line::dataTableEditColumns($table);

            return $table->make(true);
        }

        Savedfilters_line::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
