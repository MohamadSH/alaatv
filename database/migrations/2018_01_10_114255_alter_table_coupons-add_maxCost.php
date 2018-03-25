<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCouponsAddMaxCost extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function ($table) {
            $table->integer('maxCost')->nullable()->comment("بیشسینه قیمت مورد نیاز برای استفاده از این کپن")->after('discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coupons', function ($table) {
            if (Schema::hasColumn('coupons', 'maxCost')) {
                $table->dropColumn('maxCost');
            }
        });
    }
}
