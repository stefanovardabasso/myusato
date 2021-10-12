<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Quotationvens_line;
use App\Http\Requests\Admin\StoreQuotationvens_lineRequest;
use App\Http\Requests\Admin\UpdateQuotationvens_lineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Quotationvens_lineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Quotationvens_line::class);

        $dataTableObject = Quotationvens_line::getDataTableObject('quotationvens_lineDataTable', route('admin.datatables.quotationvens_lines'));

        return view('admin.quotationvens_lines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Quotationvens_line::class);

        $quotationvens_line = Quotationvens_line::class;

        return view('admin.quotationvens_lines.create', compact('quotationvens_line'));
    }

    /**
     * @param StoreQuotationvens_lineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuotationvens_lineRequest $request)
    {
        $this->authorize('create', Quotationvens_line::class);

        $quotationvens_line = Quotationvens_line::create($request->validated());

        return redirect()->route('admin.quotationvens_lines.edit', [$quotationvens_line])
            ->with('success', Quotationvens_line::getMsgTrans('created'));
    }

    /**
     * @param Quotationvens_line $quotationvens_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Quotationvens_line $quotationvens_line)
    {
        $this->authorize('view', $quotationvens_line);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($quotationvens_line), 'model_id' => $quotationvens_line->id]));

        return view('admin.quotationvens_lines.show', [
            'quotationvens_line' => $quotationvens_line,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Quotationvens_line $quotationvens_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Quotationvens_line $quotationvens_line)
    {
        $this->authorize('update', $quotationvens_line);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.quotationvens_lines.edit', compact('quotationvens_line'));
    }

    /**
     * @param UpdateQuotationvens_lineRequest $request
     * @param Quotationvens_line $quotationvens_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuotationvens_lineRequest $request, Quotationvens_line $quotationvens_line)
    {
        $this->authorize('update', $quotationvens_line);

        $quotationvens_line->update($request->validated());

        return redirect()->route('admin.quotationvens_lines.edit', [$quotationvens_line])
            ->with('success', Quotationvens_line::getMsgTrans('updated'));
    }

    /**
     * @param Quotationvens_line $quotationvens_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Quotationvens_line $quotationvens_line)
    {
        $this->authorize('delete', $quotationvens_line);

        $quotationvens_line->delete();

        return redirect()->route('admin.quotationvens_lines.index')
            ->with('success', Quotationvens_line::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Quotationvens_line::class);

        $query = Quotationvens_line::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Quotationvens_line::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Quotationvens_line::dataTableEditColumns($table);

            return $table->make(true);
        }

        Quotationvens_line::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
