<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDescriptionwithperiodsAddPhoto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('descriptionwithperiods', function (Blueprint $table) {
            $table->string('photo')->after('description')->nullable()->comment('عکس');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('descriptionwithperiods', function (Blueprint $table) {
            if (Schema::hasColumn('descriptionwithperiods', 'photo')) {
                $table->dropColumn('photo');
            }
        });
    }
}
