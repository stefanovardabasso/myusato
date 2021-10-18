<?php

namespace App\Imports;

use App\Models\Admin\Component;
use App\Models\Admin\Gallery;
use App\Models\Admin\Product;
use App\Models\Admin\Offert;
use App\Models\Admin\Products_line;
use App\Models\Admin\Relation_offert_product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use SAPNWRFC\Connection as SapConnection;
use SAPNWRFC\Exception as SapException;
class OffertImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {

        Component::truncate();
        Gallery::truncate();
        Product::truncate();
        Offert::truncate();
        Relation_offert_product::truncate();
        foreach ($collection as $col){

            $record_prod = new Product();
            $record_prod->family = '';
            $record_prod->type = '';
            $record_prod->category = '';
            $record_prod->class = '';
            $record_prod->subclass = '';
            $record_prod->brand = '';
            $record_prod->model = '';
            $record_prod->year = '';
            $record_prod->serialnum = '';
            $record_prod->location = '';
            $record_prod->noff = '';
            $record_prod->partita = '';
            $record_prod->orelavoro = '';
            $record_prod->macchinallestita = '';
            $record_prod->typeallestimento = '';
            $record_prod->noleggiata = '';
            $record_prod->venduta = '';
            $record_prod->opzionata = '';
            $record_prod->prenotata = '';
            $record_prod->totalecostoallestimenti = '';
            $record_prod->overallowance = '';
            $record_prod->pagato_cliente = '';
            $record_prod->scheda = '0';
            $record_prod->riferimento_cls = $col[0];
            $record_prod->fornitore = 'OLDUSATO';
            $record_prod->data_em = '';
            $record_prod->save();

            if($col[6] == 'UTENTE FINALE'){
                $target_user = 1;
                $offert_type = 'UF';
            }elseif ($col[6] == 'COMMERCIANTE'){
                $target_user = 2;
                $offert_type = 'CO';
            }else{
                $target_user = 3;
                $offert_type = 'UF';
            }


            if($col[8] == null){  $trasp = 0; }else{ $trasp = $col[8]; }
            if($col[7] == null){  $rtc = 0; }else{ $rtc = $col[7]; }
            if($col[9] == null){  $ol_prev = 0; }else{ $ol_prev = $col[9];  }


                $record_offert = new Offert();
            $record_offert->date_finish_off = '2021-12-31';
            $record_offert->id_product = $record_prod->id;
            $record_offert->target_user = $target_user;
            if($target_user == 1){

                $record_offert->cost_trasp_uf = $trasp;
                $record_offert->price_rtc_uf = $rtc;
                $record_offert->ol_prevision_uf = $ol_prev;
                $record_offert->payed_client_uf = 0;
                $record_offert->ol_def_uf = 0;
                $record_offert->over_allowance_uf = 0;

            }else{
                $record_offert->cost_trasp_co = $trasp;
                $record_offert->price_rtc_co = $rtc;
                $record_offert->ol_prevision_co = $ol_prev;
                $record_offert->payed_client_co = 0;
                $record_offert->ol_def_co = 0;
                $record_offert->over_allowance_co = 0;

            }

            $record_offert->save();

            $config = [ 'ashost' => config('main.sap_host'), 'sysnr'  => config('main.sap_sysnr'), 'client' => config('main.sap_client'), 'user' => config('main.sap_user'), 'passwd' => config('main.sap_pass'), ];
            $c = new SapConnection($config);

            $f = $c->getFunction('ZMACCHINE_USATO');
            $result = $f->invoke([
                'IV_FROM_RTC' => "Y",
                'IV_ID' => $record_prod->riferimento_cls
            ],['rtrim' => true]);

            for ($a=0;$a<count($result['TT_USATO']);$a++) {

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
                $record_prod->prenotata = $result['TT_USATO'][$a]['PRENOTATA'];
                $record_prod->totalecostoallestimenti = $result['TT_USATO'][$a]['TOTALE_COSTO_ALLESTIMENTI'];
                $record_prod->overallowance = $result['TT_USATO'][$a]['OVERALLOWANCE'];
                $record_prod->pagato_cliente = $result['TT_USATO'][$a]['PAGATO_CLIENTE'];
                $record_prod->scheda = $result['TT_USATO'][$a]['ID_RTC'];
                $record_prod->riferimento_cls = $result['TT_USATO'][$a]['RIFERIMENTO_CLS'];
                $record_prod->fornitore = $result['TT_USATO'][$a]['FORNITORE'];
                $record_prod->data_em = $result['TT_USATO'][$a]['DATA_EM'];
                $record_prod->update();

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


//            $options = stream_context_create(array('http'=>
//                array(
//                    'timeout' => 10 //10 seconds
//                )
//            ));



//                $remote_file_url = 'http://185.97.156.38/sitocls/img/fotous/'.urlencode($col[2]);
//                $name ='oldusato-'.$col[2];
//                $local_file = public_path().'/upload/oldusato-'.$col[2];
//                $imagen = file_get_contents($remote_file_url, false, $options);
//                file_put_contents($local_file, $imagen);
//
//                $rec_img = new Gallery();
//                $rec_img->type = $offert_type;
//                $rec_img->position = 2;
//                $rec_img->offert_id = $record_offert->id;
//                $rec_img->name = $name;
//                $rec_img->save();
//
//
//
//            if($col[3] != 0){
//                $remote_file_url = 'http://185.97.156.38/sitocls/img/fotous/'.urlencode($col[3]);
//                $name ='oldusato-'.$col[3];
//                $local_file = public_path().'/upload/oldusato-'.$col[3];
//                $imagen = file_get_contents($remote_file_url, false, $options);
//                file_put_contents($local_file, $imagen);
//
//                $rec_img = new Gallery();
//                $rec_img->type = $offert_type;
//                $rec_img->position = 2;
//                $rec_img->offert_id = $record_offert->id;
//                $rec_img->name = $name;
//                $rec_img->save();
//            }
//            if($col[4] != 0){
//                $remote_file_url = 'http://185.97.156.38/sitocls/img/fotous/'.urlencode($col[4]);
//                $name ='oldusato-'.$col[4];
//                $local_file = public_path().'/upload/oldusato-'.$col[4];
//                $imagen = file_get_contents($remote_file_url, false, $options);
//                file_put_contents($local_file, $imagen);
//
//                $rec_img = new Gallery();
//                $rec_img->type = $offert_type;
//                $rec_img->position = 2;
//                $rec_img->offert_id = $record_offert->id;
//                $rec_img->name = $name;
//                $rec_img->save();
//            }
//            if($col[5] != 0){
//                $remote_file_url = 'http://185.97.156.38/sitocls/img/fotous/'.urlencode($col[5]);
//                $name ='oldusato-'.$col[5];
//                $local_file = public_path().'/upload/oldusato-'.$col[5];
//                $imagen = file_get_contents($remote_file_url, false, $options);
//                file_put_contents($local_file, $imagen);
//
//                $rec_img = new Gallery();
//                $rec_img->type = $offert_type;
//                $rec_img->position = 2;
//                $rec_img->offert_id = $record_offert->id;
//                $rec_img->name = $name;
//                $rec_img->save();
//            }








            $record_relation = new Relation_offert_product();
            $record_relation->idproduct = $record_prod->id;
            $record_relation->idoffert = $record_offert->id;
            $record_relation->save();



         if($col[10] != NULL){
             $record_components = new Component();
             $record_components->offert_id = $record_offert->id;
             $record_components->offert_type = $offert_type;
             $record_components->code = $col[10];
             $record_components->type = $col[11];
             $record_components->material = $col[12];
             $record_components->value = $col[13];
             $record_components->save();
         }

       if($col[14] != NULL){
            $record_components = new Component();
            $record_components->offert_id = $record_offert->id;
            $record_components->offert_type = $offert_type;
            $record_components->code = $col[14];
            $record_components->type = $col[15];
            $record_components->material = $col[16];
            $record_components->value = $col[17];
            $record_components->save();
       }









        }





    }
}
