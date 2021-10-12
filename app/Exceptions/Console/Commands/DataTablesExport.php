<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Maatwebsite\Excel\Facades\Excel;

class DataTablesExport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data-tables:export {sql} {columns} {params} {tmpFilePath} {report} {exportClass}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $sql = $this->argument('sql');
            $columns = $this->argument('columns');
            $params = $this->argument('params');
            $tmpFilePath = $this->argument('tmpFilePath');
            $report = $this->argument('report');
            $exportClass = $this->argument('exportClass');
            $locale = $report->creator->locale;

            app()->setLocale($locale);

            Excel::store(new $exportClass($sql, $params, $columns), $tmpFilePath);

            $report->finish($tmpFilePath);

        }catch (\Exception $exception) {
            $message = "";
            $message .= $exception->getMessage().PHP_EOL;
            $message .= $exception->getFile().PHP_EOL;
            $message .= $exception->getLine().PHP_EOL;
            $message .= $exception->getTraceAsString().PHP_EOL;
            $message .= $exception->getCode();

            $report->fail($message);
        }
    }
}
