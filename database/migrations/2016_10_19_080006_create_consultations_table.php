<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateConsultationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consultations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')
                  ->nullable()
                  ->comment('نام مشاوره');
            $table->longText('description')
                  ->nullable()
                  ->comment('توضیح درباره مشاوره');
            $table->string('videoPageLink')
                  ->nullable()
                  ->comment('لینک صفحه تماشای فیلم مشاوره');
            $table->string('textScriptLink')
                  ->nullable()
                  ->comment('لینک صفحه حاوی متن مشاوره');
            $table->integer('order')
                  ->default(0)
                  ->comment('ترتیب مشاوره - در صورت نیاز به استفاده');
            $table->tinyInteger('enable')
                  ->default(1)
                  ->comment('فعال بودن یا نبودن مشاوره');
            $table->unsignedInteger('consultationstatus_id')
                  ->comment('آیدی مشخص کننده وضعیت مشاوره');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('consultationstatus_id')
                  ->references('id')
                  ->on('consultationstatuses')
                  ->onDelete('cascade')
                  ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `consultations` comment 'مشاوره ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consultations');
    }
}
