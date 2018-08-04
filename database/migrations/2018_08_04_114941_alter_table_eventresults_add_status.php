<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEventresultsAddStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eventresults', function (Blueprint $table) {
            $table->unsignedInteger("eventresultstatus_id")
                    ->nullable()
                    ->comment("آیدی مشخص کننده وضعیت نتیجه")
                    ->after("event_id");

            $table->foreign('eventresultstatus_id')
                ->references('id')
                ->on('eventresultstatuses')
                ->onDelete('cascade')
                ->onupdate('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('eventresults', function (Blueprint $table) {

            if (Schema::hasColumn('eventresults', 'eventresultstatus_id'))
            {
                $table->dropForeign('eventresults_eventresultstatus_id_foreign');
                $table->dropColumn('eventresultstatus_id');
            }
        });
    }
}
