<?php

namespace App\Http\Controllers\Web;

use App\Employeeschedule;
use App\Employeetimesheet;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertEmployeeTimeSheet;
use App\Traits\DateTrait;
use App\Traits\EmployeeWorkSheetCommon;
use App\User;
use App\Workdaytype;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;
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
        $this->middleware('ability:'.config("constants.EMPLOYEE_ROLE").','.config("constants.LIST_EMPLOPYEE_WORK_SHEET"), ['only' => 'index']);
        $this->middleware('ability:'.config("constants.EMPLOYEE_ROLE").'|,'.config("constants.INSERT_EMPLOPYEE_WORK_SHEET").'|'.config("constants.LIST_EMPLOPYEE_WORK_SHEET"),
            ['only' => ['create']]);
        $this->middleware('permission:'.config('constants.INSERT_EMPLOPYEE_WORK_SHEET'), ['only' => 'store']);
        $this->middleware('permission:'.config('constants.REMOVE_EMPLOPYEE_WORK_SHEET'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.EDIT_EMPLOPYEE_WORK_SHEET'), [
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
        /** @var Employeetimesheet $employeeTimeSheets */
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
            'index' => View::make("employeeTimeSheet.index", compact('employeeTimeSheets', 'employeeWorkSheetSum'))->render(),
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
        /** @var User $user */
        $user = Auth::user();
        $userId = $user->id;
        /** @var Employeetimesheet $userTodayTimeSheets */
        $userTodayTimeSheets = Employeetimesheet::where("date", Carbon::today('Asia/Tehran'))->where("user_id", $user->id)->get();
        if ($userTodayTimeSheets->count() > 1) {
            session()->flash("warning", "شما برای امروز بیش از یک ساعت کاری وارد نموده اید!");
            $formVisible = false;
        } else {
            $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')->format('l'));
            /** @var Employeeschedule $employeeSchedule */
            $employeeSchedule = Employeeschedule::where("user_id", $userId)->where("day", $toDayJalali)->get()->first();
            if ($userTodayTimeSheets->isNotEmpty()) {
                $employeetimesheet = $userTodayTimeSheets->first();
                if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_EXTRA")) {
                    $isTimeSheetExtra = true;
                } else {
                    $isTimeSheetExtra = false;
                }
            }
            $formVisible = true;
        }
        $employees = User::select()->role([config("constants.ROLE_EMPLOYEE")])->pluck("lastName", "id");
        $workdayTypes = Workdaytype::all()->pluck("displayName", "id");

        return view("employeeTimeSheet.create",
            compact("employeetimesheet", "employeeSchedule", "isTimeSheetExtra", "toDay", "employees", "formVisible", "workdayTypes"));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param InsertEmployeeTimeSheet $request
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function store(InsertEmployeeTimeSheet $request)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $request->has("modifier_id")) {
            $request->offsetSet("modifier_id", $user->id);
        }

        $employeeTimeSheet = new Employeetimesheet();
        $employeeTimeSheet->fill($request->all());

        if ($request->has("isExtraDay")) {
            $employeeTimeSheet->workdaytype_id = config("constants.WORKDAY_ID_EXTRA");
            $employeeTimeSheet->isPaid = 0;
        } else {
            $employeeTimeSheet->workdaytype_id = config("constants.WORKDAY_ID_USUAL");
            $employeeTimeSheet->isPaid = 1;
        }

        if ($request->has("timeSheetLock")) {
            $employeeTimeSheet->timeSheetLock = 1;
        }

        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')->format('l'));
        /** @var Employeeschedule $employeeSchedule */
        $employeeSchedule = Employeeschedule::where("user_id", $employeeTimeSheet->user_id)->where("day", $toDayJalali)->get()->first();

        $allowedLunchBreak = $employeeTimeSheet->getOriginal("allowedLunchBreakInSec");
        if (! isset($allowedLunchBreak)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal("lunchBreakInSeconds");
            }
        }

        $beginTime = $employeeTimeSheet->getOriginal("userBeginTime");
        if (! isset($beginTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userBeginTime = $employeeSchedule->getOriginal("beginTime");
            }
        }

        $finishTime = $employeeTimeSheet->getOriginal("userFinishTime");
        if (! isset($finishTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userFinishTime = $employeeSchedule->getOriginal("finishTime");
            }
        }
        $done = $employeeTimeSheet->save();
        if ($done) {
            if ($request->has("serverSide")) {
                return true;
            } else {
                session()->flash("success", "ساعت کاری با موفقیت درج شد");

                return redirect()->back();
            }
        } else {
            if ($request->has("serverSide")) {
                return false;
            } else {
                session()->flash("error", Lang::get("responseText.Database error."));

                return redirect()->back();
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Employeetimesheet $employeetimesheet
     */
    public function show(Employeetimesheet $employeetimesheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Employeetimesheet $employeetimesheet
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Employeetimesheet $employeetimesheet)
    {
        if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_EXTRA")) {
            $isExtra = true;
        } else {
            if ($employeetimesheet->workdaytype_id == config("constants.WORKDAY_ID_USUAL")) {
                $isExtra = false;
            }
        }

        return view("employeeTimeSheet.edit", compact("employeetimesheet", "isExtra"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Employeetimesheet $employeeTimeSheet
     * @return bool|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Employeetimesheet $employeeTimeSheet)
    {
        /** @var User $user */
        $user = Auth::user();
        if (! $request->has("modifier_id")) {
            $request->offsetSet("modifier_id", $user->id);
        }

        $employeeTimeSheet->fill($request->all());
        if ($request->has('isExtraDay')) {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_EXTRA');
            $employeeTimeSheet->isPaid = 0;
        } else {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_USUAL');
            $employeeTimeSheet->isPaid = 1;
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

        /** @var User $user */
        if ($user->can(config('constants.EDIT_EMPLOPYEE_WORK_SHEET'))) {
            $employeeTimeSheet->overtime_confirmation = true;
        } else {
            $employeeTimeSheet->overtime_confirmation = false;
        }

        $done = $employeeTimeSheet->update();
        if ($done) {
            if ($request->has("serverSide")) {
                return true;
            } else {
                session()->flash("success", "ساعت کاری با موفقیت اصلاح شد");

                return redirect()->back();
            }
        } else {
            if ($request->has("serverSide")) {
                return false;
            } else {
                session()->flash("error", Lang::get("responseText.Database error."));

                return redirect()->back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Employeetimesheet $employeetimesheet
     * @param Response $response
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Employeetimesheet $employeetimesheet, Response $response)
    {
        if ($employeetimesheet->delete()) {
            return $response->setStatusCode(200);
        } else {
            return $response->setStatusCode(503);
        }
    }
}
