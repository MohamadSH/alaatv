<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableContentsetsAddRedirectUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contentsets', function (Blueprint $table) {
            $table->string('redirectUrl')->after('id')->nullable()->comment('لینکی که ست به آن ریدایرکت می شود');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contentsets', function (Blueprint $table) {
            if (Schema::hasColumn('contentsets', 'redirectUrl')) {
                $table->dropColumn('redirectUrl');
            }
        });
    }
}
