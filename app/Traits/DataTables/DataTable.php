<?php

namespace App\Traits\DataTables;

use App\Models\Admin\Report;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;

trait DataTable
{
    /**
     * @param $query
     * @param $columns
     * @return mixed
     */
    public function scopeDataTableSelect($query, $columns)
    {
        $columnsEdited = [];
        if(request('export')) {
            $columnsEdited = $this->dataTableExportQueryColumns($columns);
        } else {
            $columnsEdited = $this->dataTableQueryColumns($columns);
        }

        return $query->select($columnsEdited);
    }

    /**
     * @param $columns
     * @return array
     */
    private function dataTableQueryColumns($columns)
    {
        return $columns;
    }

    /**
     * @param $query
     * @param $columns
     * @return array
     */
    private function dataTableExportQueryColumns($columns)
    {
        $reqColumns = request('columns');
        $selectColumns = [];

        foreach ($columns as $sqlColumn => $sql) {
            foreach ($reqColumns as $reqColumn) {
                if(!isset($reqColumn['visible']) || !isset($reqColumn['data'])) {
                    continue;
                }
                if ($reqColumn['visible'] == 'true' && $reqColumn['data'] == $sqlColumn) {
                    $selectColumns[$sqlColumn] = $sql;
                }
            }
        }

        return $selectColumns;
    }

    /**
     * @param $table
     */
    public static function dataTableSetRawColumns($table)
    {
        $dtObject = self::getDataTableObject(null, null);
        $rawColumns = [];

        foreach ($dtObject['columns'] as $dtColumn) {
            if (!empty($dtColumn['raw'])) {
                $rawColumns[] = $dtColumn['data'];
            }
        }

        $table->rawColumns($rawColumns);
    }

    /**
     * @param $table
     * @param $modelTarget
     * @param $columns
     * @param string $exportClass
     */
    private static function dataTableQueueExport($table, $columns, $exportClass = '\App\Exports\DataTableExport')
    {
        $sql = $table->getFilteredQuery()->toSql();
        $params = $table->getFilteredQuery()->getBindings();
        $tmpFilePath = 'tmp/' . time() . '_' . Auth::id() . '-' . self::getTitleTrans() . '.xlsx';
        $report = Report::start(self::class);

        Artisan::queue('data-tables:export', [
            'sql' => $sql,
            'columns' => $columns,
            'params' => $params,
            'tmpFilePath' => $tmpFilePath,
            'report' => $report,
            'exportClass' => $exportClass
        ]);
    }

    /**
     * @param array $removeColumns
     * @return array
     */
    private static function dataTableExportColumns($removeColumns = [])
    {
        $columns = [];
        $reqColumns = request('columns');
        $dtObject = self::getDataTableObject(null, null);

        foreach ($reqColumns as $reqColumn) {
            if(
                !isset($reqColumn['visible']) || $reqColumn['visible'] == 'false'
                || !isset($reqColumn['data']) || in_array($reqColumn['data'], $removeColumns)
            ) {
                continue;
            }

            foreach ($dtObject['columns'] as $dtColumn) {
                if(!isset($dtColumn['label']) || !isset($dtColumn['data'])) {
                    continue;
                }
                if ($dtColumn['data'] == $reqColumn['data']) {
                    $columns[$reqColumn['data']] = [
                        'column'        => $reqColumn['data'],
                        'translation'   => $dtColumn['label']
                    ];
                }
            }
        }

        return $columns;
    }

    /**
     * @param $options
     * @return \Illuminate\Support\Collection
     */
    private static function dataTableBuildSelectFilter($options)
    {
        $filter = [];

        foreach ($options as $value => $label) {
            $filter[] = (object) [
                'value' => $value,
                'label' => $label
            ];
        }

        return collect($filter);
    }
}
