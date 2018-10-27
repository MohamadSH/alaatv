<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTablesContentSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('educationalcontents', function (Blueprint $table) {
            if (!Schema::hasColumn('educationalcontents', 'contentset_id')) {
                $table->unsignedInteger('contentset_id')
                    ->nullable()
                    ->after('contenttype_id');
                $table->foreign('contentset_id')
                    ->references('id')
                    ->on('contentsets')
                    ->onDelete('cascade')
                    ->onupdate('cascade');
            }
            if (!Schema::hasColumn('educationalcontents', 'order')) {
                $table->integer("order")
                    ->default(0)
                    ->comment("ترتیب");
            }

        });

        $contents = \App\Content::all();
        $output = new ConsoleOutput();
        $output->writeln('update contents set&order....');
        $progress = new ProgressBar($output, $contents->count());

        $contents->load('contentsets');
        foreach ($contents as $content) {
            $content->timestamps = false;

            $order = optional(optional(optional($content->contentsets->where("pivot.isDefault", 1))->first())->pivot)->order;
            $content->forceFill([
                'contentset_id' => optional($content->contentsets->where("pivot.isDefault", 1)->first())->id,
                'order' => $order > 0 ? $order : 0
            ])->save();

            $content->timestamps = true;
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('Done!');
//        Schema::dropIfExists('contentset_educationalcontent');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
