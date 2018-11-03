<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

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
            $table->string('participationCodeHash')
                  ->nullable()
                  ->comment("هش شماره داوطلبی")
                  ->after('participationCode');
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
