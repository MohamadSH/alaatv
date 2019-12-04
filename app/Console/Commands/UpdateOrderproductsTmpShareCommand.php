<?php

namespace App\Console\Commands;

use App\Orderproduct;
use App\Repositories\OrderproductRepo;
use Illuminate\Console\Command;

class UpdateOrderproductsTmpShareCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:update-orderproducts-tmpshare';

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
        $orderproducts = Orderproduct::whereHas('order' , function ($q){
            $q->whereNotIn('orderstatus_id' , [config('constants.ORDER_STATUS_OPEN' , config('constants.ORDER_STATUS_OPEN_DONATE'))]);
        });

        if ($this->confirm('Do you want to process all of orderproducts or just new ones? type yes if you want all of them', true)) {
            // Process all of orderproducts
            $orderproducts = $orderproducts->get();
        }else{
            // Process new orderproducts with no cache
            $orderproducts = $orderproducts->whereNull('tmp_share_order')->orWhere('tmp_share_order' , 0)->get();
        }

        if ($this->confirm('Found '.$orderproducts->count().' orderproducts , Do you want to proceed?', true)) {
            $bar = $this->output->createProgressBar($orderproducts->count());
            foreach ($orderproducts as $orderproduct) {
                /** @var Orderproduct $orderproduct */
                $orderproduct->setShareCost();
                $bar->advance();
            }
            $bar->finish();
        }
        $this->info("Done");
    }
}
