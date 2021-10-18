<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Blocksoftext;
use App\Http\Requests\Admin\StoreBlocksoftextRequest;
use App\Http\Requests\Admin\UpdateBlocksoftextRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class BlocksoftextController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Blocksoftext::class);

        $dataTableObject = Blocksoftext::getDataTableObject('blocksoftextDataTable', route('admin.datatables.blocksoftexts'));

        return view('admin.blocksoftexts.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Blocksoftext::class);

        $blocksoftext = Blocksoftext::class;

        return view('admin.blocksoftexts.create', compact('blocksoftext'));
    }

    /**
     * @param StoreBlocksoftextRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreBlocksoftextRequest $request)
    {
        $this->authorize('create', Blocksoftext::class);

        $blocksoftext = Blocksoftext::create($request->validated());

        return redirect()->route('admin.blocksoftexts.edit', [$blocksoftext])
            ->with('success', Blocksoftext::getMsgTrans('created'));
    }

    /**
     * @param Blocksoftext $blocksoftext
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Blocksoftext $blocksoftext)
    {
        $this->authorize('view', $blocksoftext);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($blocksoftext), 'model_id' => $blocksoftext->id]));

        return view('admin.blocksoftexts.show', [
            'blocksoftext' => $blocksoftext,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Blocksoftext $blocksoftext
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Blocksoftext $blocksoftext)
    {
        $this->authorize('update', $blocksoftext);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.blocksoftexts.edit', compact('blocksoftext'));
    }

    /**
     * @param UpdateBlocksoftextRequest $request
     * @param Blocksoftext $blocksoftext
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateBlocksoftextRequest $request, Blocksoftext $blocksoftext)
    {
        $this->authorize('update', $blocksoftext);

        $blocksoftext->update($request->validated());

        return redirect()->route('admin.blocksoftexts.edit', [$blocksoftext])
            ->with('success', Blocksoftext::getMsgTrans('updated'));
    }

    /**
     * @param Blocksoftext $blocksoftext
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Blocksoftext $blocksoftext)
    {
        $this->authorize('delete', $blocksoftext);

        $blocksoftext->delete();

        return redirect()->route('admin.blocksoftexts.index')
            ->with('success', Blocksoftext::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Blocksoftext::class);

        $query = Blocksoftext::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Blocksoftext::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Blocksoftext::dataTableEditColumns($table);

            return $table->make(true);
        }

        Blocksoftext::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
