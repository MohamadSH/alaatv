<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeovertimestatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employeeovertimestatus', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('نام وضعیت');
            $table->string('display_name')->nullable()->comment('نام قابل نمایش وضعیت')->after('modifier_id');
            $table->timestamps();
            $table->softDeletes();
        });
        DB::statement("ALTER TABLE `employeeovertimestatus` comment 'وضعیت اضافه کاری ساعت کاری کارمندان'");

        $data = [
            [
                'id'          => '1',
                'name'        => 'unConfirmed',
                'display_name' => 'تایید نشده',
                'created_at'    => Carbon::now('Asia/Tehran')
            ],
            [
                'id'          => '2',
                'name'        => 'confirmed',
                'display_name' => 'تایید شده',
                'created_at'    => Carbon::now('Asia/Tehran')
            ],
            [
                'id'          => '3',
                'name'        => 'rejected',
                'display_name' => 'رد شده',
                'created_at'    => Carbon::now('Asia/Tehran')
            ],
        ];
        DB::table('employeeovertimestatus')
            ->insert($data); // Query Builder
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employeeovertimestatus');
    }
}
