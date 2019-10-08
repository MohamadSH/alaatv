<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class ModifyDataUsersPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $users = User::all();
        $output = new ConsoleOutput();
        $output->writeln('Updating users photos...');
        $progress = new ProgressBar($output, $users->count());
        foreach ($users as $user) {
            $fileName = $user->getOriginal('photo');
            $user->photo = 'upload/images/profile/'.$fileName;
            if(!$user->update()) {
                dump('user #'.$user->id.' was not updated.');
            }
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
