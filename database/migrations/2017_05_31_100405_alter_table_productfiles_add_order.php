<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableProductfilesAddOrder extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productfiles', function ($table) {
            $table->integer('order')
                  ->default(0)
                  ->comment("ترتیب فایل")
                  ->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productfiles', function ($table) {
            $table->dropColumn('order');
        });
    }
}
