<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableCouponsAddDiscounttype extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->unsignedInteger("discounttype_id")->nullable()->comment("نوع تخفیف")->after("coupontype_id");

            $table->foreign('discounttype_id')
                ->references('id')
                ->on('discounttypes')
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
            if (Schema::hasColumn('coupons', 'discounttype_id')) {
                $table->dropForeign('coupons_discounttype_id_foreign');
                $table->dropColumn('discounttype_id');
            }

        });
    }
}
