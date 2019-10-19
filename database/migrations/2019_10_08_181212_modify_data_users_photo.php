<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\QueryException;
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
        $base = 'upload/images/profile/';
        foreach ($users as $user) {
            $fileName = $user->getOriginal('photo');
            $path = $base . $fileName;
            try{
                $user->photo = $path;
                if(!$user->update()) {
                    dump('user #'.$user->id.' was not updated.');
                }
            }catch (QueryException $exception){
                $user->photo = $base.'default_avatar.png';
                if(!$user->update()) {
                    dump('user #'.$user->id.' was not updated.');
                }
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
