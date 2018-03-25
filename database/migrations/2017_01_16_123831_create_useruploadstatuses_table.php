<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUseruploadstatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('useruploadstatuses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام این وضعیت');
            $table->string('displayName')->nullable()->comment('نام قابل نمایش این وضعیت');
            $table->longText('description')->nullable()->comment('توضیحات این وضعیت');
            $table->integer("order")->default(0)->comment("ترتیب وضعیت");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `useruploadstatuses` comment 'وضعیتهای ممکن برای یک فایل آپلود شده توسط کاربر'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('useruploadstatuses');
    }
}
