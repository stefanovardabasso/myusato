<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Productline;
use App\Http\Requests\Admin\StoreProductlineRequest;
use App\Http\Requests\Admin\UpdateProductlineRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class ProductlineController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Productline::class);

        $dataTableObject = Productline::getDataTableObject('productlineDataTable', route('admin.datatables.productlines'));

        return view('admin.productlines.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Productline::class);

        $productline = Productline::class;

        return view('admin.productlines.create', compact('productline'));
    }

    /**
     * @param StoreProductlineRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreProductlineRequest $request)
    {
        $this->authorize('create', Productline::class);

        $productline = Productline::create($request->validated());

        return redirect()->route('admin.productlines.edit', [$productline])
            ->with('success', Productline::getMsgTrans('created'));
    }

    /**
     * @param Productline $productline
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Productline $productline)
    {
        $this->authorize('view', $productline);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($productline), 'model_id' => $productline->id]));

        return view('admin.productlines.show', [
            'productline' => $productline,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Productline $productline
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Productline $productline)
    {
        $this->authorize('update', $productline);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.productlines.edit', compact('productline'));
    }

    /**
     * @param UpdateProductlineRequest $request
     * @param Productline $productline
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateProductlineRequest $request, Productline $productline)
    {
        $this->authorize('update', $productline);

        $productline->update($request->validated());

        return redirect()->route('admin.productlines.edit', [$productline])
            ->with('success', Productline::getMsgTrans('updated'));
    }

    /**
     * @param Productline $productline
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Productline $productline)
    {
        $this->authorize('delete', $productline);

        $productline->delete();

        return redirect()->route('admin.productlines.index')
            ->with('success', Productline::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Productline::class);

        $query = Productline::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Productline::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Productline::dataTableEditColumns($table);

            return $table->make(true);
        }

        Productline::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
