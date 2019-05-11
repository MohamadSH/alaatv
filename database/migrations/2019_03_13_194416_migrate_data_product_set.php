<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class MigrateDataProductSet extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     * @throws \Exception
     */
    public function up()
    {
        DB::beginTransaction();
        try {
            Schema::table('productfiles', function (Blueprint $table) {
                $table->unsignedInteger('content_id')
                    ->nullable();
                $table->unsignedInteger('contentset_id')
                    ->nullable();
                
                
                $table->foreign('content_id')
                    ->references('id')
                    ->on('educationalcontents')
                    ->onDelete('cascade')
                    ->onupdate('cascade');
                
                $table->foreign('contentset_id')
                    ->references('id')
                    ->on('contentsets')
                    ->onDelete('cascade')
                    ->onupdate('cascade');
                
                
            });
        } catch (Illuminate\Database\QueryException $e) {
        
        }
        DB::commit();
        Artisan::call('alaaTv:convert:productFilesToContent');
    }
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('contentset_product')
            ->truncate();
    }
}
