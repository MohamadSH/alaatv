<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablePaymentmethodsAddDisplayName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('paymentmethods', function (Blueprint $table) {
            $table->string("displayName")
                  ->nullable()
                  ->comment("نام قابل نمایش روش")
                  ->after("name");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('paymentmethods', function (Blueprint $table) {
            $table->dropColumn('displayName');
        });
    }
}
