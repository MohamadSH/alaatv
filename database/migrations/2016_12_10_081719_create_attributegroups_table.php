<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateAttributegroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributegroups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام گروه');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح گروه');
            $table->unsignedInteger('attributeset_id')
                  ->nullable()
                  ->comment('آی دی مشخص کننده دسته صفت مربوطه');
            $table->integer("order")
                  ->default(0)
                  ->comment("ترتیب گروه صفت");
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('attributeset_id')
                  ->references('id')
                  ->on('attributesets')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });
        DB::statement("ALTER TABLE `attributegroups` comment 'گروه های صفت ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attributegroups');
    }
}
