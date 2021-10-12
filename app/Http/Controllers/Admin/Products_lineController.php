<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Products_line;
use App\Http\Requests\Admin\StoreProducts_lineRequest;
use App\Http\Requests\Admin\UpdateProducts_lineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Products_lineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Products_line::class);

        $dataTableObject = Products_line::getDataTableObject('products_lineDataTable', route('admin.datatables.products_lines'));

        return view('admin.products_lines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Products_line::class);

        $products_line = Products_line::class;

        return view('admin.products_lines.create', compact('products_line'));
    }

    /**
     * @param StoreProducts_lineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProducts_lineRequest $request)
    {
        $this->authorize('create', Products_line::class);

        $products_line = Products_line::create($request->validated());

        return redirect()->route('admin.products_lines.edit', [$products_line])
            ->with('success', Products_line::getMsgTrans('created'));
    }

    /**
     * @param Products_line $products_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Products_line $products_line)
    {
        $this->authorize('view', $products_line);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($products_line), 'model_id' => $products_line->id]));

        return view('admin.products_lines.show', [
            'products_line' => $products_line,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Products_line $products_line
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Products_line $products_line)
    {
        $this->authorize('update', $products_line);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.products_lines.edit', compact('products_line'));
    }

    /**
     * @param UpdateProducts_lineRequest $request
     * @param Products_line $products_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProducts_lineRequest $request, Products_line $products_line)
    {
        $this->authorize('update', $products_line);

        $products_line->update($request->validated());

        return redirect()->route('admin.products_lines.edit', [$products_line])
            ->with('success', Products_line::getMsgTrans('updated'));
    }

    /**
     * @param Products_line $products_line
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Products_line $products_line)
    {
        $this->authorize('delete', $products_line);

        $products_line->delete();

        return redirect()->route('admin.products_lines.index')
            ->with('success', Products_line::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Products_line::class);

        $query = Products_line::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Products_line::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Products_line::dataTableEditColumns($table);

            return $table->make(true);
        }

        Products_line::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
