<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSourceableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sourceables', function (Blueprint $table) {
            $table->unsignedInteger('source_id')->comment('آیدی سورس');
            $table->unsignedInteger('sourceable_id')->comment('آیدی سورس شده');
            $table->string('sourceable_type')->comment('نوع سورس شده');
            $table->integer('order')->default(0)->comment('ترتیب');
            $table->timestamps();
            $table->primary([
                'source_id',
                'sourceable_id',
                'sourceable_type',
            ]);

            $table->foreign('source_id')
                ->references('id')
                ->on('sources')
                ->onDelete('cascade')
                ->onupdate('cascade');
        });

        DB::statement("ALTER TABLE `sourceables` comment 'سورس شده ها'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sourceables', function (Blueprint $table) {
            if (Schema::hasColumn('sourceables', 'source_id')) {
                $table->dropForeign('sourceables_source_id_foreign');
            }
        });

        Schema::dropIfExists('sourceable');
    }
}
