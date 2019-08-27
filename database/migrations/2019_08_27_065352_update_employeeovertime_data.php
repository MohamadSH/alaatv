<?php

use App\Employeetimesheet;
use Illuminate\Database\Migrations\Migration;

class UpdateEmployeeovertimeData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $timesheets = Employeetimesheet::all();
        foreach ($timesheets as $timesheet) {
            if($timesheet->overtime_confirmation){
                $timesheet->overtime_status_id = 2;
            }else{
                $timesheet->overtime_status_id = 1;
            }
            $timesheet->update();
        }
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
