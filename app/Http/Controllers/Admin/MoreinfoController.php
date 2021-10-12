<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Moreinfo;
use App\Http\Requests\Admin\StoreMoreinfoRequest;
use App\Http\Requests\Admin\UpdateMoreinfoRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Offert;
use App\Models\Admin\Revision;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
class MoreinfoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Moreinfo::class);

        $dataTableObject = Moreinfo::getDataTableObject('moreinfoDataTable', route('admin.datatables.moreinfos'));

        return view('admin.moreinfos.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Moreinfo::class);

        $moreinfo = Moreinfo::class;

        return view('admin.moreinfos.create', compact('moreinfo'));
    }

    /**
     * @param StoreMoreinfoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreMoreinfoRequest $request)
    {
        $this->authorize('create', Moreinfo::class);

        $moreinfo = Moreinfo::create($request->validated());

        return redirect()->route('admin.moreinfos.edit', [$moreinfo])
            ->with('success', Moreinfo::getMsgTrans('created'));
    }

    /**
     * @param Moreinfo $moreinfo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Moreinfo $moreinfo)
    {
        $this->authorize('view', $moreinfo);

        $check_off = Offert::query()->where('id','=',$moreinfo->offert_id)->first();

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($moreinfo), 'model_id' => $moreinfo->id]));

        return view('admin.moreinfos.show', [
            'moreinfo' => $moreinfo,
            'revisionsDataTableObject' => $revisionsDataTableObject,
            'check_off' => $check_off
        ]);
    }

    /**
     * @param Moreinfo $moreinfo
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Moreinfo $moreinfo)
    {
        $this->authorize('update', $moreinfo);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.moreinfos.edit', compact('moreinfo'));
    }

    /**
     * @param UpdateMoreinfoRequest $request
     * @param Moreinfo $moreinfo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateMoreinfoRequest $request, Moreinfo $moreinfo)
    {
        $this->authorize('update', $moreinfo);

        $moreinfo->update($request->validated());

        return redirect()->route('admin.moreinfos.edit', [$moreinfo])
            ->with('success', Moreinfo::getMsgTrans('updated'));
    }

    /**
     * @param Moreinfo $moreinfo
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Moreinfo $moreinfo)
    {
        $this->authorize('delete', $moreinfo);

        $moreinfo->delete();

        return redirect()->route('admin.moreinfos.index')
            ->with('success', Moreinfo::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Moreinfo::class);

        $query = Moreinfo::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Moreinfo::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Moreinfo::dataTableEditColumns($table);

            return $table->make(true);
        }

        Moreinfo::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function storemoreinfo()
    {
        $record = new Moreinfo();
        $record->user_id = Auth::id();
        $record->offert_id = \request('offert_id');
        $record->name = \request('title');
        $record->message = \request('message');
        $record->email = \request('email');
        $record->save();

        return redirect()->back()->with(['message'=>'Abbiamo ricevuto il tuo messaggio, ti contatteremo al più presto']);

    }
}
