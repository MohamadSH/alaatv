<?php

namespace App\Console;

use App\Employeeschedule;
use App\Employeetimesheet;
use App\Traits\DateCommon;
use App\Traits\Helper;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Config;

class Kernel extends ConsoleKernel
{
    use Helper;
    use DateCommon ;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $smsNumber = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
        $schedule->call(function () use( $smsNumber ){
            $dayOfWeekJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')->format('l')) ;
            $toDayDate = Carbon::today('Asia/Tehran')->format("Y-m-d") ;
            $employees = User::whereHas("roles" , function ($q){
                $q->where("name" , Config::get("constants.EMPLOYEE_ROLE")) ;
            })->get();
            foreach ($employees as $employee)
            {
                $employeeSchedule = Employeeschedule::where("user_id", $employee->id)->where("day" , $dayOfWeekJalali)->get()->first();
                $employeeTimeSheet = Employeetimesheet::where("user_id" , $employee->id)->where("date" , $toDayDate)->get();
                $done = false ;
                if($employeeTimeSheet->isEmpty()){
                    $newEmplployeeTimeSheet = new Employeetimesheet();

                    $newEmplployeeTimeSheet->date = $toDayDate;
                    $newEmplployeeTimeSheet->user_id = $employee->id ;
                    if(isset($employeeSchedule))
                    {
                        $newEmplployeeTimeSheet->userBeginTime = $employeeSchedule->getOriginal("beginTime");
                        $newEmplployeeTimeSheet->userFinishTime = $employeeSchedule->getOriginal("finishTime");
                        $newEmplployeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal("lunchBreakInSeconds");
                    }
                    $newEmplployeeTimeSheet->clockIn = "00:00:00";
                    $newEmplployeeTimeSheet->beginLunchBreak = "00:00:00";
                    $newEmplployeeTimeSheet->finishLunchBreak = "00:00:00";
                    $newEmplployeeTimeSheet->clockOut = "00:00:00";
                    $newEmplployeeTimeSheet->breakDurationInSeconds = 0 ;
                    $newEmplployeeTimeSheet->managerComment = "ثبت توسط سیستم : مرخصی یا تعطیلی غیر رسمی";
                    $newEmplployeeTimeSheet->employeeComment = null;
                    $newEmplployeeTimeSheet->timeSheetLock = 1;
                    $newEmplployeeTimeSheet->isPaid = 1;
                    $newEmplployeeTimeSheet->workdaytype_id = 1;

                    if($newEmplployeeTimeSheet->save())
                        $done = $newEmplployeeTimeSheet->id;
                    else
                        $done = false;
                }elseif(!$employeeTimeSheet->first()->getOriginal("timeSheetLock")){
                    $employeeTimeSheet = $employeeTimeSheet->first();
                    if(strcmp($employeeTimeSheet->clockIn , "00:00:00") == 0 )
                    {
                        if(strcmp($employeeTimeSheet->beginLunchBreak , "00:00:00") != 0 )
                            $employeeTimeSheet->clockIn = $employeeTimeSheet->beginLunchBreak ;
                        elseif(strcmp($employeeTimeSheet->finishLunchBreak , "00:00:00") != 0 )
                            $employeeTimeSheet->clockIn = $employeeTimeSheet->finishLunchBreak ;
                        elseif(strcmp($employeeTimeSheet->clockOut , "00:00:00") != 0 )
                            $employeeTimeSheet->clockIn = $employeeTimeSheet->clockOut ;
                    }
                    if(strcmp($employeeTimeSheet->clockOut , "00:00:00") == 0 )
                    {
                        if(strcmp($employeeTimeSheet->finishLunchBreak , "00:00:00") != 0 )
                            $employeeTimeSheet->clockOut = $employeeTimeSheet->finishLunchBreak ;
                        elseif(strcmp($employeeTimeSheet->beginLunchBreak , "00:00:00") != 0 )
                            $employeeTimeSheet->clockOut = $employeeTimeSheet->beginLunchBreak ;
                        elseif(strcmp($employeeTimeSheet->clockIn , "00:00:00") != 0 )
                            $employeeTimeSheet->clockOut = $employeeTimeSheet->clockIn ;
                    }

                    if(strcmp($employeeTimeSheet->beginLunchBreak , "00:00:00") == 0 &&
                        strcmp($employeeTimeSheet->finishLunchBreak , "00:00:00") != 0)
                    {
                        if(strcmp($employeeTimeSheet->clockIn , "00:00:00") != 0 )
                            $employeeTimeSheet->beginLunchBreak = $employeeTimeSheet->clockIn ;
                    }

                    if(strcmp($employeeTimeSheet->finishLunchBreak , "00:00:00") == 0 &&
                        strcmp($employeeTimeSheet->beginLunchBreak , "00:00:00") != 0)
                    {
                        if(strcmp($employeeTimeSheet->clockOut , "00:00:00") != 0 )
                            $employeeTimeSheet->finishLunchBreak = $employeeTimeSheet->clockOut ;
                    }

                    $employeeTimeSheet->managerComment = $employeeTimeSheet->managerComment." ثبت توسط سیستم : مرخصی یا تعطیلی غیر رسمی";
                    $employeeTimeSheet->timeSheetLock = 1;

                    if($employeeTimeSheet->update())
                        $done = $employeeTimeSheet->id;
                    else
                        $done = false;
                }

                if($done)
                {
                    $employeeTimeSheet = Employeetimesheet::all()->where("id" , $done)->first() ;
                    /**
                     * Sending auto generated password through SMS
                     */
                    if(isset($employeeTimeSheet->getEmployeeFullName()[0]))
                        $message = $employeeTimeSheet->getEmployeeFullName()." عزیز، " ;
                    else $message = "" ;
                    $message .= "سلام ممنون از زحمات شما"."\n";
                    $todayJalaliDate = $this->convertDate($toDayDate , "toJalali");
                    $todayJalaliDate = explode("/" , $todayJalaliDate);
                    $jalaliYear = $todayJalaliDate[0];
                    $jalaliMonth = $this->convertToJalaliMonth($todayJalaliDate[1]);
                    $jalaliDay = $todayJalaliDate[2];
                    $todayJalaliDateCaption = $jalaliDay . " ". $jalaliMonth. " ".$jalaliYear ;
                    $message .= "امروز: ".$todayJalaliDateCaption."\n" ;
                    $persianShiftTime = $employeeTimeSheet->obtainShiftTime("PERSIAN_FORMAT") ;
                    $message .= "شیفت کاری: ". $persianShiftTime."\n";

                    if($persianShiftTime !== 0)
                    {
                        $realWorkTime = $employeeTimeSheet->obtainRealWorkTime("IN_SECONDS") ;
                        if( $realWorkTime !== false)
                            if($realWorkTime == 0)
                                $message .= " مرخصی: ".$persianShiftTime."\n" ;
                            else
                                $message .= " اضافه کاری: ".$employeeTimeSheet->obtainWorkAndShiftDiff("PERSIAN_FORMAT")."\n" ;
                        else
                            $message .= "خطا در محاسبه ساعت کاری رخ داد"."\n" ;
                        if(isset($employee->mobile[0]))
                        {
                            $smsInfo = array();
                            $smsInfo["to"] = array(ltrim($employee->mobile, '0'));
                            $smsInfo["from"] = $smsNumber;
                            $smsInfo["message"] = $message ;
                            $response = $this->medianaSendSMS($smsInfo);
                        }else{
                            $smsInfo = array();
                            $smsInfo["to"] = array(ltrim("09190195476", '0'));
                            $smsInfo["from"] = $smsNumber;
                            $smsInfo["message"] = $message ;
                            $response = $this->medianaSendSMS($smsInfo);
                        }
                    }
                }
            }

        })
            ->dailyAt('22:30')
            ->timezone('Asia/Tehran') ;
        $schedule->command('backup:mysql-dump')
            ->timezone('Asia/Tehran')
            ->dailyAt('04:30');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
