<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Report;
use App\Models\Admin\Role;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

trait ReportDataTable
{
    use DataTable;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        if(!Auth::user()->can('view_all', Report::class)) {
            $query->where('reports.creator_id', Auth::id());
        }

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSelectRows($query)
    {
        return $query->select([
            'reports.id as id',
            'reports.creator_id as creator_id',
            'reports.model_target as model_target',
            'reports.date_start as date_start',
            'reports.date_end as date_end',
            'reports.state as state',
            DB::raw('CONCAT(c.name, " ", c.surname) as creator'),
            'reports.message as message',
            'm.id as media_id',
        ]);
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {
        $query->join('users as c', 'reports.creator_id', '=', 'c.id');
        $query->leftJoin('media as m', function($join){
            $join->on('reports.id', '=', 'm.model_id');
            $join->on('m.model_type', '=', DB::raw('"App\\\Models\\\Admin\\\Report"'));
        });

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableGroupBy($query)
    {
        $query->groupBy('reports.id');

        return $query;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableFilterColumns($table)
    {
        $table->filterColumn('date_start', function ($query, $keyword) {
            $dates = explode(' - ', $keyword);
            if(count($dates) == 2) {
                $startDatetime = Carbon::createFromFormat('d/m/Y H:i', $dates[0]);
                $endDatetime= Carbon::createFromFormat('d/m/Y H:i', $dates[1]);
                $query->whereBetween('reports.date_start', [$startDatetime->format('Y-m-d H:i:00'), $endDatetime->format('Y-m-d H:i:59')]);
            }
        });

        $table->filterColumn('date_end', function ($query, $keyword) {
            $dates = explode(' - ', $keyword);
            if(count($dates) == 2) {
                $startDatetime = Carbon::createFromFormat('d/m/Y H:i', $dates[0]);
                $endDatetime= Carbon::createFromFormat('d/m/Y H:i', $dates[1]);
                $query->whereBetween('reports.date_end', [$startDatetime->format('Y-m-d H:i:00'), $endDatetime->format('Y-m-d H:i:59')]);
            }
        });

        $table->filterColumn('creator', function ($query, $keyword) {
            $query->whereRaw("CONCAT(c.name, ' ', c.surname) like ?", ["%$keyword%"]);
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

        $viewAllPermission = false;
        $viewOwnPermission = false;
        $updateAllPermission = false;
        $updateOwnPermission = false;
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all reports');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own reports');
        $downloadAllPermission = Auth::user()->hasPermissionTo('download_all reports');
        $downloadOwnPermission = Auth::user()->hasPermissionTo('download_own reports');

        $table->editColumn('model_target', function ($row) {
            if (method_exists($row->model_target, 'getTitleTrans')) {
                return $row->model_target::getTitleTrans();
            } else {
                return __($row->model_target);
            }
        });
        $table->editColumn('date_start', function ($row) {
            return $row->date_start->format('d/m/Y H:i');
        });

        $table->editColumn('date_end', function ($row) {
            return $row->date_end ? $row->date_end->format('d/m/Y H:i') : null;
        });

        $table->addColumn('elapsed', '&nbsp;');
        $table->editColumn('elapsed', function ($row) {
            if($row->date_end){
                return strtotime($row->date_end) - strtotime($row->date_start) . ' ' . __('seconds');
            }
            return time() - strtotime($row->date_start) . ' ' . __('seconds');
        });

        $table->editColumn('state', function ($row) {
            return view('admin.datatables.partials._states', ['state' => $row->state]);
        });

        $table->addColumn('actions', '&nbsp;');
        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.reports';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        $table->addColumn('download', '&nbsp;');
        $table->editColumn('download', function ($row) use($downloadAllPermission, $downloadOwnPermission) {
            return view('admin.datatables.partials._download-btn', compact('row', 'downloadAllPermission', 'downloadOwnPermission'));
        });

        return $table;
    }

    /**
     * @return array
     */
    public static function getSelectsFilters(): array
    {
        return [
            'states' => self::dataTableBuildSelectFilter(self::getEnumsTrans('state')),
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
                    'data' => 'download',
                    'searchable' => false,
                    'sortable' => false,
                    'className' => 'dt_col_download',
                    'label' => __('Download'),
                    'raw' => true
                ],
                [
                    'data' => 'model_target', 'className' => 'dt_col_model_target', 'label' => self::getAttrsTrans('model_target'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'date_start', 'className' => 'dt_col_date_start', 'label' => self::getAttrsTrans('date_start'),
                    'filter' => [ 'type' => "datetime-range-picker" ]
                ],
                [
                    'data' => 'date_end', 'className' => 'dt_col_date_end', 'label' => self::getAttrsTrans('date_end'),
                    'filter' => [ 'type' => "datetime-range-picker" ]
                ],
                [
                    'data' => 'elapsed', 'searchable' => false, 'sortable' => false, 'className' => 'dt_col_elapsed', 'label' => __('elapsed-form-label'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'state', 'className' => 'dt_col_state', 'label' => self::getAttrsTrans('state'),
                    'filter' => [
                        'type' => "select",
                        'options' => $filters['states']
                    ],
                    'raw' => true
                ],
                [
                    'data' => 'creator', 'className' => 'dt_col_creator', 'label' => self::getAttrsTrans('creator_id'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'message', 'className' => 'dt_col_message', 'label' => self::getAttrsTrans('message'),
                    'filter' => [ 'type' => "search" ]
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
            'order' => [ ['date_start', 'desc'] ],
            'pageLength' => 25
        ];
    }
}
