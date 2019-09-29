<?php

use App\Product;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableProductsModifyPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $products = Product::all();
        $output = new ConsoleOutput();
        $output->writeln('Updating products photos...');
        $progress = new ProgressBar($output, $products->count());
        foreach ($products as $product) {
            $fileName = $product->image;
            $product->image = 'upload/images/product/'.$fileName;
            if(!$product->update())
                dump('product #'.$product->id.' was not updated.');
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
