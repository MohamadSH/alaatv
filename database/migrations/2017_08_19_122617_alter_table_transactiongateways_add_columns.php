<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableTransactiongatewaysAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transactiongateways', function (Blueprint $table) {
            $table->string('certificatePrivateKeyFile')->nullable()->comment('فایل گواهی اس اس ال برای کلید خصوصی امضا دیجیتال')->after("merchantNumber");
            $table->string('certificatePrivateKeyPassword')->nullable()->comment('رمز عبور برای کلید خصوصی امضا دیجیتال')->after("certificatePrivateKeyFile");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(' transactiongateways', function (Blueprint $table) {
            if (Schema::hasColumn('transactiongateways', 'certificatePrivateKeyFile')) {
                $table->dropColumn('certificatePrivateKeyFile');
            }

            if (Schema::hasColumn('transactiongateways', 'certificatePrivateKeyPassword')) {
                $table->dropColumn('certificatePrivateKeyPassword');
            }
        });
    }
}
