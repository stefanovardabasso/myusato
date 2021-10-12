<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;


class Updatemachi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:machi';

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
     * @return int
     */
    public function handle()
    {
        $config = [ 'ashost' => config('main.sap_host'), 'sysnr'  => config('main.sap_sysnr'), 'client' => config('main.sap_client'), 'user' => config('main.sap_user'), 'passwd' => config('main.sap_pass'), ];
        $c = new SapConnection($config);
        $f = $c->getFunction('ZMACCHINE_USATO');
        $result = $f->invoke([
            'IV_REFRESH' => "X",
        ],['rtrim' => true]);

        dd($result['TT_USATO']);
    }
}
