<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderproductsAddCheckoutstatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproducts', function ($table) {
            $table->unsignedInteger('checkoutstatus_id')->nullable()->comment("آی دی مشحص کننده وضعیت تسویه حساب این آیتم")->after('product_id');

            $table->foreign('checkoutstatus_id')
                ->references('id')
                ->on('checkoutstatuses')
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
            if (Schema::hasColumn('orderproducts', 'checkoutstatus_id')) {
                $table->dropForeign('orderproducts_checkoutstatus_id_foreign');
                $table->dropColumn('checkoutstatus_id');
            }
        });
    }
}
