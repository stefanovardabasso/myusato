<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Component;
use App\Http\Requests\Admin\StoreComponentRequest;
use App\Http\Requests\Admin\UpdateComponentRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;

class ComponentController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Component::class);

        $dataTableObject = Component::getDataTableObject('componentDataTable', route('admin.datatables.components'));

        return view('admin.components.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Component::class);

        $component = Component::class;

        return view('admin.components.create', compact('component'));
    }

    /**
     * @param StoreComponentRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreComponentRequest $request)
    {
        $this->authorize('create', Component::class);

        $component = Component::create($request->validated());

        return redirect()->route('admin.components.edit', [$component])
            ->with('success', Component::getMsgTrans('created'));
    }

    /**
     * @param Component $component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Component $component)
    {
        $this->authorize('view', $component);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($component), 'model_id' => $component->id]));

        return view('admin.components.show', [
            'component' => $component,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Component $component
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Component $component)
    {
        $this->authorize('update', $component);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.components.edit', compact('component'));
    }

    /**
     * @param UpdateComponentRequest $request
     * @param Component $component
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateComponentRequest $request, Component $component)
    {
        $this->authorize('update', $component);

        $component->update($request->validated());

        return redirect()->route('admin.components.edit', [$component])
            ->with('success', Component::getMsgTrans('updated'));
    }

    /**
     * @param Component $component
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Component $component)
    {
        $this->authorize('delete', $component);

        $component->delete();

        return redirect()->route('admin.components.index')
            ->with('success', Component::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Component::class);

        $query = Component::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Component::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Component::dataTableEditColumns($table);

            return $table->make(true);
        }

        Component::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function addcomponents(Request $request)
    {
//return 'hola';

        $record = new Component();
        $record->offert_id = $request->get('offert_id');
        $record->offert_type = $request->get('type_off');
        $record->code = $request->get('fill_code');
        $record->type = $request->get('fill_type');
        $record->material = $request->get('fill_material');
        $record->value = $request->get('fill_value');
        $record->save();

        echo json_encode($record->id);
    }


    public function getcomponents(Request $request)
    {

        $relations['data'] = Component::where('offert_id', '=', $request->get('offert_id'))->where('offert_type', '=', $request->get('type'))->get();

        $val = 0;

        foreach ($relations['data'] as $re){
           $val = $val + $re->value ;
        }




         $relations['val'] = $val;


        echo json_encode($relations);
        exit;

    }
    public function deletecomponents(Request $request)
    {

       $record= Component::query()->where('id',$request->get('id'))->delete();


        echo "Delete successfully";
        exit;

    }
}
