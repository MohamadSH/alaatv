<?php

namespace App\Console\Commands;

use App\Employeetimesheet;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckEmployeeOvertime extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alaaTv:employee:check:overtime:confirmation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Checks employees overtime confirmation';

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
        $workTimeSheets = Employeetimesheet::where('overtime_status_id' , config('constants.EMPLOYEE_OVERTIME_STATUS_UNCONFIRMED'))->get();
        $workTimeSheetCount = $workTimeSheets->count();
        if ($this->confirm('There are '. $workTimeSheetCount .' unconfirmed overtime sheets. Do you want to reject them?', true)) {
            $now = Carbon::now();
            $bar = $this->output->createProgressBar($workTimeSheetCount);
            $rejectedTimeSheetCount = 0;
            foreach ($workTimeSheets as $workTimeSheet) {
                $splitedDate = explode('-' , $workTimeSheet->getOriginal('date'));
                $timePoint = Carbon::createMidnightDate( $splitedDate[0] , $splitedDate[1] , $splitedDate[2])->addDay();
                if($now->diffInMinutes($timePoint) >= 1440){// = 24 hours
                    $updateResult = $workTimeSheet->update([
                        'overtime_status_id' => config('constants.EMPLOYEE_OVERTIME_STATUS_REJECTED') ,
                    ]);
                    if($updateResult){
                        $rejectedTimeSheetCount++;
                    }
                }
                $bar->advance();
            }
            $bar->finish();
            $this->info("\n");
            $this->info('Rejected overtimes : '.$rejectedTimeSheetCount);
            $this->info("\n");
            $this->info('Process completed successfully!');
        }
    }
}
