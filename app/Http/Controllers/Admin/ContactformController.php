<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Contactform;
use App\Http\Requests\Admin\StoreContactformRequest;
use App\Http\Requests\Admin\UpdateContactformRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;

class ContactformController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Contactform::class);

        $dataTableObject = Contactform::getDataTableObject('contactformDataTable', route('admin.datatables.contactforms'));

        return view('admin.contactforms.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Contactform::class);

        $contactform = Contactform::class;

        return view('admin.contactforms.create', compact('contactform'));
    }

    /**
     * @param StoreContactformRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreContactformRequest $request)
    {
        $this->authorize('create', Contactform::class);

        $contactform = Contactform::create($request->validated());

        return redirect()->route('admin.contactforms.edit', [$contactform])
            ->with('success', Contactform::getMsgTrans('created'));
    }

    /**
     * @param Contactform $contactform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Contactform $contactform)
    {
        $this->authorize('view', $contactform);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($contactform), 'model_id' => $contactform->id]));

        return view('admin.contactforms.show', [
            'contactform' => $contactform,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Contactform $contactform
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Contactform $contactform)
    {
        $this->authorize('update', $contactform);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.contactforms.edit', compact('contactform'));
    }

    /**
     * @param UpdateContactformRequest $request
     * @param Contactform $contactform
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateContactformRequest $request, Contactform $contactform)
    {
        $this->authorize('update', $contactform);

        $contactform->update($request->validated());

        return redirect()->route('admin.contactforms.edit', [$contactform])
            ->with('success', Contactform::getMsgTrans('updated'));
    }

    /**
     * @param Contactform $contactform
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Contactform $contactform)
    {
        $this->authorize('delete', $contactform);

        $contactform->delete();

        return redirect()->route('admin.contactforms.index')
            ->with('success', Contactform::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Contactform::class);

        $query = Contactform::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Contactform::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Contactform::dataTableEditColumns($table);

            return $table->make(true);
        }

        Contactform::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
