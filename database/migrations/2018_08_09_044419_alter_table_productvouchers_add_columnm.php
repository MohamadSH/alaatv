<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableProductvouchersAddColumnm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('productvouchers', function (Blueprint $table) {
            $table->unsignedInteger("user_id")
                ->nullable()
                ->comment("آی دی مشخص کننده کاربر که کد به اون تخصیص داده شده است")
                ->after("product_id");

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::table('productvouchers', function (Blueprint $table) {
            if (Schema::hasColumn('productvouchers', 'user_id'))
            {
                $table->dropForeign('productvouchers_user_id_foreign');
                $table->dropColumn('user_id');
            }
        });
    }
}
