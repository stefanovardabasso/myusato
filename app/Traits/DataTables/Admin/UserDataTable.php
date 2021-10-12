<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Role;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use function request;

trait UserDataTable
{
    use DataTable;

    /**
     * @param $query
     * @param $activityStatusTimeIntervalInactive
     * @param $activityStatusTimeIntervalOffline
     * @return mixed
     */
    public function scopeDataTableSelectRows($query, $activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline)
    {
        $query->select([
            'id' => 'users.id',
            'name' => 'users.name as name',
            'surname' => 'users.surname as surname',
            'email' => 'users.email as email',
            'activated' => DB::raw("IF(users.active, TRUE, FALSE) as activated"),
            'roles_name' => DB::raw('(
                    SELECT GROUP_CONCAT(DISTINCT roles_trans.role_name separator ", ")
                    FROM model_has_roles as mhr
                    JOIN roles_trans ON mhr.role_id = roles_trans.role_id
                    WHERE mhr.model_id = users.id AND roles_trans.locale = "' . app()->getLocale() .'"
                ) as roles_name'),
            'logged_status' => DB::raw("
                    IF( users.logged
                            AND users.last_activity IS NOT NULL
                            AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) < $activityStatusTimeIntervalInactive ,
                        'active', IF( users.logged
                                        AND users.last_activity IS NOT NULL
                                        AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) >= $activityStatusTimeIntervalInactive
                                        AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) < $activityStatusTimeIntervalOffline ,
                                    'inactive',
                                    'offline')
                    ) as logged_status
                "),
        ])->where('deleted_at','=',null);

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        if(!Auth::user()->can('view_all', \App\Models\Admin\User::class)) {
            $query->where('users.id', Auth::id());
        }

        if(request('role_id')) {
            $query->whereHas('roles', function ($query) {
                $query->where('roles.id', request('role_id'));
            });
        }

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableGroupBy($query)
    {
        return $query->groupBy('users.id');
    }


    /**
     * @param $table
     * @param $activityStatusTimeIntervalInactive
     * @param $activityStatusTimeIntervalOffline
     * @return mixed
     */
    public static function dataTableFilterColumns($table, $activityStatusTimeIntervalInactive, $activityStatusTimeIntervalOffline)
    {
        $table->filterColumn('roles_name', function ($query, $keyword) {
            $query->where(function ($query) use ($keyword) {
                $roleIds = explode("|", $keyword);
                $query->whereHas('roles', function ($query) use ($roleIds) {
                    foreach ($roleIds as $key => $val) {
                        if($key == 0) {
                            $query->where("roles.id", $val);
                        }else{
                            $query->orWhere("roles.id", $val);
                        }
                    }
                });
            });
        });

        $table->filterColumn('logged_status', function ($query, $keyword) use($activityStatusTimeIntervalOffline, $activityStatusTimeIntervalInactive) {
            $query->whereRaw("
                    IF( users.logged
                            AND users.last_activity IS NOT NULL
                            AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) < $activityStatusTimeIntervalInactive ,
                        'active', IF( users.logged
                                        AND users.last_activity IS NOT NULL
                                        AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) >= $activityStatusTimeIntervalInactive
                                        AND TIMESTAMPDIFF(MINUTE, users.last_activity, now()) < $activityStatusTimeIntervalOffline ,
                                    'inactive',
                                    'offline')
                    ) = ?
                ", [$keyword]);
        });

        $table->filterColumn('activated', function ($query, $keyword) {
            return $query->where('users.active', 'like', DB::raw("'%$keyword%'"));
        });

        return $table;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableEditColumns($table)
    {
        self::dataTableSetRawColumns($table);

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all users');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own users');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all users');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own users');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all users');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own users');

        $table->addColumn('actions', '&nbsp;');
        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.users';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        $table->editColumn('roles_name', function ($row) {
            $roles =  explode(',', $row->roles_name);
            $output = [];
            foreach ($roles as $role) {
                if(!empty($role)) {
                    $tmp = "<span class=\"label label-info\">".__($role)."</span>";
                    $output []= $tmp;
                }
            }
            $output = implode(" ", $output);

            return $output;
        });

        $table->editColumn('logged_status', function ($row) {
            switch ($row->logged_status) {
                case 'offline':
                    $title = __('Offline');
                    $class = 'text-red';
                    break;
                case 'inactive':
                    $title = __('Firm');
                    $class = 'text-orange';
                    break;
                default:
                    $title = __('Online');
                    $class = 'text-green';
                    break;
            }
            return "<i class=\"fa fa-circle online-offline $class \" title=\"$title\"></i>";
        });

        $table->editColumn('activated', function ($row) {
            return view('admin.datatables.partials._tag-yes-no', ['bool' => $row->activated]);
        });

        return $table;
    }

    /**
     * @param $table
     */
    public static function dataTableExport($table)
    {
        $columns = self::dataTableExportColumns(['actions']);
        if (!empty($columns['logged_status'])) {
            $columns['logged_status']['value_translations'] = [
                'active' => __('Online'),
                'inactive' => __('Firm'),
                'offline' => __('Offline')
            ];
        }
        self::dataTableQueueExport($table, $columns);
    }

    /**
     * @return array
     */
    public static function getSelectsFilters(): array
    {
        $roles = Role::transformForSelectsFilters(Role::getSelectFilter());

        $activated = self::dataTableBuildSelectFilter(self::getEnumsTrans('active'));

        $loggedStatus = collect([
            (object)[
                'value' => 'offline',
                'label' => __('Offline')
            ],
            (object)[
                'value' => 'inactive',
                'label' => __('Firm')
            ],
            (object)[
                'value' => 'active',
                'label' => __('Online')
            ],
        ]);

        return [
            'roles' => $roles,
            'activated' => $activated,
            'logged_status' => $loggedStatus,
        ];
    }

    /**
     * @param $tableId
     * @param $route
     * @return array
     */
    public static function getDataTableObject($tableId, $route)
    {
        $filters = self::getSelectsFilters();

        return [
            'id' => $tableId,
            'columns' => [
                [
                    'data' => 'actions',
                    'searchable' => false,
                    'sortable' => false,
                    'className' => 'dt_col_actions',
                    'label' => __('Actions'),
                    'raw' => true
                ],
                [
                    'data' => 'name', 'className' => 'dt_col_name', 'label' => self::getAttrsTrans('name'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'surname', 'className' => 'dt_col_surname', 'label' => self::getAttrsTrans('surname'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'email', 'className' => 'dt_col_email', 'label' => self::getAttrsTrans('email'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'roles_name', 'className' => 'dt_col_roles_name', 'label' => self::getAttrsTrans('roles'),
                    'filter' => [
                        'type' => "select-multi",
                        'options' => $filters['roles']
                    ],
                    'raw' => true
                ],
                [
                    'data' => 'activated', 'className' => 'dt_col_activated', 'label' => self::getAttrsTrans('active'),
                    'filter' => [
                        'type' => "select",
                        'options' => $filters['activated']
                    ],
                    'raw' => true
                ],
                [
                    'data' => 'logged_status', 'className' => 'dt_col_logged_status', 'label' => self::getAttrsTrans('logged'),
                    'filter' => [
                        'type' => "select",
                        'options' => $filters['logged_status']
                    ],
                    'raw' => true
                ],
            ],
            'ajax' => [
                'url' => $route,
                'method' => 'POST',
                'data' => [
                    '_token' => csrf_token(),
                    'roles' => []
                ],
            ],
            'order' => [ ['name', 'asc'] ],
            'pageLength' => 25
        ];
    }

}
