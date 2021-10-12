<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Questions_filter;
use App\Http\Requests\Admin\StoreQuestions_filterRequest;
use App\Http\Requests\Admin\UpdateQuestions_filterRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Questions_filterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Questions_filter::class);

        $dataTableObject = Questions_filter::getDataTableObject('questions_filterDataTable', route('admin.datatables.questions_filters'));

        return view('admin.questions_filters.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Questions_filter::class);

        $questions_filter = Questions_filter::class;

        return view('admin.questions_filters.create', compact('questions_filter'));
    }

    /**
     * @param StoreQuestions_filterRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuestions_filterRequest $request)
    {
        $this->authorize('create', Questions_filter::class);

        $questions_filter = Questions_filter::create($request->validated());

        return redirect()->route('admin.questions_filters.edit', [$questions_filter])
            ->with('success', Questions_filter::getMsgTrans('created'));
    }

    /**
     * @param Questions_filter $questions_filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Questions_filter $questions_filter)
    {
        $this->authorize('view', $questions_filter);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($questions_filter), 'model_id' => $questions_filter->id]));

        return view('admin.questions_filters.show', [
            'questions_filter' => $questions_filter,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Questions_filter $questions_filter
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Questions_filter $questions_filter)
    {
        $this->authorize('update', $questions_filter);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.questions_filters.edit', compact('questions_filter'));
    }

    /**
     * @param UpdateQuestions_filterRequest $request
     * @param Questions_filter $questions_filter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuestions_filterRequest $request, Questions_filter $questions_filter)
    {
        $this->authorize('update', $questions_filter);

        $questions_filter->update($request->validated());

        return redirect()->route('admin.questions_filters.edit', [$questions_filter])
            ->with('success', Questions_filter::getMsgTrans('updated'));
    }

    /**
     * @param Questions_filter $questions_filter
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Questions_filter $questions_filter)
    {
        $this->authorize('delete', $questions_filter);

        $questions_filter->delete();

        return redirect()->route('admin.questions_filters.index')
            ->with('success', Questions_filter::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Questions_filter::class);

        $query = Questions_filter::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Questions_filter::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Questions_filter::dataTableEditColumns($table);

            return $table->make(true);
        }

        Questions_filter::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
