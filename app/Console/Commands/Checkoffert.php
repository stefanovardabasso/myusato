<?php

namespace App\Console\Commands;

use App\Models\Admin\Offert;
use Illuminate\Console\Command;

class Checkoffert extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:offert';

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
       $offerts = Offert::query()->where('status','=','1')->get();

       foreach ($offerts as $off){
           
       }

    }
}
