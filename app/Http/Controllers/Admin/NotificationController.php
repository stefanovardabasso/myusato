<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreNotificationRequest;
use App\Http\Requests\Admin\UpdateNotificationRequest;
use App\Models\Admin\Notification;
use App\Models\Admin\Revision;
use Carbon\Carbon;
use function compact;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Admin\Role;
use function route;
use Yajra\DataTables\DataTables;

class NotificationController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Notification::class);

        $dataTableObject = Notification::getDataTableObject('notificationsDataTable', route('admin.datatables.notifications'));

        return view('admin.notifications.index', compact('dataTableObject'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', Notification::class);

        $roles = Role::getSelectOptions();

        $notification = Notification::class;

        return view('admin.notifications.create', compact('roles', 'notification'));
    }

    /**
     * @param StoreNotificationRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(StoreNotificationRequest $request)
    {
        $this->authorize('create', Notification::class);
        $data = $request->validated();

        $data['start'] = Carbon::createFromFormat('d/m/Y H:i', $data['start']);
        $data['end'] = Carbon::createFromFormat('d/m/Y H:i', $data['end']);

        $notification = Notification::createTranslated($data);

        $notification->roles()->sync($request->get('roles'));

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $notification->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.notifications.edit', [$notification])
            ->with('success', Notification::getMsgTrans('created'));
    }

    /**
     * @param \App\Models\Admin\Notification $notification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Notification $notification)
    {
        $this->authorize('view', $notification);

        $revisionsDataTableObject = Revision::getDataTableObject('revisionsDataTable', route('admin.datatables.revisions', ['model_type' => get_class($notification), 'model_id' => $notification->id]));

        return view('admin.notifications.show', compact('notification', 'revisionsDataTableObject'));
    }

    /**
     * @param \App\Models\Admin\Notification $notification
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Notification $notification)
    {
        $this->authorize('update',  $notification);
        $notification->load('roles');

        $roles = Role::getSelectOptions();

        header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
        header("Pragma: no-cache"); // HTTP 1.0.
        header("Expires: 0");

        return view('admin.notifications.edit', compact('notification', 'roles'));
    }

    /**
     * @param UpdateNotificationRequest $request
     * @param \App\Models\Admin\Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $this->authorize('update',  $notification);
        $data = $request->validated();

        $data['start'] = Carbon::createFromFormat('d/m/Y H:i', $data['start']);
        $data['end'] = Carbon::createFromFormat('d/m/Y H:i', $data['end']);

        $notification->updateTranslated($data);

        $notification->revisionableUpdateManyToMany($data);

        $notification->roles()->sync($request->get('roles'));

        if($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $attachment) {
                $notification->addMedia($attachment)->toMediaCollection('attachments');
            }
        }

        return redirect()->route('admin.notifications.edit', [$notification])
            ->with('success', Notification::getMsgTrans('updated'));
    }

    /**
     * @param \App\Models\Admin\Notification $notification
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Notification $notification)
    {
        $this->authorize('delete', $notification);

        $notification->delete();

        return redirect()->route('admin.notifications.index')
            ->with('success', Notification::getMsgTrans('deleted'));
    }

    /**
     * @param \App\Models\Admin\Notification $notification
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxRead(Notification $notification)
    {
        $notification->read();
        $unreadNotificationsCount = Auth::user()->unreadNotifications()->count();

        return response()->json([
            'success' => true,
            'unreadNotificationsCount' => $unreadNotificationsCount,
            'notificationId' => $notification->id,
            'infoMessage' => __('You have :num new notifications', ['num' => $unreadNotificationsCount]),
        ], 201);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajaxGetUnreadNotifications()
    {
        $unreadNotifications = app()->make('unreadNotifications');

        return response()->json([
            'success' => true,
            'unreadNotifications' => $unreadNotifications,
            'infoMessage' => __('You have :num new notifications', ['num' => count($unreadNotifications)]),
        ], 201);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws \Throwable
     */
    public function ajaxGetLatestNotifications()
    {
        $latestNotifications = Auth::user()->getLatestNotifications();

        foreach ($latestNotifications as $latestNotification) {
            $latestNotification->attachments_template = view('partials._attachments', ['item' => $latestNotification])->render();
        }

        return response()->json([
            'success' => true,
            'latestNotifications' => $latestNotifications,
            'markAsReadString' => __('Mark as read'),
        ]);
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function datatable()
    {
        $query = Notification::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);

        $table = Notification::dataTableFilterColumns($table);

        if(!request('export')) {
            $table = Notification::dataTableEditColumns($table);

            return $table->make(true);
        }

        Notification::dataTableExport($table);

        return response()->json([
            'success' => true,
            'message' => __("The export will run in background! When it's done we will notify you via email!")
        ]);
    }
}
