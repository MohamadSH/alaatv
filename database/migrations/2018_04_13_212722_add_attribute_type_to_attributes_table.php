<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddAttributeTypeToAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('attributes', function (Blueprint $table) {
            if (!Schema::hasColumn('attributes', 'attributetype_id')) {
                $table->unsignedInteger("attributetype_id")
                      ->nullable()
                      ->comment("آی دی مشخص کننده نوع صفت مورد نظر");
                $table->foreign('attributetype_id')
                      ->references('id')
                      ->on('attributetypes')
                      ->onDelete('cascade')
                      ->onupdate('cascade');
            }
        });

        $ans = collect();
        $attr = DB::table('attribute_attributegroup')
                  ->select('attributetype_id', 'attribute_id')
                  ->get()
                  ->groupBy('attribute_id');
        foreach ($attr as $key => $value) {
            $ans->put($key, $value->pluck('attributetype_id', 'attributetype_id')
                                  ->all());
        }

        foreach ($ans as $k1 => $v1) {
            foreach ($v1 as $k2 => $v2) {
                DB::table('attributes')
                  ->where('id', $k1)
                  ->update(['attributetype_id' => $v2]);
            }
        }
        DB::table('attributes')
          ->where('id', 12)
          ->update(['attributetype_id' => 1]);
        //TODO: Fix Product 167, attribute value 48, set 5, group 7, attribute 12 ( type 2 -> 1)

        //        DB::table('users')->insert(
        //            ['email' => 'john@example.com', 'votes' => 0]
        //        );


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::table('attributes', function (Blueprint $table) {

            if (Schema::hasColumn('attributes', 'attributetype_id')) {
                Schema::disableForeignKeyConstraints();
                $table->dropForeign('attributes_attributetype_id_foreign');
                $table->dropColumn('attributetype_id');
                Schema::enableForeignKeyConstraints();
            }

        });


    }
}
