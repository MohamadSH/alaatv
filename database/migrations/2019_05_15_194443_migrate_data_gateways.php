<?php

use App\Content;
use App\Product;
use App\Contentset;
use App\Productfile;
use Illuminate\Database\Schema\Blueprint;
use App\Classes\Repository\ProductRepository;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class MigrateDataGateways extends Migration
{
    public function up()
    {
        \DB::table('transactiongateways')->insert([
            'id' => 4,
            'name' => 'mellat',
            'displayName' => 'درگاه بانک ملت',
            'description' => 'به پرداخت بانک ملت',
            'enable' => 1,
        ]);
    }

}
