<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Macu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'call:macu';

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

    }
    public function update(){

    }
    public function delete(){

    }
}
