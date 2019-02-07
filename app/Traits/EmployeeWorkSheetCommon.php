<?php namespace App\Traits;

use App\Employeetimesheet;

trait EmployeeWorkSheetCommon
{
    use TimeCommon;

    /**
     * Sum the employeeTimeSheet workAndShiftDiff
     * @param $workTimeSheets
     * @return string
     */
    public function sumRealWorkTime($workTimeSheets)
    {
        $totalRealWorkTime = 0;   //In seconds
        /** @var Employeetimesheet $workTimeSheet */
        foreach ($workTimeSheets as $workTimeSheet) {
            $totalRealWorkTime += $workTimeSheet->obtainRealWorkTime("IN_SECONDS");
        }
        return $this->convertSecToHour(abs($totalRealWorkTime));
    }

    /**
     * Sum the employeeTimeSheet realWorkTime
     * @param $workTimeSheets
     * @return string
     */
    public function sumWorkAndShiftDiff($workTimeSheets)
    {
        $totalConfirmedWorkAndShiftDiff = 0;   //In seconds
        $totalUnConfirmedWorkAndShiftDiff = 0;   //In seconds
        /** @var Employeetimesheet $workTimeSheet */
        foreach ($workTimeSheets as $workTimeSheet) {
            if ($workTimeSheet->overtime_confirmation) {
                $totalConfirmedWorkAndShiftDiff += $workTimeSheet->obtainWorkAndShiftDiff("IN_SECONDS");
            } else {
                $totalUnConfirmedWorkAndShiftDiff += $workTimeSheet->obtainWorkAndShiftDiff("IN_SECONDS");
            }
        }
        if ($totalConfirmedWorkAndShiftDiff < 0) {
            return "- " . $this->convertSecToHour(abs($totalConfirmedWorkAndShiftDiff));
        } else {
            return "+ " . $this->convertSecToHour(abs($totalConfirmedWorkAndShiftDiff));
        }
    }

}