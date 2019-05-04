<?php

namespace App\Console\Commands;

use App\User;
use Carbon\Carbon;
use App\Traits\Helper;
use App\Employeeschedule;
use App\Traits\DateCommon;
use App\Employeetimesheet;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;

class CloseEmployeeTimeSheet extends Command
{
    use Helper;
    use DateCommon;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:lockemployeetimes';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Finalizing employee time sheet of today';
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $smsNumber       = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
        $dayOfWeekJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
            ->format('l'));
        $toDayDate       = Carbon::today('Asia/Tehran')
            ->format("Y-m-d");
        $employees       = User::whereHas("roles", function ($q) {
            $q->where("name", Config::get("constants.EMPLOYEE_ROLE"));
        })
            ->get();
        foreach ($employees as $employee) {
            $employeeSchedule  = Employeeschedule::where("user_id", $employee->id)
                ->where("day", $dayOfWeekJalali)
                ->first();
            $employeeTimeSheet = Employeetimesheet::where("user_id", $employee->id)
                ->where("date", $toDayDate)
                ->first();
            $done              = false;
            if (!isset($employeeTimeSheet)) {
                $newEmplployeeTimeSheet = new Employeetimesheet();
                
                $newEmplployeeTimeSheet->date    = $toDayDate;
                $newEmplployeeTimeSheet->user_id = $employee->id;
                if (isset($employeeSchedule)) {
                    $newEmplployeeTimeSheet->userBeginTime          = $employeeSchedule->getOriginal("beginTime");
                    $newEmplployeeTimeSheet->userFinishTime         = $employeeSchedule->getOriginal("finishTime");
                    $newEmplployeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal("lunchBreakInSeconds");
                }
                $newEmplployeeTimeSheet->clockIn                = "00:00:00";
                $newEmplployeeTimeSheet->beginLunchBreak        = "00:00:00";
                $newEmplployeeTimeSheet->finishLunchBreak       = "00:00:00";
                $newEmplployeeTimeSheet->clockOut               = "00:00:00";
                $newEmplployeeTimeSheet->breakDurationInSeconds = 0;
                $newEmplployeeTimeSheet->managerComment         = "ثبت توسط سیستم : مرخصی یا تعطیلی غیر رسمی";
                $newEmplployeeTimeSheet->employeeComment        = null;
                $newEmplployeeTimeSheet->timeSheetLock          = 1;
                $newEmplployeeTimeSheet->isPaid                 = 1;
                $newEmplployeeTimeSheet->workdaytype_id         = 1;
                
                if ($newEmplployeeTimeSheet->save()) {
                    $realWorkTime = $newEmplployeeTimeSheet->obtainRealWorkTime('IN_SECONDS');
                    $done         = $newEmplployeeTimeSheet->id;
                } else {
                    $done = false;
                }
            } elseif (!$employeeTimeSheet->getOriginal("timeSheetLock")) {
                if (strcmp($employeeTimeSheet->clockIn, "00:00:00") == 0) {
                    if (strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockIn = $employeeTimeSheet->beginLunchBreak;
                    } elseif (strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockIn = $employeeTimeSheet->finishLunchBreak;
                    } elseif (strcmp($employeeTimeSheet->clockOut, "00:00:00") != 0) {
                        $employeeTimeSheet->clockIn = $employeeTimeSheet->clockOut;
                    }
                }
                if (strcmp($employeeTimeSheet->clockOut, "00:00:00") == 0) {
                    if (strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockOut = $employeeTimeSheet->finishLunchBreak;
                    } elseif (strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockOut = $employeeTimeSheet->beginLunchBreak;
                    } elseif (strcmp($employeeTimeSheet->clockIn, "00:00:00") != 0) {
                        $employeeTimeSheet->clockOut = $employeeTimeSheet->clockIn;
                    }
                }
                
                if (strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") == 0 &&
                    strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                    if (strcmp($employeeTimeSheet->clockIn, "00:00:00") != 0) {
                        $employeeTimeSheet->beginLunchBreak = $employeeTimeSheet->clockIn;
                    }
                }
                
                if (strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") == 0 &&
                    strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                    if (strcmp($employeeTimeSheet->clockOut, "00:00:00") != 0) {
                        $employeeTimeSheet->finishLunchBreak = $employeeTimeSheet->clockOut;
                    }
                }

//                    $employeeTimeSheet->managerComment = $employeeTimeSheet->managerComment." ثبت توسط سیستم : مرخصی یا تعطیلی غیر رسمی";
                $employeeTimeSheet->timeSheetLock = 1;
                $realWorkTime                     = $employeeTimeSheet->obtainRealWorkTime('IN_SECONDS');
                if ($realWorkTime <= 0) {
                    $employeeTimeSheet->overtime_confirmation = true;
                }
                
                if ($employeeTimeSheet->update()) {
                    $done = $employeeTimeSheet->id;
                } else {
                    $done = false;
                }
                
            }
            
            if ($done) {
                $employeeTimeSheet = Employeetimesheet::all()
                    ->where("id", $done)
                    ->first();
                /**
                 * Sending auto generated password through SMS
                 */
//                    if(isset($employeeTimeSheet->getEmployeeFullName()[0]))
                if (isset($employeeTimeSheet->user->firstName)) {
                    $message = "سلام ".$employeeTimeSheet->user->firstName." عزیز";
                } else {
                    $message = "سلام";
                }
                
                $message = $message."\n";
                
                $todayJalaliDate        = $this->convertDate($toDayDate, "toJalali");
                $todayJalaliDate        = explode("/", $todayJalaliDate);
                $jalaliYear             = $todayJalaliDate[0];
                $jalaliMonth            = $this->convertToJalaliMonth($todayJalaliDate[1]);
                $jalaliDay              = $todayJalaliDate[2];
                $jalaliYear             = substr($jalaliYear, -2);
                $todayJalaliDateCaption = "امروز: ";
                $todayJalaliDateCaption = $jalaliDay." ".$jalaliMonth." ".$jalaliYear;
                $message                .= $todayJalaliDateCaption."\n";
                $persianShiftTime       = $employeeTimeSheet->obtainShiftTime("PERSIAN_FORMAT");
                
                if ($persianShiftTime !== 0) {
                    $message .= "موظفی: ".$persianShiftTime;
                    $message = $message."\n";
                    /*$realWorkTime = $employeeTimeSheet->obtainRealWorkTime("IN_SECONDS");*/
                    if ($realWorkTime !== false) {
                        if ($realWorkTime == 0) {
                            $message .= "مرخصی: ".$persianShiftTime;
                        } else {
                            $message .= "اضافه کاری: ".$employeeTimeSheet->obtainWorkAndShiftDiff("HOUR_FORMAT");
                        }
                    } else {
                        $message .= "خطا";
                    }
                    
                    if (isset($employee->mobile[0])) {
                        $smsInfo            = [];
                        $smsInfo["to"]      = [ltrim($employee->mobile, '0')];
                        $smsInfo["from"]    = $smsNumber;
                        $smsInfo["message"] = $message;
                        $response           = $this->medianaSendSMS($smsInfo);
                    } else {
                        $smsInfo            = [];
                        $smsInfo["to"]      = [ltrim("09190195476", '0')];
                        $smsInfo["from"]    = $smsNumber;
                        $smsInfo["message"] = $message;
                        $response           = $this->medianaSendSMS($smsInfo);
                    }
                }
            }
        }
        
        
    }
}
