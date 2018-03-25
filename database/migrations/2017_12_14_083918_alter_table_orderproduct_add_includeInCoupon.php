<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderproductAddIncludeInCoupon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproducts', function ($table) {
            $table->tinyInteger('includedInCoupon')->default(0)->comment("مشخص کننده اینکه آیا این آیتم مشمول کپن بوده یا نه(در صورت کپن داشتن سفارش)")->after('cost');
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
            if (Schema::hasColumn('orderproducts', 'includedInCoupon')) {
                $table->dropColumn('includedInCoupon');
            }
        });
    }
}
