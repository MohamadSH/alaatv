<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBlockablesAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blockables', function (Blueprint $table) {
            $table->integer('order')->default(0)->after('blockable_type')->comment('ترتیب');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blockables', function (Blueprint $table) {
            if (Schema::hasColumn('blockables', 'order')) {
                $table->dropColumn('order');
            }
        });

    }
}
