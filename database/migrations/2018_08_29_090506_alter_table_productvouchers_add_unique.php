<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableProductvouchersAddUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productvouchers', function (Blueprint $table) {
            $table->string("code")
                  ->unique()
                  ->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('productvouchers', function (Blueprint $table) {
            if (Schema::hasColumn('productvouchers', 'code')) {
                $table->string('code')
                      ->change();
            }
        });
    }
}
