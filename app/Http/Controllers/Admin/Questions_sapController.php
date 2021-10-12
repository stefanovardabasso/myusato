<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Questions_sap;
use App\Http\Requests\Admin\StoreQuestions_sapRequest;
use App\Http\Requests\Admin\UpdateQuestions_sapRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Questions_sapController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Questions_sap::class);

        $dataTableObject = Questions_sap::getDataTableObject('questions_sapDataTable', route('admin.datatables.questions_saps'));

        return view('admin.questions_saps.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Questions_sap::class);

        $questions_sap = Questions_sap::class;

        return view('admin.questions_saps.create', compact('questions_sap'));
    }

    /**
     * @param StoreQuestions_sapRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuestions_sapRequest $request)
    {
        $this->authorize('create', Questions_sap::class);

        $questions_sap = Questions_sap::create($request->validated());

        return redirect()->route('admin.questions_saps.edit', [$questions_sap])
            ->with('success', Questions_sap::getMsgTrans('created'));
    }

    /**
     * @param Questions_sap $questions_sap
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Questions_sap $questions_sap)
    {
        $this->authorize('view', $questions_sap);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($questions_sap), 'model_id' => $questions_sap->id]));

        return view('admin.questions_saps.show', [
            'questions_sap' => $questions_sap,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Questions_sap $questions_sap
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Questions_sap $questions_sap)
    {
        $this->authorize('update', $questions_sap);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.questions_saps.edit', compact('questions_sap'));
    }

    /**
     * @param UpdateQuestions_sapRequest $request
     * @param Questions_sap $questions_sap
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuestions_sapRequest $request, Questions_sap $questions_sap)
    {
        $this->authorize('update', $questions_sap);

        $questions_sap->update($request->validated());

        return redirect()->route('admin.questions_saps.edit', [$questions_sap])
            ->with('success', Questions_sap::getMsgTrans('updated'));
    }

    /**
     * @param Questions_sap $questions_sap
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Questions_sap $questions_sap)
    {
        $this->authorize('delete', $questions_sap);

        $questions_sap->delete();

        return redirect()->route('admin.questions_saps.index')
            ->with('success', Questions_sap::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Questions_sap::class);

        $query = Questions_sap::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Questions_sap::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Questions_sap::dataTableEditColumns($table);

            return $table->make(true);
        }

        Questions_sap::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
