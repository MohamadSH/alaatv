<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FixTelescopeBugTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('telescope_entries')) {
            Schema::table('telescope_entries', function (Blueprint $table) {
                $table->dropColumn('content');
            });
            Schema::table('telescope_entries', function (Blueprint $table) {
                $table->longText('content');
            });
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('telescope_entries')) {
            Schema::table('telescope_entries', function (Blueprint $table) {
                //
            });
        }
    }
}
