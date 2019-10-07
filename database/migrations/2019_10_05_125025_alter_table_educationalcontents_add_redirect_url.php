<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableEducationalcontentsAddRedirectUrl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->string('redirectUrl')->after('id')->nullable()->comment('لینکی که کانتنت به آن ریدایرکت می شود');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            $table->dropColumn('redirectUrl');
        });
    }
}
