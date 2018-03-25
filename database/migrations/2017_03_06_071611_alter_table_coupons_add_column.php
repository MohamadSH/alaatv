<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCouponsAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger('coupontype_id')->nullable()->comment("آی دی مشخص کننده نوع کپن")->after('id');

            $table->foreign('coupontype_id')
                ->references('id')
                ->on('coupontypes')
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
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign('coupons_coupontype_id_foreign');
            $table->dropColumn('coupontype_id');
        });
    }
}
