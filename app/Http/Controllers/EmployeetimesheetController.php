<?php

namespace App\Http\Controllers;

use App\Employeeschedule;
use App\Employeetimesheet;
use App\Http\Requests\InsertEmployeeTimeSheet;
use App\Traits\DateTrait;
use App\Traits\EmployeeWorkSheetCommon;
use App\User;
use App\Workdaytype;
use Auth;
use Carbon\Carbon;
use Config;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class EmployeetimesheetController extends Controller
{
    use DateTrait;
    use EmployeeWorkSheetCommon;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('ability:' . Config::get("constants.EMPLOYEE_ROLE") . ',' . Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"), ['only' => 'index']);
        $this->middleware('ability:' . Config::get("constants.EMPLOYEE_ROLE") . '|,' . Config::get("constants.INSERT_EMPLOPYEE_WORK_SHEET") . '|' . Config::get("constants.LIST_EMPLOPYEE_WORK_SHEET"), ['only' => ['create']]);
        $this->middleware('permission:' . Config::get('constants.INSERT_EMPLOPYEE_WORK_SHEET'), ['only' => 'store']);
        $this->middleware('permission:' . Config::get('constants.REMOVE_EMPLOPYEE_WORK_SHEET'), ['only' => 'destroy']);
        $this->middleware('permission:' . Config::get('constants.EDIT_EMPLOPYEE_WORK_SHEET'), [
            'only' => [
                'edit',
                'update',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employeeTimeSheets = Employeetimesheet::orderBy('date', 'Desc');
        if (Input::has("users")) {
            $usersId = Input::get("users");
            $employeeTimeSheets = $employeeTimeSheets->whereIn("user_id", $usersId);
        }

        if (Input::has("dateEnable")) {
            if (Input::has("sinceDate") && Input::has("tillDate")) {
                $sinceDate = Input::get("sinceDate");
                $tillDate = Input::get("tillDate");
                $employeeTimeSheets = $employeeTimeSheets->whereBetween('date', [
                    explode("T", $sinceDate)[0],
                    explode("T", $tillDate)[0],
                ]);
            }
        }

        if (Input::has("workdayTypes")) {
            $workDayTypes = Input::get("workdayTypes");
            $employeeTimeSheets = $employeeTimeSheets->whereIn('workdaytype_id', $workDayTypes);
        }

        if (Input::has("isPaid")) {
            $isPaid = Input::get("isPaid");
            if (isset($isPaid[0])) {
                $employeeTimeSheets = $employeeTimeSheets->where('isPaid', $isPaid);
            }
        }

        $employeeTimeSheets = $employeeTimeSheets->get();
        $employeeWorkSheetSum = $this->sumWorkAndShiftDiff($employeeTimeSheets);
        $employeeSumRealWorkTime = $this->sumRealWorkTime($employeeTimeSheets);
        $result = [
            'index'                => View::make("employeeTimeSheet.index", compact('employeeTimeSheets', 'employeeWorkSheetSum'))
                                          ->render(),
            "employeeWorkSheetSum" => $employeeWorkSheetSum,
            "employeeRealWorkTime" => $employeeSumRealWorkTime,
        ];

        return response(json_encode($result, JSON_UNESCAPED_UNICODE), 200)->header('Content-Type', 'application/json');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $userId = $user->id;
        $userTodayTimeSheets = Employeetimesheet::where("date", Carbon::today('Asia/Tehran'))
                                                ->where("user_id", $user->id)
                                                ->get();
        if ($userTodayTimeSheets->count() > 1) {
            session()->flash("warning", "شما برای امروز بیش از یک ساعت کاری وارد نموده اید!");
            $formVisible = false;
        } else {
            $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
                                                           ->format('l'));
            $employeeSchedule = Employeeschedule::where("user_id", $userId)
                                                ->where("day", $toDayJalali)
                                                ->get()
                                                ->first();
            if ($userTodayTimeSheets->isNotEmpty()) {
                $employeetimesheet = $userTodayTimeSheets->first();
                if ($employeetimesheet->workdaytype_id == Config::get("constants.WORKDAY_ID_EXTRA"))
                    $isTimeSheetExtra = true;
                else
                    $isTimeSheetExtra = false;
            }
            $formVisible = true;
        }
        $employees = User::select()
                         ->role([Config::get("constants.ROLE_EMPLOYEE")])
                         ->pluck("lastName", "id");
        $workdayTypes = Workdaytype::all()
                                   ->pluck("displayName", "id");
        return view("employeeTimeSheet.create", compact("employeetimesheet", "employeeSchedule", "isTimeSheetExtra", "toDay", "employees", "formVisible", "workdayTypes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertEmployeeTimeSheet $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(InsertEmployeeTimeSheet $request)
    {
        $user = Auth::user();
        if (!$request->has("modifier_id")) {
            $request->offsetSet("modifier_id", $user->id);
        }

        $employeeTimeSheet = new Employeetimesheet();
        $employeeTimeSheet->fill($request->all());

        if ($request->has("isExtraDay")) {
            $employeeTimeSheet->workdaytype_id = Config::get("constants.WORKDAY_ID_EXTRA");
            $employeeTimeSheet->isPaid = 0;
        } else {
            $employeeTimeSheet->workdaytype_id = Config::get("constants.WORKDAY_ID_USUAL");
            $employeeTimeSheet->isPaid = 1;
        }

        if ($request->has("timeSheetLock")) {
            $employeeTimeSheet->timeSheetLock = 1;
        }

        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
                                                       ->format('l'));
        $employeeSchedule = Employeeschedule::where("user_id", $employeeTimeSheet->user_id)
                                            ->where("day", $toDayJalali)
                                            ->get()
                                            ->first();

        $allowedLunchBreak = $employeeTimeSheet->getOriginal("allowedLunchBreakInSec");
        if (!isset($allowedLunchBreak)) {
            if (isset($employeeSchedule))
                $employeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal("lunchBreakInSeconds");
        }

        $beginTime = $employeeTimeSheet->getOriginal("userBeginTime");
        if (!isset($beginTime)) {
            if (isset($employeeSchedule))
                $employeeTimeSheet->userBeginTime = $employeeSchedule->getOriginal("beginTime");
        }

        $finishTime = $employeeTimeSheet->getOriginal("userFinishTime");
        if (!isset($finishTime)) {
            if (isset($employeeSchedule))
                $employeeTimeSheet->userFinishTime = $employeeSchedule->getOriginal("finishTime");
        }
        $done = $employeeTimeSheet->save();
        if ($done)
            if ($request->has("serverSide")) {
                return true;
            } else {
                session()->flash("success", "ساعت کاری با موفقیت درج شد");
                return redirect()->back();
            }
        else
            if ($request->has("serverSide")) {
                return false;
            } else {
                session()->flash("error", \Lang::get("responseText.Database error."));
                return redirect()->back();
            }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Employeetimesheet $employeetimesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Employeetimesheet $employeetimesheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Employeetimesheet $employeetimesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Employeetimesheet $employeetimesheet)
    {
        if ($employeetimesheet->workdaytype_id == Config::get("constants.WORKDAY_ID_EXTRA")) {
            $isExtra = true;
        } else if ($employeetimesheet->workdaytype_id == Config::get("constants.WORKDAY_ID_USUAL")) {
            $isExtra = false;
        }
        return view("employeeTimeSheet.edit", compact("employeetimesheet", "isExtra"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Employeetimesheet   $employeeTimeSheet
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employeetimesheet $employeeTimeSheet)
    {
        $user = Auth::user();
        if (!$request->has("modifier_id")) {
            $request->offsetSet("modifier_id", $user->id);
        }

        $employeeTimeSheet->fill($request->all());
        if ($request->has("isExtraDay")) {
            $employeeTimeSheet->workdaytype_id = Config::get("constants.WORKDAY_ID_EXTRA");
            $employeeTimeSheet->isPaid = 0;
        } else {
            $employeeTimeSheet->workdaytype_id = Config::get("constants.WORKDAY_ID_USUAL");
            $employeeTimeSheet->isPaid = 1;
        }

        if ($request->has("timeSheetLock")) {
            $employeeTimeSheet->timeSheetLock = 1;
        } else {
            $employeeTimeSheet->timeSheetLock = 0;
        }

        if ($request->has("isPaid")) {
            $employeeTimeSheet->isPaid = 1;
        } else {
            $employeeTimeSheet->isPaid = 0;
        }


        $done = $employeeTimeSheet->update();
        if ($done)
            if ($request->has("serverSide")) {
                return true;
            } else {
                session()->flash("success", "ساعت کاری با موفقیت اصلاح شد");
                return redirect()->back();
            }
        else
            if ($request->has("serverSide")) {
                return false;
            } else {
                session()->flash("error", \Lang::get("responseText.Database error."));
                return redirect()->back();
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employeetimesheet $employeetimesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employeetimesheet $employeetimesheet, Response $response)
    {
        if ($employeetimesheet->delete())
            return $response->setStatusCode(200);
        else
            return $response->setStatusCode(503);
    }
}
