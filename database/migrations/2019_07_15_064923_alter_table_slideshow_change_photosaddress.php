<?php

use App\Slideshow;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableSlideshowChangePhotosaddress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $slideShows = slideShow::all();

        $output = new ConsoleOutput();
        $output->writeln('updating slide show photos...');
        $progress = new ProgressBar($output, $slideShows->count());
        foreach ($slideShows as $slideShow) {
            $fileName = $slideShow->photo;
            $slideShow->photo = 'upload/images/slideShow/'.$fileName;
            if(!$slideShow->update())
                dump('slide show #'.$slideShow->id.' was not updated.');
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
