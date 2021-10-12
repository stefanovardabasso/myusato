<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreFaqQuestionRequest;
use App\Http\Requests\Admin\UpdateFaqQuestionRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\FaqCategory;
use App\Models\Admin\FaqQuestion;
use App\Models\Admin\Revision;
use function compact;
use Yajra\DataTables\DataTables;

class FaqQuestionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', FaqQuestion::class);

        $dataTableObject = FaqQuestion::getDataTableObject('faqQuestionsDataTable', route('admin.datatables.faq-questions'));

        return view('admin.faq-questions.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', FaqQuestion::class);

        $categories = FaqCategory::get()->pluck('title', 'id')->prepend('', '');

        $faqQuestion = FaqQuestion::class;

        return view('admin.faq-questions.create', compact('categories', 'faqQuestion'));
    }

    /**
     * @param StoreFaqQuestionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreFaqQuestionRequest $request)
    {
        $this->authorize('create', FaqQuestion::class);

        $faqQuestion = FaqQuestion::createTranslated($request->validated());

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $faqQuestion->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.faq-questions.edit', [$faqQuestion])
            ->with('success', FaqQuestion::getMsgTrans('created'));
    }

    /**
     * @param FaqQuestion $faqQuestion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(FaqQuestion $faqQuestion)
    {
        $this->authorize('view', $faqQuestion);

        $faqQuestion->load('category');

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($faqQuestion), 'model_id' => $faqQuestion->id]));

        return view('admin.faq-questions.show', compact('faqQuestion', 'revisionsDataTableObject'));
    }

    /**
     * @param \App\Models\Admin\FaqQuestion $faqQuestion
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(FaqQuestion $faqQuestion)
    {
        $this->authorize('update', $faqQuestion);

        $categories = FaqCategory::get()->pluck('title', 'id')->prepend('', '');

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.faq-questions.edit', compact('faqQuestion', 'categories'));
    }

    /**
     * @param UpdateFaqQuestionRequest $request
     * @param FaqQuestion $faqQuestion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateFaqQuestionRequest $request, FaqQuestion $faqQuestion)
    {
        $this->authorize('update', $faqQuestion);

        $faqQuestion->updateTranslated($request->validated());

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $faqQuestion->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.faq-questions.edit', [$faqQuestion])
            ->with('success', FaqQuestion::getMsgTrans('updated'));
    }

    /**
     * @param \App\Models\Admin\FaqQuestion $faqQuestion
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(FaqQuestion $faqQuestion)
    {
        $this->authorize('delete', $faqQuestion);

        $faqQuestion->delete();

        return redirect()->route('admin.faq-questions.index')
            ->with('success', FaqQuestion::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', FaqQuestion::class);

        $query = FaqQuestion::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = FaqQuestion::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = FaqQuestion::dataTableEditColumns($table);

            return $table->make(true);
        }

        FaqQuestion::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
