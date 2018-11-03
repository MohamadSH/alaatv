<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

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
            $table->double('discount')
                  ->default(0)
                  ->comment("میزان تخفیف بن به درصد")
                  ->after('userbon_id');
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
