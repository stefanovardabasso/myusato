<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Place;
use App\Http\Requests\Admin\StorePlaceRequest;
use App\Http\Requests\Admin\UpdatePlaceRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use App\Models\Admin\User;
use Yajra\DataTables\DataTables;

class PlaceController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Place::class);

        $dataTableObject = Place::getDataTableObject('placeDataTable', route('admin.datatables.places'));

        return view('admin.places.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Place::class);

        $place = Place::class;

        return view('admin.places.create', compact('place'));
    }

    /**
     * @param StorePlaceRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StorePlaceRequest $request)
    {
        $this->authorize('create', Place::class);

        $place = Place::create($request->validated());

        return redirect()->route('admin.places.edit', [$place])
            ->with('success', Place::getMsgTrans('created'));
    }

    /**
     * @param Place $place
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Place $place)
    {
        $this->authorize('view', $place);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($place), 'model_id' => $place->id]));

        return view('admin.places.show', [
            'place' => $place,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Place $place
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Place $place)
    {
        $this->authorize('update', $place);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.places.edit', compact('place'));
    }

    /**
     * @param UpdatePlaceRequest $request
     * @param Place $place
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePlaceRequest $request, Place $place)
    {
        $this->authorize('update', $place);

        $place->update($request->validated());

        return redirect()->route('admin.places.edit', [$place])
            ->with('success', Place::getMsgTrans('updated'));
    }

    /**
     * @param Place $place
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Place $place)
    {
        $this->authorize('delete', $place);

        $place->deleted_at = date('Y-m-d h:i:s');
        $place->update();

        return redirect()->route('admin.places.index')
            ->with('success', Place::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Place::class);

        $query = Place::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Place::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Place::dataTableEditColumns($table);

            return $table->make(true);
        }

        Place::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function getrole()
    {
        $results = [];
        if(\request('user_id')){
            $user = User::find(\request('user_id'));
            if($user){
                $role =  $user->roles()->first()->id;
            }
            $results['role'] = $role;
        }
        return response()->json($results, 200);
    }

}
