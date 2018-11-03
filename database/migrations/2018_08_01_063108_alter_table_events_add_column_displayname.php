<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableEventsAddColumnDisplayname extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش")
                  ->after("name");

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {

            if (Schema::hasColumn('events', 'displayName')) {
                $table->dropColumn('displayName');
            }
        });
    }
}
