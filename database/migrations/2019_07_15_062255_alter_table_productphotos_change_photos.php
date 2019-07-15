<?php

use App\Productphoto;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableProductphotosChangePhotos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $productPhotos = Productphoto::all();

        $output = new ConsoleOutput();
        $output->writeln('updating products sample photos...');
        $progress = new ProgressBar($output, $productPhotos->count());
        foreach ($productPhotos as $productPhoto) {
            $fileName = $productPhoto->file;
            $productPhoto->file = 'upload/images/product/'.$fileName;
            if(!$productPhoto->update())
                dump('product photo #'.$productPhoto->id.' was not updated.');
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
