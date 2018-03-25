<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orderstatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام این وضعیت');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش این وضعیت');
            $table->longText('description')->nullable()->comment('توضیحات این وضعیت');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `orderstatuses` comment 'وضعیت ممکن برای یک سفارش'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orderstatuses');
    }
}
