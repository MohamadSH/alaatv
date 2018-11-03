<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableUserAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp("birthdate")
                  ->nullable()
                  ->comment("تاریخ تولد")
                  ->after("gender_id");

            $table->string("introducedBy")
                  ->nullable()
                  ->comment("نحوه ی آشنایی با شرکت")
                  ->after("bio");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'birthdate')) {
                $table->dropColumn('birthdate');
            }

            if (Schema::hasColumn('users', 'introducedBy')) {
                $table->dropColumn('introducedBy');
            }
        });
    }
}
