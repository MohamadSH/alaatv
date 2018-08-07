<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductvouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productvouchers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->nullable()->comment('آی دی محصول صاحب وچر');
            $table->string('code')->nullable()->comment('پین کد وچر');
            $table->timestamp('expirationdatetime')->nullable()->comment('زمان انقضای این پین کد');
            $table->tinyInteger('enable')->default(1)->comment('فعال یا غیرفعال بودن پین');
            $table->string('description')->nullable()->comment('توضیح این پین کد');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `productvouchers` comment 'وچرهای محصول'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productvouchers');
    }
}
