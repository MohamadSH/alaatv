<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterTableUsersAddColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger("grade_id")->nullable()->comment("آی دی مشخص کننده مقطع")->after("major_id");
            $table->string("phone")->nullable()->comment("شماره تلفن ثابت")->after("mobile");
            $table->unsignedInteger("bloodtype_id")->nullable()->comment("گروه خونی")->after("bio");
            $table->text("allergy")->nullable()->comment("آلرژی به ماده خاص")->after("bloodtype_id");
            $table->text("medicalCondition")->nullable()->comment("بیماری یا شرایط پزشکی خاص")->after("allergy");
            $table->text("diet")->nullable()->comment("رژیم غذایی خاص")->after("medicalCondition");

            $table->foreign('grade_id')
                ->references('id')
                ->on('grades')
                ->onDelete('cascade')
                ->onupdate('cascade');

            $table->foreign('bloodtype_id')
                ->references('id')
                ->on('bloodtypes')
                ->onDelete('cascade')
                ->onupdate('cascade');
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
            if (Schema::hasColumn('users', 'grade_id')) {
                $table->dropForeign('users_grade_id_foreign');
                $table->dropColumn('grade_id');
            }
            if (Schema::hasColumn('users', 'phone')) {
                $table->dropColumn("phone");
            }
            if (Schema::hasColumn('users', 'bloodtype_id')) {
                $table->dropForeign('users_bloodtype_id_foreign');
                $table->dropColumn('bloodtype_id');
            }
            if (Schema::hasColumn('users', 'allergy')) {
                $table->dropColumn("allergy");
            }
            if (Schema::hasColumn('users', 'medicalCondition')) {
                $table->dropColumn("medicalCondition");
            }
            if (Schema::hasColumn('users', 'diet')) {
                $table->dropColumn("diet");
            }

        });
    }
}
