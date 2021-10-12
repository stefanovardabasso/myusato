<?php

namespace App\Traits\DataTables\Admin;

use App\Models\Admin\Report;
use App\Traits\DataTables\DataTable;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function request;
use function time;

trait FaqCategoryDataTable
{
    use DataTable;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSelectRows($query)
    {
        return $query->select([
            'id'    => 'id',
            'title' => 'faq_categories_trans.title',
        ]);
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
        return $query;
    }

    /**
     * @param $table
     * @return mixed
     */
    public static function dataTableFilterColumns($table)
    {
        $table->filterColumn('title', function ($query, $keyword) {
            $query->whereRaw('faq_categories_trans.title like ?', ["%$keyword%"]);
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all faq_categories');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own faq_categories');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all faq_categories');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own faq_categories');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all faq_categories');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own faq_categories');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.faq-categories';

            return view('admin.datatables.partials._actions', compact('row', 'routeKey', 'viewAllPermission', 'viewOwnPermission', 'updateAllPermission', 'updateOwnPermission', 'deleteAllPermission', 'deleteOwnPermission'));
        });

        return $table;
    }

    /**
     * @param $table
     */
    public static function dataTableExport($table)
    {
        $columns = self::dataTableExportColumns(['actions']);
        self::dataTableQueueExport($table, $columns);
    }

    /**
     * @param $tableId
     * @param $route
     * @return array
     */
    public static function getDataTableObject($tableId, $route)
    {
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
                    'data' => 'title', 'className' => 'dt_col_title', 'label' => self::getAttrsTrans('title'),
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
            'order' => [ ['title', 'asc'] ],
            'pageLength' => 25
        ];
    }

}
