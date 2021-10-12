<?php

namespace App\Http\Controllers\Admin;

use App\InternalEvent;
use App\ODL;
use App\Team;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class DataTableController extends Controller
{
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function saveUserView()
    {
        $user = Auth::user();
        $targetTable = request('target_table');

        $tableParams = request('table_params');
       // dd($tableParams);
        $viewName = request('view_name') ?? 'Default';
        $user->update([
            'settings->data_tables->' . $targetTable . '->views->' . $viewName => json_decode($tableParams, true),
            'settings->data_tables->' . $targetTable . '->last_used_view' => $viewName,
        ]);
        return redirect()->back()
            ->with(['success' => __('Table view saved successfully!')]);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteUserView()
    {
        $user = Auth::user();
        $targetTable = request('target_table');
        $viewName = request('view_name');

        if(isset($user->settings['data_tables'][$targetTable][$viewName])) {
            $tableViews = $user->settings['data_tables'][$targetTable];

            unset($tableViews[$viewName]);

            $user->update([
                'settings->data_tables->' . $targetTable  => $tableViews
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => __('Table view deleted successfully!'),
        ]);
    }
}