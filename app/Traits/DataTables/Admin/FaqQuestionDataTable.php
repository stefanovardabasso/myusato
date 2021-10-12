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

trait FaqQuestionDataTable
{
    use DataTable;

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTablePreFilter($query)
    {
        if(request('category_id')) {
            $query->where('faq_questions.category_id', request('category_id'));
        }

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSelectRows($query)
    {
        $query->select([
            'id' => 'faq_questions.id',
            'category' => 'faq_categories_trans.title as category',
            'question_text' => 'faq_questions_trans.question_text',
            'answer_text' =>  'faq_questions_trans.answer_text',
            'category_id' => 'faq_questions.category_id',
        ]);

        return $query;
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeDataTableSetJoins($query)
    {
        $query->join('faq_categories', 'faq_questions.category_id', '=', 'faq_categories.id')
            ->leftJoin('faq_categories_trans', function ($join) {
                $join->on('faq_categories.id', '=', 'faq_categories_trans.model_id')
                    ->where('faq_categories_trans.locale', Auth::user()->locale);
            });

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
        $table->filterColumn('category', function ($query, $keyword) {
            $query->whereRaw('faq_categories_trans.title like ?', ["%$keyword%"]);
        });

        $table->filterColumn('question_text', function ($query, $keyword) {
            $query->whereRaw('faq_questions_trans.question_text like ?', ["%$keyword%"]);
        });

        $table->filterColumn('answer_text', function ($query, $keyword) {
            $query->whereRaw('faq_questions_trans.answer_text like ?', ["%$keyword%"]);
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

        $viewAllPermission = Auth::user()->hasPermissionTo('view_all faq_questions');
        $viewOwnPermission = Auth::user()->hasPermissionTo('view_own faq_questions');
        $updateAllPermission = Auth::user()->hasPermissionTo('update_all faq_questions');
        $updateOwnPermission = Auth::user()->hasPermissionTo('update_own faq_questions');
        $deleteAllPermission = Auth::user()->hasPermissionTo('delete_all faq_questions');
        $deleteOwnPermission = Auth::user()->hasPermissionTo('delete_own faq_questions');

        $table->editColumn('actions', function ($row) use($viewAllPermission, $viewOwnPermission, $updateAllPermission, $updateOwnPermission, $deleteAllPermission, $deleteOwnPermission) {
            $routeKey = 'admin.faq-questions';

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
                    'raw' => true,
                ],
                [
                    'data' => 'category', 'className' => 'dt_col_category', 'label' => self::getAttrsTrans('category_id'),
                    'filter' => [ 'type' => "search" ]
                ],
                [
                    'data' => 'question_text', 'className' => 'dt_col_question_text', 'label' => self::getAttrsTrans('question_text'),
                    'filter' => [ 'type' => "search" ],
                    'raw' => true
                ],
                [
                    'data' => 'answer_text', 'className' => 'dt_col_answer_text', 'label' => self::getAttrsTrans('answer_text'),
                    'filter' => [ 'type' => "search" ],
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
            'order' => [ ['category', 'asc'], ['question_text', 'asc'] ],
            'pageLength' => 25
        ];
    }

}
