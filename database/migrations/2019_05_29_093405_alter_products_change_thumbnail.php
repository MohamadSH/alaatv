<?php

use App\Product;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterProductsChangeThumbnail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('introVideo')->change();
        });

        $products = Product::whereNotNull('introVideo')->get();

        $output = new ConsoleOutput();
        $output->writeln('update products grand....');
        $progress = new ProgressBar($output, $products->count());
        foreach ($products as $product){
            $introVideos = collect();
            $introVideos->push([
                'url'       =>  $product->introVideo,
                'thumbnail' =>  null,
            ]);

            $product->introVideo = $introVideos;
            $product->update();
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
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'introVideo')) {
                $table->string('introVideo')->change();
            }
        });
    }
}
