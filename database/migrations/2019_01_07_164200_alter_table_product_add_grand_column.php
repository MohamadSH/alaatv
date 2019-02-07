<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableProductAddGrandColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->unsignedInteger('grand_id')
                   ->nullable()
                  ->after('id');
            $table->foreign('grand_id')
                  ->references('id')
                  ->on('products');
        });

        $output = new ConsoleOutput();
        $output->writeln('update products grand....');

        $products = \App\Product::all();

        $progress = new ProgressBar($output, $products->count());

        foreach ($products as $product){
            $g = $product->migrationGrand();

            if($g !== false){
                $product->grand_id = $g->id;
                $product->save();
                $output->writeln("pg:".$product->grand_id);
            }


            $progress->advance();
        }
        $progress->finish();
        $output->writeln('Done!');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['grand_id']);
            $table->dropColumn('grand_id');
        });
    }
}
