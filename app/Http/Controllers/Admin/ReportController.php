<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Report;
use App\Http\Controllers\Controller;
use function compact;
use function route;
use Yajra\DataTables\DataTables;

class ReportController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('view_index', Report::class);

        $dataTableObject = Report::getDataTableObject('reportsDataTable', route('admin.datatables.reports'));

        return view('admin.reports.index', compact('dataTableObject'));
    }

    /**
     * @param \App\Models\Admin\Report $report
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Report $report)
    {
        $this->authorize('delete', $report);

        $report->delete();

        return redirect()->route('admin.reports.index')
            ->with('success', Report::getMsgTrans('deleted'));
    }

    /**
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function datatable()
    {
        $this->authorize('view_index', Report::class);

        $query = Report::query();
        $query->dataTableSelectRows()
            ->dataTableSetJoins()
            ->dataTablePreFilter()
            ->dataTableGroupBy();

        $table = Datatables::of($query);

        $table = Report::dataTableFilterColumns($table);

        $table = Report::dataTableEditColumns($table);

        return $table->make(true);
    }
}
