<?php

namespace App\Console\Commands;

use App\Models\Admin\Option;
use Illuminate\Console\Command;

class Optioncheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'option:check';

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
        // status of option
        //0 -> attive
        //1 -> Scaduti
        //3 -> Assegnato
       $date_today= date('Y-m-d h:i:s');
        $options  = Option::query()
            ->where('status','=',0)
            ->get();

       foreach ($options as $op){

           $create_date = $op->created_at;
           $mod_date = strtotime($create_date."+ 3 days");
           $final_date = date("Y-m-d h:i:s",$mod_date);

           if($final_date <= $date_today){
                $op->status = 3;
                $op->update();
           }




       }

        return 0;
    }
}
