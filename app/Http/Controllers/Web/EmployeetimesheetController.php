<?php

namespace App\Http\Controllers\Web;

use App\User;
use Carbon\Carbon;
use App\Workdaytype;
use App\Employeeschedule;
use App\Traits\DateTrait;
use App\Employeetimesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Input;
use App\Traits\EmployeeWorkSheetCommon;
use App\Http\Requests\InsertEmployeeTimeSheet;

class EmployeetimesheetController extends Controller
{
    use DateTrait;
    use EmployeeWorkSheetCommon;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('ability:'.config('constants.EMPLOYEE_ROLE').','.config('constants.LIST_EMPLOPYEE_WORK_SHEET'),
            ['only' => 'index']);
        $this->middleware('ability:'.config('constants.EMPLOYEE_ROLE').'|,'.config('constants.INSERT_EMPLOPYEE_WORK_SHEET').'|'.config('constants.LIST_EMPLOPYEE_WORK_SHEET'),
            ['only' => ['create']]);
        $this->middleware('permission:'.config('constants.INSERT_EMPLOPYEE_WORK_SHEET'), ['only' => 'store']);
        $this->middleware('permission:'.config('constants.REMOVE_EMPLOPYEE_WORK_SHEET'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.EDIT_EMPLOPYEE_WORK_SHEET'), [
            'only' => [
                'edit',
                'update',
            ],
        ]);
        $this->middleware('CanAccessEmployeeTimeSheet', [
            'except' => [
                'index',
                'create',
                'show',
            ],
        ]);
    }

    public function index()
    {
        /** @var Employeetimesheet $employeeTimeSheets */
        $employeeTimeSheets = Employeetimesheet::orderBy('date', 'Desc');
        if (Input::has("users")) {
            $usersId            = Input::get("users");
            $employeeTimeSheets = $employeeTimeSheets->whereIn("user_id", $usersId);
        }
        
        if (Input::has("dateEnable")) {
            if (Input::has("sinceDate") && Input::has("tillDate")) {
                $sinceDate          = Input::get("sinceDate");
                $tillDate           = Input::get("tillDate");
                $employeeTimeSheets = $employeeTimeSheets->whereBetween('date', [
                    explode("T", $sinceDate)[0],
                    explode("T", $tillDate)[0],
                ]);
            }
        }
        
        if (Input::has("workdayTypes")) {
            $workDayTypes       = Input::get("workdayTypes");
            $employeeTimeSheets = $employeeTimeSheets->whereIn('workdaytype_id', $workDayTypes);
        }
        
        if (Input::has("isPaid")) {
            $isPaid = Input::get("isPaid");
            if (isset($isPaid[0])) {
                $employeeTimeSheets = $employeeTimeSheets->where('isPaid', $isPaid);
            }
        }
        
        $employeeTimeSheets      = $employeeTimeSheets->get();
        $employeeWorkSheetSum    = $this->sumWorkAndShiftDiff($employeeTimeSheets);
        $employeeSumRealWorkTime = $this->sumRealWorkTime($employeeTimeSheets);
        $result                  = [
            'index'                => View::make("employeeTimeSheet.index",
                compact('employeeTimeSheets', 'employeeWorkSheetSum'))
                ->render(),
            "employeeWorkSheetSum" => $employeeWorkSheetSum,
            "employeeRealWorkTime" => $employeeSumRealWorkTime,
        ];
        
        return response(json_encode($result, JSON_UNESCAPED_UNICODE), Response::HTTP_OK)->header('Content-Type', 'application/json');
    }

    public function create()
    {
        /** @var User $user */
        $user   = Auth::user();
        $userId = $user->id;
        /** @var Employeetimesheet $userTodayTimeSheets */
        $userTodayTimeSheets = Employeetimesheet::where("date", Carbon::today('Asia/Tehran'))
            ->where("user_id", $user->id)
            ->get();
        $employeetimesheet=null;
        $isTimeSheetExtra=false;
        if ($userTodayTimeSheets->count() > 1) {
            session()->flash("warning", "شما برای امروز بیش از یک ساعت کاری وارد نموده اید!");
            $formVisible = false;
        }
        else {
            $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
                ->format('l'));
            /** @var Employeeschedule $employeeSchedule */
            $employeeSchedule = Employeeschedule::where("user_id", $userId)
                ->where("day", $toDayJalali)
                ->get()
                ->first();
            if ($userTodayTimeSheets->isNotEmpty()) {
                $employeetimesheet = $userTodayTimeSheets->first();
                if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_EXTRA")) {
                    $isTimeSheetExtra = true;
                }
                else {
                    $isTimeSheetExtra = false;
                }
            }
            $formVisible = true;
        }
        $employees    = User::select()
            ->role([config("constants.ROLE_EMPLOYEE")])
            ->pluck("lastName", "id");
        $workdayTypes = Workdaytype::all()
            ->pluck("displayName", "id");
        
        return view("employeeTimeSheet.create",
            compact("employeetimesheet", "employeeSchedule", "isTimeSheetExtra", "employees", "formVisible",
                "workdayTypes"));
    }

    public function store(InsertEmployeeTimeSheet $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (!$request->has("modifier_id")) {
            $request->offsetSet("modifier_id", $user->id);
        }
        
        $employeeTimeSheet = new Employeetimesheet();
        $employeeTimeSheet->fill($request->all());
        
        if ($request->has("isExtraDay")) {
            $employeeTimeSheet->workdaytype_id = config("constants.WORKDAY_ID_EXTRA");
            $employeeTimeSheet->isPaid         = 0;
        }
        else {
            $employeeTimeSheet->workdaytype_id = config("constants.WORKDAY_ID_USUAL");
            $employeeTimeSheet->isPaid         = 1;
        }
        
        if ($request->has("timeSheetLock")) {
            $employeeTimeSheet->timeSheetLock = 1;
        }
        
        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
            ->format('l'));
        /** @var Employeeschedule $employeeSchedule */
        $employeeSchedule = Employeeschedule::where("user_id", $employeeTimeSheet->user_id)
            ->where("day", $toDayJalali)
            ->get()
            ->first();
        
        $allowedLunchBreak = $employeeTimeSheet->getOriginal("allowedLunchBreakInSec");
        if (!isset($allowedLunchBreak)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal("lunchBreakInSeconds");
            }
        }
        
        $beginTime = $employeeTimeSheet->getOriginal("userBeginTime");
        if (!isset($beginTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userBeginTime = $employeeSchedule->getOriginal("beginTime");
            }
        }
        
        $finishTime = $employeeTimeSheet->getOriginal("userFinishTime");
        if (!isset($finishTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userFinishTime = $employeeSchedule->getOriginal("finishTime");
            }
        }
        $done = $employeeTimeSheet->save();
        if ($done) {
            if ($request->has("serverSide")) {
                return true;
            }
            else {
                session()->flash("success", "ساعت کاری با موفقیت درج شد");
                
                return redirect()->back();
            }
        }
        else {
            if ($request->has("serverSide")) {
                return false;
            }
            else {
                session()->flash("error", Lang::get("responseText.Database error."));
                
                return redirect()->back();
            }
        }
    }

    public function edit(Employeetimesheet $employeetimesheet)
    {
        if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_EXTRA")) {
            $isExtra = true;
        }
        else {
            if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_USUAL")) {
                $isExtra = false;
            }
        }
        
        return view("employeeTimeSheet.edit", compact("employeetimesheet", "isExtra"));
    }

    public function update(Request $request, Employeetimesheet $employeeTimeSheet)
    {
        $user = auth()->user();
        if (!$request->has('modifier_id')) {
            $request->offsetSet('modifier_id', $user->id);
        }
        $employeeTimeSheet->fill($request->all());
        if ($request->has('isExtraDay')) {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_EXTRA');
            $employeeTimeSheet->isPaid         = 0;
        } else {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_USUAL');
            $employeeTimeSheet->isPaid         = 1;
        }
        if ($request->has('timeSheetLock')) {
            $employeeTimeSheet->timeSheetLock = 1;
        } else {
            $employeeTimeSheet->timeSheetLock = 0;
        }
        if ($request->has('isPaid')) {
            $employeeTimeSheet->isPaid = 1;
        } else {
            $employeeTimeSheet->isPaid = 0;
        }
        $realWorkTime = $employeeTimeSheet->obtainRealWorkTime('IN_SECONDS');
        /*if(
            ($realWorkTime>0 &&
                !$user->can(config('constants.editEmployeeWorkSheet'))
            ) ||
            (
                $request->has('OvertimeConfirmation') &&
                $request->get('OvertimeConfirmation') == 1 &&
                $user->can(config('constants.editEmployeeWorkSheet'))
            )
        )*/
        if ($request->has('overtime_confirmation')) {
            $employeeTimeSheet->overtime_confirmation = true;
        } else {
            $employeeTimeSheet->overtime_confirmation = false;
        }
        $done = $employeeTimeSheet->update();
        if ($done)
            if ($request->has('serverSide')) {
                return true;
            } else {
                session()->flash('success', 'ساعت کاری با موفقیت اصلاح شد');
                return redirect()->back();
            }
        elseif ($request->has('serverSide')) {
                return false;
            } else {
            session()->flash('error', 'خطای پایگاه داده');
            return redirect()->back();
            }
    }

    public function destroy(Employeetimesheet $employeetimesheet, Response $response)
    {
        if ($employeetimesheet->delete()) {
            return $response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }
}
