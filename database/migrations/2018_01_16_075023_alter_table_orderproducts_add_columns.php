<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AlterTableOrderproductsAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproducts', function ($table) {
            $table->unsignedInteger('orderproducttype_id')
                  ->nullable()
                  ->comment("آیدی مشخص کننده نوع آیتم سبد")
                  ->after('id');
            $table->double('discountPercentage')
                  ->default(0)
                  ->comment("تخفیف این آیتم سبد(به درصد)")
                  ->after('cost');
            $table->integer('discountAmount')
                  ->default(0)
                  ->comment("تخفیف این آیتم سبد(مبلغ)")
                  ->after('discountPercentage');

            $table->foreign('orderproducttype_id')
                  ->references('id')
                  ->on('orderproducttypes')
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
        Schema::table('orderproducts', function ($table) {
            if (Schema::hasColumn('orderproducts', 'discountAmount')) {
                $table->dropColumn('discountAmount');
            }

            if (Schema::hasColumn('orderproducts', 'discountPercentage')) {
                $table->dropColumn('discountPercentage');
            }

            if (Schema::hasColumn('orderproducts', 'orderproducttype_id')) {
                $table->dropForeign('orderproducts_orderproducttype_id_foreign');
                $table->dropColumn('orderproducttype_id');
            }
        });
    }
}
