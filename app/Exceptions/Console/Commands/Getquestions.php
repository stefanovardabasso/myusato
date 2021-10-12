<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Admin\Questions_sap;
use PhpParser\Node\Expr\New_;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class Getquestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:questions';

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


        try {
            $c = new SapConnection($config);

            $f = $c->getFunction('ZLISTA_DOMANDE_RTC');
            $result = $f->invoke([  ],['rtrim' => true]);

            Questions_sap::truncate();

            for ($f=0; $f < count($result['TT_DOMANDE']);$f++)
            {
                $zdati = $result['TT_DOMANDE'][$f];
                if($zdati['COD_CARATTERISTICA'] != ''){
                    $record = new Questions_sap();
                    $record->code_q = $zdati['CODICE_DOMANDA'];
                    $record->type = $zdati['TIPOLOGIA'];
                    $record->cc = $zdati['COD_CARATTERISTICA'];
                    $record->required = '';
                    $record->pos_values = '';
                    $record->label_it = '';
                    $record->label_en = '';
                    $record->save();
                }


            }

            $f = $c->getFunction('ZLISTA_DOMANDE_FAMIGLIA_RTC');
            $result = $f->invoke([  ],['rtrim' => true]);


            for ($f=0; $f < count($result['TT_DOMANDE_FAMIGLIA']);$f++)
            {
                $zdati = $result['TT_DOMANDE_FAMIGLIA'][$f];


                    $cod_question = $zdati['CODICE_DOMANDA'];
                    $required = $zdati['OBBLIGATORIO'];
                    $value = $zdati['VALORI'];

                 $line = Questions_sap::where('code_q', '=', $cod_question)->first();
                if($value != '' && isset($line->id)) {

                    $line->required = $required;
                    $line->pos_values = $value;
                    $line->update();
                }


            }

            $f = $c->getFunction('ZLISTA_TRADUZIONI_RTC');
            $result = $f->invoke([  ],['rtrim' => true]);



            for ($f=0; $f < count($result['TT_TRADUZIONI']);$f++)
            {
                $zdati = $result['TT_TRADUZIONI'][$f];


                    $cod_question = $zdati['CODICE'];
                    $lang = $zdati['LINGUA'];
                    $value = $zdati['VALORE'];

                $line = Questions_sap::where('code_q', '=', $cod_question)->first();

                if($value != '' && isset($line->id)) {
                    if ($lang == 'I') {

                        $line->label_it = $value;
                        $line->update();

                    } else {

                        $line->label_en = $value;
                        $line->update();

                    }
                }


            }

        }catch(SapException $ex) {
            echo 'Exception: ' . $ex->getMessage() . PHP_EOL;
        }

    }
}
