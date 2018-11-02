<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableUsersAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mobile_verified_at')) {
                $table->dropColumn('mobile_verified_at');
            }
        });

        Schema::table('users', function (Blueprint $table) {

            $table->timestamp('mobile_verified_at')
                ->nullable()
                ->after('mobile')
                ->comment("تاریخ تایید شماره موبایل");
        });

        $users = \App\User::where('mobileNumberVerification', 1)->get();
        $output = new ConsoleOutput();
        $output->writeln('update mobile_verified_at for users....');
        $progress = new ProgressBar($output, $users->count());
        foreach ($users as $user) {
            $user->timestamps = false;
            $successfullVerification = DB::table('verificationmessages')
                ->where("user_id", $user->id)
                ->where("verificationmessagestatus_id", 2)
                ->first();

            if (isset($successfullVerification)) {
                $user->mobile_verified_at = $successfullVerification->created_at;
                $user->update();
            }
            $user->timestamps = true;
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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'mobile_verified_at')) {
                $table->dropColumn('mobile_verified_at');
            }
        });
    }
}
