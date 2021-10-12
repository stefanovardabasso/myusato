<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Tuttocarrelli extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:tuttocarrelli';

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
          $this->sendimages();

          //$this->update();
          $this->delete();
    }

    public function create(){
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.tuttocarrellielevatori.it/v1/clsusato/forklifts?',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('manufacturer' => 'hyster','code' => 'a','type' => '1016','model' => 'a','power_unit' => 'a','carrying_capacity' => '2000','mast' => 'a'),
            CURLOPT_HTTPHEADER => array(
                'Authorization: Bearer 05cf8e9cb1ddbfb46076b2b570bff1a0cc119c5e'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }
    public function update(){

    }
    public function delete(){

    }

    public function sendimages()
    {

    }

}
