<?php

use App\Product;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class FillProductblockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = Product::whereNotNull('block_id')->get();

        $output = new ConsoleOutput();
        $output->writeln('Filling product blocks...');
        $progress = new ProgressBar($output, $products->count());

        foreach ($products as $product) {
            $product->blocks()->attach($product->block_id);
            $progress->advance();
        }

        $progress->finish();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
