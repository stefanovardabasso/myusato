<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SoapClient;
class Callapis extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:apis';

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
        $this->call('call:macu');
        $this->call('call:supralift');
        $this->call('call:tuttocarrelli');
    }
}
