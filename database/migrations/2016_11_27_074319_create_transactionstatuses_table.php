<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateTransactionstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactionstatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام وضعیت');
            $table->string('displayName')
                  ->nullable()
                  ->comment('نام قابل نمایش این وضعیت');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح درباره وضعیت');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `transactionstatuses` comment 'وضعیت های یک تراکنش بانکی'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactionstatuses');
    }
}
