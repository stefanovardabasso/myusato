<?php

namespace App\Console\Commands;
use App\Models\Admin\Product;
use App\Models\Admin\Products_line;
use Illuminate\Console\Command;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;

class Getmachi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:machi';

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

        for ($i=1970; $i < 2022; $i++){
            $f = $c->getFunction('ZMACCHINE_USATO');
            $result = $f->invoke([
                'IV_ANNO' => "$i"
            ],['rtrim' => true]);

            for ($a=0;$a<count($result['TT_USATO']);$a++) {

                $record_prod = new Product();
                $record_prod->family = $result['TT_USATO'][$a]['FAMIGLIA'];
                $record_prod->type = $result['TT_USATO'][$a]['TIPO'];
                $record_prod->category = $result['TT_USATO'][$a]['CATEGORIA'];
                $record_prod->class = $result['TT_USATO'][$a]['CLASSE'];
                $record_prod->subclass = $result['TT_USATO'][$a]['SOTTOCLASSE'];
                $record_prod->brand = $result['TT_USATO'][$a]['MARCA'];
                $record_prod->model = $result['TT_USATO'][$a]['MODELLO'];
                $record_prod->year = $result['TT_USATO'][$a]['ANNO'];
                $record_prod->serialnum = $result['TT_USATO'][$a]['SERIALE'];
                $record_prod->location = $result['TT_USATO'][$a]['UBICAZIONE'];
                $record_prod->noff = '';
                $record_prod->partita = $result['TT_USATO'][$a]['PARTITA'];
                $record_prod->orelavoro = $result['TT_USATO'][$a]['ORE_LAVORO'];
                $record_prod->macchinallestita = $result['TT_USATO'][$a]['MACCHINA_ALLESTITA'];
                $record_prod->typeallestimento = $result['TT_USATO'][$a]['TIPO_ALLESTIMENTO'];
                $record_prod->noleggiata = $result['TT_USATO'][$a]['NOLEGGIATA'];
                $record_prod->venduta = $result['TT_USATO'][$a]['VENDUTA'];
                $record_prod->opzionata = $result['TT_USATO'][$a]['OPZIONATA'];
                $record_prod->totalecostoallestimenti = $result['TT_USATO'][$a]['TOTALE_COSTO_ALLESTIMENTI'];
                $record_prod->overallowance = $result['TT_USATO'][$a]['OVERALLOWANCE'];
                $record_prod->pagato_cliente = $result['TT_USATO'][$a]['PAGATO_CLIENTE'];
                $record_prod->scheda = '1';
                $record_prod->save();

                if($result['TT_USATO'][$a]['CC1'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC1'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC1'];
                    $record_prod_line->save();

                    $record_prod =Product::where('id', '=', $record_prod->id)->first();
                    $record_prod->scheda = '0';
                    $record_prod->update();

                }
                if($result['TT_USATO'][$a]['CC2'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC2'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC2'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC3'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC3'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC3'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC4'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC4'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC4'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC5'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC5'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC5'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC6'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC6'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC6'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC7'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC7'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC7'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC8'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC8'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC8'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC9'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC9'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC9'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC10'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC10'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC10'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC11'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC11'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC11'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC12'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC12'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC12'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC13'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC13'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC13'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC14'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC14'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC14'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC15'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC15'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC15'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC16'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC16'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC16'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC17'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC17'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC17'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC18'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC18'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC18'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC19'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC19'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC19'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC20'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC20'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC20'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC21'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC21'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC21'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC22'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC22'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC22'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC23'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC23'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC23'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC24'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC24'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC24'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC25'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC25'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC25'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC26'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC26'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC26'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC27'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC27'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC27'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC27'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC27'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC27'];
                    $record_prod_line->save();
                }
                if($result['TT_USATO'][$a]['CC28'] !=''){
                    $record_prod_line = new Products_line();
                    $record_prod_line->id_product = $record_prod->id;
                    $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC28'];
                    $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC28'];
                    $record_prod_line->save();
                }




            }

        }






    }
}

