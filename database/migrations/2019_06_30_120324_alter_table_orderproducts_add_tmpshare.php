<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableOrderproductsAddTmpshare extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orderproducts', function (Blueprint $table) {
            $table->double('tmp_share_order')->nullable()->after('tmp_extra_cost')->comment('مبلغی که سهم این آبتم از قیمت کل است');
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
            if (Schema::hasColumn('orderproducts', 'tmp_share_order')) {
                $table->dropColumn('tmp_share_order');
            }
        });
    }
}
