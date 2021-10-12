<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Admin\Revision;
use App\Models\Admin\Vendorbadge;
use Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin\Place;
use App\Models\Admin\User;
use App\Models\Admin\Role;
use Illuminate\Support\Facades\Request;
use function compact;
use Hash;
use Yajra\DataTables\DataTables;
use function request;
use Illuminate\Routing\Route;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', User::class);

        $dataTableObject = User::getDataTableObject('usersDataTable', route('admin.datatables.users'));

        return view('admin.users.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', User::class);

        $roles = Role::getSelectOptions();
        // $places = Place::getSelectOptions() ;
        $places = Place::whereNull('deleted_at')->get()->pluck('name', 'id');
        // $places = [];
        // foreach ($places_recs as $place_rec) {
        //     $places[$place_rec->id] = $place_rec->name;
        // };

        $user = User::class;

        return view('admin.users.create', compact('roles', 'user', 'places'));
    }

    /**
     * @param StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);

        // Places VALIDATION
        if($request['roles']) {
            $sel_role = $request['roles'][0];
            $role_rec = Role::find($sel_role);
            if($role_rec) {
                $role_id = $role_rec[0];
                // dd("request places: ".$request['places'][0]." - sel_role: ".$sel_role);
                if($sel_role == 2 || $sel_role == 8){
                    if($request['places']){
                        $place_rec = Place::find($request['places'][0]);
                        if(!$place_rec) {
                            return redirect()->route('admin.users.create')
                            ->with('error', 'La sede è un campo richiesto per questo ruolo, inserire un valore corretto.');
                        }
                    } else {
                        return redirect()->route('admin.users.create')
                        ->with('error', 'La sede è un campo richiesto per questo ruolo, inserire un valore corretto.')
                        ->withInput($request->input());
                    }
                }
            }

        }

        $data = $request->validated();

        $user = User::create($data);

        $user->roles()->sync($request->get('roles'));

        if($request->file('image')) {
            $user->clearMediaCollection('profile-image');
            $user->addMediaFromRequest('image')->toMediaCollection('profile-image');
        }

        // Save place_id and user_id in the pivot table place_user,
        // just for "Venditori" and "Venditori AV" roles
        $user_role = $user->roles()->first()->id;
        if($user_role == 2 || $user_role == 8) {
            if($request->places) {
                // assign place
                $user->places()->sync($request->places[0]);
            } else {
                return redirect()->route('admin.users.create')
                ->with('error', 'La sede è un campo richiesto per questo ruolo, inserire un valore corretto.')
                ->withInput($request->input());
            }
        }

        return redirect()->route('admin.users.edit', [$user])
            ->with('success', User::getMsgTrans('created'));
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(User $user)
    {
        $this->authorize('view', $user);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($user), 'model_id' => $user->id]));

        return view('admin.users.show', compact('user', 'revisionsDataTableObject'));
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(User $user)
    {
        $this->authorize('update', $user);

        $user->load('roles');
        $roles = Role::getSelectOptions();
        // $places = Place::getSelectOptions();
        $places = Place::whereNull('deleted_at')->get()->pluck('name', 'id');
        $user_role = $user->roles()->first()->id;

        $user_place_rec = $user->places()->first();
        if($user_place_rec) {
            $user_place = $user_place_rec->id;
        } else {
            $user_place = null;
        }

        $user_badge_rec = Vendorbadge::query()->where('user_id','=',$user->id)->first();

        if($user_badge_rec){
            $user_badge = $user_badge_rec->badge;
            $user->user_badge = $user_badge;
        }else{
            $user_badge = null;
            $user->user_badge = $user_badge;
        }

        $sections = config('sections');

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.users.edit', compact('user', 'roles', 'places', 'sections', 'user_role','user_place','user_badge' ));
    }

    /**
     * @param UpdateUserRequest $request
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = $request->validated();
        $old_role = $user->roles()->first()->id;
        $user->update($data);
        $user->revisionableUpdateManyToMany($data);

        if(Auth::user()->can('assign_roles', User::class)) {
            $user->roles()->sync($data['roles']);

            // Save place_id and user_id in the pivot table place_user, just for "Venditori" and "Venditori AV" roles
            $user_role = $user->roles()->first()->id;
            if($user_role == 2 || $user_role == 8) {
                if($request->places) {
                    $place_rec = Place::find($request['places'][0]);
                        if($place_rec) {
                            $user->places()->sync($request->places[0]);
                        } else {
                            return redirect()->route('admin.users.edit', $user)
                            ->with('error', 'La sede è un campo richiesto per questo ruolo, inserire un valore corretto.')
                            ->withInput($request->input());
                        }

                } else {
                    return redirect()->route('admin.users.edit', $user)
                    ->with('error', 'La sede è un campo richiesto per questo ruolo.')
                    ->withInput($request->input());
                }
                if($request->user_badge){
                          $badge_rec = Vendorbadge::query()->where('user_id','=',$user->id)->first();

                          if($badge_rec){
                              $badge_rec->user_id = $user->id;
                              $badge_rec->badge = $request->user_badge;
                              $badge_rec->update();
                          }else{
                              $rec = new Vendorbadge();
                              $rec->user_id = $user->id;
                              $rec->badge = $request->user_badge;
                              $rec->save();
                          }

                }else{
                    return redirect()->route('admin.users.edit', $user)
                        ->with('error', 'Il badge its required.')
                        ->withInput($request->input());
                }
            } else if ($old_role == 2 || $old_role == 8) {
                $user->places()->detach();
            }
        }

        return redirect()->route('admin.users.edit', [$user])
            ->with('success', User::getMsgTrans('updated'));
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(User $user)
    {
        $this->authorize('delete', $user);
        $user->site_active = 0;
        $user->deleted_at = date('Y-m-d h:i:s');
        $user->update();

        return redirect()->route('admin.users.index')
            ->with('success', User::getMsgTrans('deleted'));
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxSearch()
    {
        $users = User::search(\request('needle'));

        return response()->json($users);
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ajaxGivePermission(User $user)
    {
        $this->authorize('update_permissions', User::class);

        $this->validate(request(), [
            'permission' => 'required|exists:permissions,name',
        ]);

        $user->addPermission(request('permission'));

        return response()->json([
            'success' => true,
            'message' => __('Permission created successfully!')
        ], 201);
    }

    /**
     * @param \App\Models\Admin\User $user
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ajaxRevokePermission(User $user)
    {
        $this->authorize('update_permissions', User::class);

        $this->validate(request(), [
            'permission' => 'required|exists:permissions,name',
        ]);

        $user->removePermission(request('permission'));

        return response()->json([
            'success' => true,
            'message' => __('Permission removed successfully!')
        ], 201);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $activityStatusTimeIntervalInactive = config('main.activity_status_time_intervals.inactive');
        $activityStatusTimeIntervalOffline = config('main.activity_status_time_intervals.offline');

        $query = User::query();
        $query->dataTableSelectRows($activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline)
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);

        $table = User::dataTableFilterColumns($table, $activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline);

        if(!request('export')) {
            $table = User::dataTableEditColumns($table);

            return $table->make(true);
        }

        User::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }

    public function list($type)
    {
        $this->authorize('view_index', User::class);

        $dataTableObject = User::getDataTableObject('usersDataTableIncluded', route('admin.datatables.users', ['role_id' => $type]));
        if($type == '1'){
           $tit = 'Amministratori';
        }elseif ($type == '5') {
            $tit = 'Amministratori B';
        }elseif ($type == '2') {
            $tit = 'Venditori interni';
        }elseif($type == '8'){
            $tit = 'Venditori AV';
        }elseif ($type == '3'){
            $tit = 'Commercianti ';
        }elseif ($type == '4'){
            $tit = 'Clienti finali';
        }

        return view('admin.users.userdetail', compact('dataTableObject', 'tit'));

    }

    public function datatabledetail($type)
    {
        $activityStatusTimeIntervalInactive = config('main.activity_status_time_intervals.inactive');
        $activityStatusTimeIntervalOffline = config('main.activity_status_time_intervals.offline');

        $query = User::query();
        $query->dataTableSelectRows($activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline)
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);

        $table = User::dataTableFilterColumns($table, $activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline);

        if(!request('export')) {
            $table = User::dataTableEditColumns($table);

            return $table->make(true);
        }

        User::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);

    }
}
