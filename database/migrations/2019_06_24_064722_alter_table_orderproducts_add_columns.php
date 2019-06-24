<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderproductsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproducts', function (Blueprint $table) {
            $table->integer('tmp_final_cost')->nullable()->after('cost')->comment('کش قیمت نهایی');
            $table->integer('tmp_extra_cost')->nullable()->after('tmp_final_cost')->comment('کش قیمت افزوده نهایی');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orderproducts', function (Blueprint $table) {
            if (Schema::hasColumn('orderproducts', 'tmp_final_cost')) {
                $table->dropColumn('tmp_final_cost');
            }
        });

        Schema::table('orderproducts', function (Blueprint $table) {
            if (Schema::hasColumn('orderproducts', 'tmp_extra_cost')) {
                $table->dropColumn('tmp_extra_cost');
            }
        });

    }
}
