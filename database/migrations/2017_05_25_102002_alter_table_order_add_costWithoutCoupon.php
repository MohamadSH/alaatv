<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableOrderAddCostWithoutCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function ($table) {
            $table->integer('costwithoutcoupon')
                  ->nullable()
                  ->comment("بخشی از قیمت که مشمول کپن تخفیف نمی شود")
                  ->after('cost');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function ($table) {
            $table->dropColumn('costwithoutcoupon');
        });
    }
}
