<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RajaOngkir\Ongkir;

class ROProvince extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'raja-ongkir:cache-prov';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get city data from Raja Ongkir API and insert to database';

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
        Ongkir::cachingProvince();
    }
}
