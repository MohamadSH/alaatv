<?php namespace App\Traits;

trait EmployeeWorkSheetCommon
{
    use TimeCommon;
    /**
     * Sum the employeeTimeSheet workAndShiftDiff
     */
    public function sumRealWorkTime($workTimeSheets)
    {
        $totalRealWorkTime = 0 ;   //In seconds
        foreach ($workTimeSheets as $workTimeSheet)
        {
                $totalRealWorkTime += $workTimeSheet->obtainRealWorkTime("IN_SECONDS");
        }
        return $this->convertSecToHour(abs($totalRealWorkTime));
    }

    /**
     * Sum the employeeTimeSheet realWorkTime
     */
    public function sumWorkAndShiftDiff($workTimeSheets)
    {
        $totalWorkAndShiftDiff = 0 ;   //In seconds
        foreach ($workTimeSheets as $workTimeSheet)
        {
            $totalWorkAndShiftDiff += $workTimeSheet->obtainWorkAndShiftDiff("IN_SECONDS");
        }
        if ($totalWorkAndShiftDiff < 0) {
            return "- " .$this->convertSecToHour(abs($totalWorkAndShiftDiff));
        } else {
            return "+ " .$this->convertSecToHour(abs($totalWorkAndShiftDiff)) ;
        }
    }

}