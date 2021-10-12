<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Offert;
use App\Models\Admin\Option;
use App\Http\Requests\Admin\StoreOptionRequest;
use App\Http\Requests\Admin\UpdateOptionRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Product;
use App\Models\Admin\Revision;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Models\Admin\User;

class OptionController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Option::class);

        $dataTableObject = Option::getDataTableObject('optionDataTable', route('admin.datatables.options'));

        return view('admin.options.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Option::class);

        $option = Option::class;

        return view('admin.options.create', compact('option'));
    }

    /**
     * @param StoreOptionRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreOptionRequest $request)
    {
        $this->authorize('create', Option::class);

        $option = Option::create($request->validated());

        return redirect()->route('admin.options.edit', [$option])
            ->with('success', Option::getMsgTrans('created'));
    }

    /**
     * @param Option $option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Option $option)
    {
        $this->authorize('view', $option);

        $list = Offert::query()->where('id','=',$option->offer_id)->first();
        $user = User::query()->where('id','=',$option->user_id)->first();

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($option), 'model_id' => $option->id]));

        return view('admin.options.show', [
            'option' => $option,
            'revisionsDataTableObject' => $revisionsDataTableObject,
            'offert' => $list,
            'user' => $user
        ]);
    }

    /**
     * @param Option $option
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Option $option)
    {
        $this->authorize('update', $option);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.options.edit', compact('option'));
    }

    /**
     * @param UpdateOptionRequest $request
     * @param Option $option
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateOptionRequest $request, Option $option)
    {
        $this->authorize('update', $option);

        $option->update($request->validated());

        return redirect()->route('admin.options.edit', [$option])
            ->with('success', Option::getMsgTrans('updated'));
    }

    /**
     * @param Option $option
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Option $option)
    {
        $this->authorize('delete', $option);

        $option->delete();

        return redirect()->route('admin.options.index')
            ->with('success', Option::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Option::class);

        $query = Option::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Option::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Option::dataTableEditColumns($table);

            return $table->make(true);
        }

        Option::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function myoptions(){

        $myoptions = Option::query()->where('user_id','=',Auth::id())->get();
        $cot = [];
        $cot[0]= Option::query()->where('user_id','=',Auth::id())->where('status','=',0)->first();
        $cot[1]= Option::query()->where('user_id','=',Auth::id())->where('status','=',1)->first();
        $cot[2]= Option::query()->where('user_id','=',Auth::id())->where('status','=',3)->first();
        $prio =[];
        $prod =[];
        $offert=[];
        foreach ($myoptions as $option){
            $offert[$option->id] = Offert::query()->where('id','=',$option->offer_id)->first();
            $prod[$option->id]= Product::query()->where('id','=', $offert[$option->id]->id_product)->first();
            $prio[$option->id] = Option::query()->where('offer_id','=', $option->offer_id)->where('id','<',$option->id)->get();
        }



        return view('site.myoptions',['myoptions'=>$myoptions,'offerts'=>$offert,'prods'=>$prod,'prio'=>$prio,'cot'=>$cot]);
    }
    public function deleteoptions(){

        $myoptions = Option::query()->where('id','=', \request('option_id'))->first();
        $myoptions->status=1;
        $myoptions->update();


        return redirect()->back()->with(['message'=>'Abbiamo modificato il status de la opzione']);


    }
}
