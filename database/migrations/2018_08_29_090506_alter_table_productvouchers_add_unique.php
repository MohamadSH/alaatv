<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            if (Schema::hasColumn('productvouchers', 'code'))
            {
                $table->string('code')->change();
            }
        });
    }
}
