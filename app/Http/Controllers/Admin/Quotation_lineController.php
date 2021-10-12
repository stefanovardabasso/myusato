<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Quotation_line;
use App\Http\Requests\Admin\StoreQuotation_lineRequest;
use App\Http\Requests\Admin\UpdateQuotation_lineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Quotation_lineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Quotation_line::class);

        $dataTableObject = Quotation_line::getDataTableObject('quotation_lineDataTable', route('admin.datatables.quotation_lines'));

        return view('admin.quotation_lines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Quotation_line::class);

        $quotation_line = Quotation_line::class;

        return view('admin.quotation_lines.create', compact('quotation_line'));
    }

    /**
     * @param StoreQuotation_lineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuotation_lineRequest $request)
    {
        $this->authorize('create', Quotation_line::class);

        $quotation_line = Quotation_line::create($request->validated());

        return redirect()->route('admin.quotation_lines.edit', [$quotation_line])
            ->with('success', Quotation_line::getMsgTrans('created'));
    }

    /**
     * @param Quotation_line $quotation_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Quotation_line $quotation_line)
    {
        $this->authorize('view', $quotation_line);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($quotation_line), 'model_id' => $quotation_line->id]));

        return view('admin.quotation_lines.show', [
            'quotation_line' => $quotation_line,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Quotation_line $quotation_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Quotation_line $quotation_line)
    {
        $this->authorize('update', $quotation_line);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.quotation_lines.edit', compact('quotation_line'));
    }

    /**
     * @param UpdateQuotation_lineRequest $request
     * @param Quotation_line $quotation_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuotation_lineRequest $request, Quotation_line $quotation_line)
    {
        $this->authorize('update', $quotation_line);

        $quotation_line->update($request->validated());

        return redirect()->route('admin.quotation_lines.edit', [$quotation_line])
            ->with('success', Quotation_line::getMsgTrans('updated'));
    }

    /**
     * @param Quotation_line $quotation_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Quotation_line $quotation_line)
    {
        $this->authorize('delete', $quotation_line);

        $quotation_line->delete();

        return redirect()->route('admin.quotation_lines.index')
            ->with('success', Quotation_line::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Quotation_line::class);

        $query = Quotation_line::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Quotation_line::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Quotation_line::dataTableEditColumns($table);

            return $table->make(true);
        }

        Quotation_line::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
