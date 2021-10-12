<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Questions_filters_traduction;
use App\Http\Requests\Admin\StoreQuestions_filters_traductionRequest;
use App\Http\Requests\Admin\UpdateQuestions_filters_traductionRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class Questions_filters_traductionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Questions_filters_traduction::class);

        $dataTableObject = Questions_filters_traduction::getDataTableObject('questions_filters_traductionDataTable', route('admin.datatables.questions_filters_traductions'));

        return view('admin.questions_filters_traductions.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Questions_filters_traduction::class);

        $questions_filters_traduction = Questions_filters_traduction::class;

        return view('admin.questions_filters_traductions.create', compact('questions_filters_traduction'));
    }

    /**
     * @param StoreQuestions_filters_traductionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreQuestions_filters_traductionRequest $request)
    {
        $this->authorize('create', Questions_filters_traduction::class);

        $questions_filters_traduction = Questions_filters_traduction::create($request->validated());

        return redirect()->route('admin.questions_filters_traductions.edit', [$questions_filters_traduction])
            ->with('success', Questions_filters_traduction::getMsgTrans('created'));
    }

    /**
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Questions_filters_traduction $questions_filters_traduction)
    {
        $this->authorize('view', $questions_filters_traduction);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($questions_filters_traduction), 'model_id' => $questions_filters_traduction->id]));

        return view('admin.questions_filters_traductions.show', [
            'questions_filters_traduction' => $questions_filters_traduction,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Questions_filters_traduction $questions_filters_traduction)
    {
        $this->authorize('update', $questions_filters_traduction);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.questions_filters_traductions.edit', compact('questions_filters_traduction'));
    }

    /**
     * @param UpdateQuestions_filters_traductionRequest $request
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateQuestions_filters_traductionRequest $request, Questions_filters_traduction $questions_filters_traduction)
    {
        $this->authorize('update', $questions_filters_traduction);

        $questions_filters_traduction->update($request->validated());

        return redirect()->route('admin.questions_filters_traductions.edit', [$questions_filters_traduction])
            ->with('success', Questions_filters_traduction::getMsgTrans('updated'));
    }

    /**
     * @param Questions_filters_traduction $questions_filters_traduction
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Questions_filters_traduction $questions_filters_traduction)
    {
        $this->authorize('delete', $questions_filters_traduction);

        $questions_filters_traduction->delete();

        return redirect()->route('admin.questions_filters_traductions.index')
            ->with('success', Questions_filters_traduction::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Questions_filters_traduction::class);

        $query = Questions_filters_traduction::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Questions_filters_traduction::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Questions_filters_traduction::dataTableEditColumns($table);

            return $table->make(true);
        }

        Questions_filters_traduction::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
