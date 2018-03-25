<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderproductUserbonAddDiscount extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproduct_userbon', function ($table) {
            $table->double('discount')->default(0)->comment("میزان تخفیف بن به درصد")->after('userbon_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderproduct_userbon', function ($table) {
            $table->dropColumn('discount');
        });
    }
}
