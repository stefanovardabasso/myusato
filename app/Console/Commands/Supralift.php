<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use CURLFile;
use SoapClient;

class Supralift extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:supralift';

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
        $this->create();
        $this->update();
        $this->delete();
    }
    public function create(){

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://www.supralift.com/servlet/EcutServlet?handler=BulkloadHandler&jfaction=0',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('muddledPassword' => 'sv21016290','XMLfile'=> new CURLFILE('/C:/Users/teo/Downloads/qr.png'),'userID' => 'asdasdasd1231'),
            CURLOPT_HTTPHEADER => array(
                'Cookie: JSESSIONID=bwppyxwpsudlre1bq945rg3h; the_lang=de_DE'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function update(){
//        $soapURL = "http://services.mascus.com/api/mascusapi.asmx" ;
//        $soapParameters = Array('login' => "username", 'password' => "password") ;
//        $soapFunction = "getRegions";
//        $soapFunctionParameters = Array('countrycode' => 'GB');
//
//        $soapClient = new SoapClient($soapURL, $soapParameters);
//
//        $soapResult = $soapClient->__soapCall($soapFunction,
//            $soapFunctionParameters) ;
//
//        if(is_array($soapResult) && isset($soapResult['someFunctionResult'])) {
//            // Process result.
//        }
     }
    public function delete(){


    }
}
