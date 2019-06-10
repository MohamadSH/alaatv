<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableBlocksAddColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('blocks', function (Blueprint $table) {
            $table->string('customUrl')->nullable()->after('tags')->comment('یک آدرس دلخواه برای ریدایرکت شدن تایتل');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('blocks', function (Blueprint $table) {
            if (Schema::hasColumn('blocks', 'customUrl')) {
                $table->dropColumn('customUrl');
            }
        });

    }
}
