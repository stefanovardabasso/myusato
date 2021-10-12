<?php

namespace App\Console\Commands;
use App\Models\Admin\Galrtc;
use App\Models\Admin\Product;
use App\Models\Admin\Products_line;
use Illuminate\Console\Command;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
use GuzzleHttp\Client;

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
        $config = [ 'ashost' => config('main.sap_host'), 'sysnr'  => config('main.sap_sysnr'), 'client' => config('main.sap_client'), 'user' => config('main.sap_user'), 'passwd' => config('main.sap_pass'), ];
        $c = new SapConnection($config);

        for ($i=1970; $i < 2022; $i++){
            $f = $c->getFunction('ZMACCHINE_USATO');
            $result = $f->invoke([
                'IV_ANNO' => "$i",
//                'IV_FROM_RTC' => " "
            ],['rtrim' => true]);
            for ($a=0;$a<count($result['TT_USATO']);$a++) {

                $check = Product::query()
                    ->where('model','=', $result['TT_USATO'][$a]['MODELLO'])
                    ->where('serialnum','=', $result['TT_USATO'][$a]['SERIALE'])
                    ->first();
                if($check === null) {

                    $record_prod = new Product();
                    $record_prod->family = $result['TT_USATO'][$a]['FAMIGLIA'];
                    $record_prod->types = $result['TT_USATO'][$a]['TIPO'];
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
                    $record_prod->prenotata = $result['TT_USATO'][$a]['PRENOTATA'];
                    $record_prod->totalecostoallestimenti = $result['TT_USATO'][$a]['TOTALE_COSTO_ALLESTIMENTI'];
                    $record_prod->overallowance = $result['TT_USATO'][$a]['OVERALLOWANCE'];
                    $record_prod->pagato_cliente = $result['TT_USATO'][$a]['PAGATO_CLIENTE'];
                    $record_prod->scheda = $result['TT_USATO'][$a]['ID_RTC'];
                    $record_prod->riferimento_cls = $result['TT_USATO'][$a]['RIFERIMENTO_CLS'];
                    $record_prod->fornitore = $result['TT_USATO'][$a]['FORNITORE'];
                    $record_prod->data_em = $result['TT_USATO'][$a]['DATA_EM'];
                    $record_prod->save();

                    if ($result['TT_USATO'][$a]['CC1'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC1'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC1'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO1'];
                        $record_prod_line->save();

                        // $record_prod = Product::where('id', '=', $record_prod->id)->first();
                        // $record_prod->scheda = '0';
                        // $record_prod->update();

                    }
                    if ($result['TT_USATO'][$a]['CC2'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC2'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC2'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO2'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC3'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC3'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC3'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO3'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC4'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC4'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC4'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO4'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC5'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC5'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC5'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO5'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC6'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC6'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC6'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO6'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC7'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC7'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC7'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO7'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC8'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC8'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC8'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO8'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC9'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC9'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC9'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO9'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC10'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC10'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC10'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO10'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC11'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC11'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC11'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO11'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC12'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC12'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC12'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO12'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC13'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC13'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC13'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO13'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC14'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC14'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC14'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO14'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC15'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC15'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC15'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO15'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC16'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC16'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC16'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO16'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC17'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC17'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC17'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO17'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC18'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC18'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC18'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO18'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC19'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC19'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC19'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO19'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC20'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC20'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC20'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO20'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC21'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC21'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC21'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO21'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC22'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC22'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC22'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO22'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC23'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC23'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC23'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO23'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC24'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC24'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC24'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO24'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC25'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC25'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC25'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO25'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC26'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC26'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC26'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO26'];
                        $record_prod_line->save();
                    }
                    if ($result['TT_USATO'][$a]['CC27'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC27'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC27'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO27'];
                        $record_prod_line->save();
                    }

                    if ($result['TT_USATO'][$a]['CC28'] != '') {
                        $record_prod_line = new Products_line();
                        $record_prod_line->id_product = $record_prod->id;
                        $record_prod_line->cc_sap = $result['TT_USATO'][$a]['CC28'];
                        $record_prod_line->cc_value_sap = $result['TT_USATO'][$a]['VALORE_CC28'];
                        $record_prod_line->filter = $result['TT_USATO'][$a]['FILTRO28'];
                        $record_prod_line->save();
                    }




                }


            }

        }



        $prods = Product::query()
            ->where('date_rtc','=',null)
            ->where('scheda','!=','0')
            ->get();

        foreach ($prods as $prod){
            $product = $prod->id;
            if($prod->scheda != 0){
                $c  = new Client();

                $response1 = $c ->request('GET', 'http://rtc.cls.it/api/getdatartc/'.$prod->scheda);
                $datac = json_decode($response1->getBody(), true);

                $thisma= Product::where('id',$prod->id)->first();
                $thisma->date_rtc = $datac['date'];
                $thisma->update();

                $images =  $datac['images'];

                foreach ($images as $img){

                    $remote_file_url = 'http://rtc.cls.it/upload/'.$img['name'];

                    $rc = new Galrtc();
                    $rc->product_id = $product;
                    $rc->image =  $remote_file_url;
                    $rc->title = $img['cod_question'];
                    $rc->save();



                    /* New file name and path for this file */
                    $local_file = public_path().'/upload/rtc-'.$img['name'];

                    /* Copy the file from source url to server */
                    //$copy = copy( $remote_file_url, $local_file );
                    //file_put_contents($local_file, file_get_contents($remote_file_url));

                    $imagen = file_get_contents($remote_file_url);
                     file_put_contents($local_file, $imagen);


                    //$copy = copy( $remote_file_url, $local_file );
                }

                // $remote_file_url = 'http://rtc.cls.it/upload/getdatartc/';
                // $local_file = 'files.zip';
                // $copy = copy( $remote_file_url, $local_file );


            }
        }




    }
}

