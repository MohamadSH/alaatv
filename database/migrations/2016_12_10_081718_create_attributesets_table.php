<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributesets', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable()->comment('نام دسته');
            $table->longText('description')->nullable()->comment('توضیح دسته');
            $table->integer("order")->default(0)->comment("ترتیب دسته صفت");
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `attributesets` comment 'دسته بندی گروه های صفت ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributesets');
    }
}
