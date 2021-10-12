<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
use App\Models\Admin\Buttons_filter;
use App\Models\Admin\Questions_filter;
use App\Models\Admin\Questions_filters_traduction;
use App\Models\Admin\Fam_select;



class Getfilters extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:filters';

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

        $config = [
            'ashost' => '10.190.201.16',
            'sysnr'  => '36',
            'client' => '700',
            'user' => 'scheda',
            'passwd' => 'iniziale',
        ];
        $c = new SapConnection($config);


         $f = $c->getFunction('ZGERARCHIA_MARKETING_USATO_RFC');
            $result_start = $f->invoke([ ],['rtrim' => true]);
            $result = $result_start['TT_CONFIG_CC_COMM'];


            for($i=0;$i<count($result);$i++){
                $record= new Buttons_filter();
                $record->button_it= $result[$i]['TASTI_SELEZIONE'];
                $record->button_en= $result[$i]['TASTI_SELEZIONE'].'-EN';
                $record->save();


                $record_two = new Fam_select();
                $record_two->button_id= $record->id;
                $record_two->option_it=$result[$i]['RAGGRUPPAMENTO'];
                $record_two->option_en=$result[$i]['RAGGRUPPAMENTO'].'-EN';
                $record_two->cod_fam=$result[$i]['CODICE_FAMIGLIA'];
                $record_two->save();
            }

        $c = new SapConnection($config);
        $f = $c->getFunction('ZLISTA_DOMANDE_FAMIGLIA_RTC');
        $result = $f->invoke([  ],['rtrim' => true]);



        for ($f=0; $f < count($result['TT_DOMANDE_FAMIGLIA']);$f++)
        {
            $zdati = $result['TT_DOMANDE_FAMIGLIA'][$f];

            if($zdati['STEP'] == 'Selezione'){
                $record = new Questions_filter();
                $record->cod_fam = $zdati['CODICE_FAMIGLIA'];
                $record->type = '';
                $record->cod_question = $zdati['CODICE_DOMANDA'];
                $record->order_question = $zdati['ORDINE_DOMANDA'];
                $record->values = $zdati['VALORI'];
                $record->save();
            }


        }

        $c = new SapConnection($config);

        $f = $c->getFunction('ZLISTA_DOMANDE_RTC');
        $result = $f->invoke([  ],['rtrim' => true]);

        for ($f=0; $f < count($result['TT_DOMANDE']);$f++)
        {
            $zdati = $result['TT_DOMANDE'][$f];

             $find = Questions_filter::where('cod_question', '=', $zdati['CODICE_DOMANDA'])->get();

             for($i=0;$i<count($find);$i++){
                 $edit = Questions_filter::where('id', '=', $find[$i]['id'])->first();
                 $edit->type = $zdati['TIPOLOGIA'];
                 $edit->update();

             }

        }

        $c = new SapConnection($config);

        $f = $c->getFunction('ZLISTA_TRADUZIONI_RTC');
        $result = $f->invoke([  ],['rtrim' => true]);


        for ($f=0; $f < count($result['TT_TRADUZIONI']);$f++)
        {
            $zdati = $result['TT_TRADUZIONI'][$f];

                $record = new Questions_filters_traduction();

            $record->cod_question = $zdati['CODICE'];
            $record->lang = $zdati['LINGUA'];
            $record->label = $zdati['VALORE'];
            $record->save();




        }


    }
}
