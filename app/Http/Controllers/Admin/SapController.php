<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Sap;
use App\Http\Requests\Admin\StoreSapRequest;
use App\Http\Requests\Admin\UpdateSapRequest;
use App\Http\Controllers\Controller;
use App\Models\Admin\Revision;
use Yajra\DataTables\DataTables; 
use Illuminate\Http\Request;
use App\Models\Admin\User;
use Response;

class SapController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Sap::class);

        $dataTableObject = Sap::getDataTableObject('sapDataTable', route('admin.datatables.saps'));

        return view('admin.saps.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Sap::class);

        $sap = Sap::class;

        return view('admin.saps.create', compact('sap'));
    }

    /**
     * @param StoreSapRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreSapRequest $request)
    {
        $this->authorize('create', Sap::class);

        $sap = Sap::create($request->validated());

        return redirect()->route('admin.saps.edit', [$sap])
            ->with('success', Sap::getMsgTrans('created'));
    }

    /**
     * @param Sap $sap
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Sap $sap)
    {
        $this->authorize('view', $sap);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($sap), 'model_id' => $sap->id]));

        return view('admin.saps.show', [
            'sap' => $sap,
            'revisionsDataTableObject' => $revisionsDataTableObject,
        ]);
    }

    /**
     * @param Sap $sap
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Sap $sap)
    {
        $this->authorize('update', $sap);

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.saps.edit', compact('sap'));
    }

    /**
     * @param UpdateSapRequest $request
     * @param Sap $sap
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateSapRequest $request, Sap $sap)
    {
        $this->authorize('update', $sap);

        $sap->update($request->validated());

        return redirect()->route('admin.saps.edit', [$sap])
            ->with('success', Sap::getMsgTrans('updated'));
    }

    /**
     * @param Sap $sap
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Sap $sap)
    {
        $this->authorize('delete', $sap);

        $sap->delete();

        return redirect()->route('admin.saps.index')
            ->with('success', Sap::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Sap::class);

        $query = Sap::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);
        $table = Sap::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Sap::dataTableEditColumns($table);

            return $table->make(true);
        }

        Sap::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function access(Request $request)
    {      

         
         
          $app = json_decode($request->getContent(), true);
         
        
          if($app['secret_key'] == 'q38AsfR6IzYYgN48CfhSOHlnIPG0zLJiwVQW7aVa1iScuAejHxw2' & $app['client_id'] == '3MVG9llQY5kM9T6fhdZ7IeYpDjx0ZrpK4HE93lXBWjOE2qAte2czswK'){
         
           $user =   User::where('id', '=', '1')->first();
           
        $length = 40;
        $pool = '0123456789abcdefghijklmnopqrstuvwxyz';
        $track = substr(str_shuffle(str_repeat($pool, 5)), 0, $length);

           $user->remember_token = $track;
           $user->update();
            
            return Response::json([
                    'access_token' => $track,
                    'expires_in' => '3599'
                ], 200); // Status code here
          }else{
            
            return Response::json([
                    'msj' => 'error'
                ], 403);

          }

          
    }

    public function insert(Request $request)
    {
        $header = $request->header('Authorization');
        $token = explode(' ', $header);
        $app = json_decode($request->getContent(), true);
     

      $user =   User::where('remember_token', '=', $token[1])->first();

      if(isset($user->id)){

              if(isset($app['last_update'])){
                   
                  $record = new Sap();
                    

                  if(isset($app['last_update'])){ $record->date = $app['last_update']; }
                  if(isset($app['rif_cls'])){ $record->rif_cls = $app['rif_cls']; }
                  if(isset($app['brand'])){ $record->brand = $app['brand']; }
                  if(isset($app['test_array']['model'])){ $record->model = $app['test_array']['model']; }
                  if(isset($app['test_array']['family'])){ $record->family = $app['test_array']['family']; }

                   
                    $record->save();

              }else{

                return Response::json([
                    "success"=>"false",
                    "errorMsg"=>"last_update its required"
                ], 403);

              }
              

               





        return Response::json([
                    "success" => "ok" 
                ], 200);



      }else{

            return Response::json([
                    "success"=>"false",
                    "errorMsg"=>"wrong token"
                ], 403);


      }

      print_r($token[1]);
      print_r($app);
    }

}
