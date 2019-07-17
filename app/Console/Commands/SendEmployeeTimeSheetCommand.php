<?php

namespace App\Console\Commands;

use App\Employeeschedule;
use App\Employeetimesheet;
use App\Notifications\EmployeeTimeSheetNotification;
use App\Traits\DateTrait;
use App\Traits\User\EmployeeTrait;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SendEmployeeTimeSheetCommand extends Command
{
    use DateTrait;
    use EmployeeTrait;
    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:employee:send:timeSheet {employee : The ID of the employee}';
    
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send TimeSheet to employee';
    
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
        $employeeId = (int) $this->argument('employee');
        if ($employeeId > 0) {
            try {
                $user = User::findOrFail($employeeId);
            } catch (ModelNotFoundException $exception) {
                $this->error($exception->getMessage());
                
                return;
            }
            if ($this->confirm('You have chosen '.$user->full_name.'. Do you wish to continue?', true)) {
                $this->performTimeSheetTaskForAnEmployee($user);
            }
        }
        else {
            $this->performTimeSheetTaskForAllEmployee();
        }
    }
    
    private function performTimeSheetTaskForAnEmployee(User $user)
    {
        $this->info("send TimeSheet to".$user->full_name);
        $dayOfWeekJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
            ->format('l'));
        $toDayDate       = Carbon::today('Asia/Tehran')
            ->format("Y-m-d");
        $this->calculate($user, $dayOfWeekJalali, $toDayDate);
    }
    
    private function calculate(User $employee, $dayOfWeekJalali, $toDayDate)
    {
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
            }
            else {
                $done = false;
            }
        }
        elseif (!$employeeTimeSheet->getOriginal("timeSheetLock")) {
            if (strcmp($employeeTimeSheet->clockIn, "00:00:00") == 0) {
                if (strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                    $employeeTimeSheet->clockIn = $employeeTimeSheet->beginLunchBreak;
                }
                else {
                    if (strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockIn = $employeeTimeSheet->finishLunchBreak;
                    }
                    else {
                        if (strcmp($employeeTimeSheet->clockOut, "00:00:00") != 0) {
                            $employeeTimeSheet->clockIn = $employeeTimeSheet->clockOut;
                        }
                    }
                }
            }
            if (strcmp($employeeTimeSheet->clockOut, "00:00:00") == 0) {
                if (strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                    $employeeTimeSheet->clockOut = $employeeTimeSheet->finishLunchBreak;
                }
                else {
                    if (strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                        $employeeTimeSheet->clockOut = $employeeTimeSheet->beginLunchBreak;
                    }
                    else {
                        if (strcmp($employeeTimeSheet->clockIn, "00:00:00") != 0) {
                            $employeeTimeSheet->clockOut = $employeeTimeSheet->clockIn;
                        }
                    }
                }
            }

            if (strcmp($employeeTimeSheet->beginLunchBreak,
                    "00:00:00") == 0 && strcmp($employeeTimeSheet->finishLunchBreak, "00:00:00") != 0) {
                if (strcmp($employeeTimeSheet->clockIn, "00:00:00") != 0) {
                    $employeeTimeSheet->beginLunchBreak = $employeeTimeSheet->clockIn;
                }
            }

            if (strcmp($employeeTimeSheet->finishLunchBreak,
                    "00:00:00") == 0 && strcmp($employeeTimeSheet->beginLunchBreak, "00:00:00") != 0) {
                if (strcmp($employeeTimeSheet->clockOut, "00:00:00") != 0) {
                    $employeeTimeSheet->finishLunchBreak = $employeeTimeSheet->clockOut;
                }
            }

//            $employeeTimeSheet->managerComment = $employeeTimeSheet->managerComment . " ثبت توسط سیستم : مرخصی یا تعطیلی غیر رسمی";
            $employeeTimeSheet->timeSheetLock = 1;

            $realWorkTime = $employeeTimeSheet->obtainRealWorkTime('IN_SECONDS');
            if ($realWorkTime <= 0) {
                $employeeTimeSheet->overtime_confirmation = true;
            }

            if ($employeeTimeSheet->update()) {
                $done = $employeeTimeSheet->id;
            }
            else {
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
            
            $todayJalaliDate        = $this->convertDate($toDayDate, "toJalali");
            $todayJalaliDate        = explode("/", $todayJalaliDate);
            $jalaliYear             = $todayJalaliDate[0];
            $jalaliMonth            = $this->convertToJalaliMonth($todayJalaliDate[1]);
            $jalaliDay              = $todayJalaliDate[2];
            $jalaliYear             = substr($jalaliYear, -2);
            $todayJalaliDateCaption = $jalaliDay." ".$jalaliMonth." ".$jalaliYear;
            $persianShiftTime       = $employeeTimeSheet->obtainShiftTime("PERSIAN_FORMAT");
            
            if ($persianShiftTime !== 0) {
                $date     = $todayJalaliDateCaption;
                $in       = $employeeTimeSheet->clockIn;
                $out      = $employeeTimeSheet->clockOut;
                $movazafi = $persianShiftTime;
                $ezafe    = $employeeTimeSheet->obtainWorkAndShiftDiff("HOUR_FORMAT");
                $employeeTimeSheet->user->notify(new EmployeeTimeSheetNotification($date, $in, $out, $movazafi,
                    $ezafe));
            }
        }
    }
    
    private function performTimeSheetTaskForAllEmployee()
    {
        $users = $this->getEmployee();
        $bar   = $this->output->createProgressBar($users->count());
        foreach ($users as $user) {
            $this->performTimeSheetTaskForAnEmployee($user);
            $bar->advance();
        }
        $bar->finish();
        $this->info("");
    }
}
