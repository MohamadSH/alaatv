<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEventresultsAddParticipationCodeHash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventresults', function ($table) {
            $table->string('participationCodeHash')->nullable()->comment("هش شماره داوطلبی")->after('participationCode');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventresults', function ($table) {
            $table->dropColumn('participationCodeHash');
        });
    }
}
