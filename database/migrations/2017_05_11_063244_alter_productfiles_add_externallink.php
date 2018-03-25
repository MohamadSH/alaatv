<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProductfilesAddExternallink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productfiles', function (Blueprint $table) {
            $table->string('cloudFile')->nullable()->comment("فایل آپلود شده در سرور خارجی")->after("file");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productfiles', function (Blueprint $table) {
            $table->dropColumn('cloudFile');
        });
    }
}
