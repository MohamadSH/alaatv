<?php

namespace App\Console\Commands;

use App\Orderproduct;
use App\Repositories\OrderproductRepo;
use Illuminate\Console\Command;

class UpdateOrderproductsTmpPriceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaatv:update-orderproducts-tmpprice';

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
        if ($this->confirm('Do you want to process all of orderproducts or just new ones? type yes if you want all of them', true)) {
            // Process all of orderproducts
            $orderproducts = Orderproduct::all(); //ToDo : improve performance , pagination could help
        }else{
            // Process new orderproducts with no cache
            $orderproducts = Orderproduct::whereNull('tmp_final_cost')->get();
        };

        if ($this->confirm('Found '.$orderproducts->count().' orderproducts , Do you want to proceed?', true)) {
            $bar = $this->output->createProgressBar($orderproducts->count());
            foreach ($orderproducts as $orderproduct) {
                $priceInfo = $orderproduct->obtainOrderproductCost(false);
                OrderproductRepo::refreshOrderproductTmpPrice($orderproduct, $priceInfo['final'], $priceInfo['extraCost']);
                $bar->advance();
            }
            $bar->finish();
        }
        $this->info("Done");
    }
}
