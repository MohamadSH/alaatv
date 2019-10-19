<?php

namespace App\Http\Controllers\Web;

use App\Employeeovertimestatus;
use App\User;
use Carbon\Carbon;
use App\Workdaytype;
use App\Employeeschedule;
use App\Traits\DateTrait;
use App\Employeetimesheet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
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
        $this->middleware('ability:'.config('constants.EMPLOYEE_ROLE').','.config('constants.LIST_EMPLOPYEE_WORK_SHEET'), ['only' => 'index']);
        $this->middleware('ability:'.config('constants.EMPLOYEE_ROLE').'|,'.config('constants.INSERT_EMPLOPYEE_WORK_SHEET').'|'.config('constants.LIST_EMPLOPYEE_WORK_SHEET'), ['only' => ['create']]);
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

    public function index(Request $request)
    {
        /** @var Employeetimesheet $employeeTimeSheets */
        $employeeTimeSheets = Employeetimesheet::orderBy('date', 'Desc');
        if (Input::has('users')) {
            $usersId            = Input::get('users');
            $employeeTimeSheets->whereIn('user_id', $usersId);
        }

        if($request->user()->id == 8992)
        {// Agha majid
            $employeeTimeSheets->whereIn('user_id', [397580 , 285202 , 8992]);
        }

        if (Input::has('dateEnable')) {
            if (Input::has('sinceDate') && Input::has('tillDate')) {
                $sinceDate          = Input::get('sinceDate');
                $tillDate           = Input::get('tillDate');
                $employeeTimeSheets->whereBetween('date', [
                    explode('T', $sinceDate)[0],
                    explode('T', $tillDate)[0],
                ]);
            }
        }

        if (Input::has('workdayTypes')) {
            $workDayTypes       = Input::get('workdayTypes');
            $employeeTimeSheets->whereIn('workdaytype_id', $workDayTypes);
        }

        if (Input::has('isPaid')) {
            $isPaid = Input::get('isPaid');
            if (isset($isPaid[0])) {
                $employeeTimeSheets->where('isPaid', $isPaid);
            }
        }

        $employeeTimeSheets      = $employeeTimeSheets->get();
        $employeeWorkSheetSum    = $this->sumWorkAndShiftDiff($employeeTimeSheets);
        $employeeSumRealWorkTime = $this->sumRealWorkTime($employeeTimeSheets);
        $result                  = [
            'index'                => View::make('employeeTimeSheet.index',
                compact('employeeTimeSheets', 'employeeWorkSheetSum'))
                ->render(),
            'employeeWorkSheetSum' => $employeeWorkSheetSum,
            'employeeRealWorkTime' => $employeeSumRealWorkTime,
        ];

        return response(json_encode($result, JSON_UNESCAPED_UNICODE), Response::HTTP_OK)->header('Content-Type', 'application/json');
    }

    public function create(Request $request)
    {
        /** @var User $user */
        $user   = $request->user();
        $isExtra=false;
        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')->format('l'));
        /** @var Employeeschedule $employeeSchedule */
        $employeeSchedule = Employeeschedule::where('user_id', $user->id)
            ->where('day', $toDayJalali)
            ->get()
            ->first();

        $employeeTimeSheet = Employeetimesheet::where('date', Carbon::today('Asia/Tehran'))
            ->where('user_id', $user->id)
            ->first();

        if (isset($employeeTimeSheet) && $employeeTimeSheet->workdaytype_id == config('constants.WORKDAY_ID_EXTRA')) {
            $isExtra = true;
        }
        $employees    = User::select()
            ->role([config('constants.ROLE_EMPLOYEE')])
            ->pluck('lastName', 'id');

        $workdayTypes = Workdaytype::all()->pluck('displayName', 'id');

        if($user->hasRole('admin')){
            $employeeovertimestatus = Employeeovertimestatus::all()->pluck('display_name' , 'id');
        }else{
            $employeeovertimestatus = Employeeovertimestatus::where('name' , '<>' , 'rejected')->get()->pluck('display_name' , 'id');
        }
        return view('employeeTimeSheet.create',
            compact('employeeTimeSheet', 'employeeSchedule', 'isExtra', 'employees', 'workdayTypes' , 'employeeovertimestatus'));
    }

    public function store(InsertEmployeeTimeSheet $request)
    {
        /** @var User $user */
        $user = $request->user();
        if (!$request->has('modifier_id')) {
            $request->offsetSet('modifier_id', $user->id);
        }

        $employeeTimeSheet = new Employeetimesheet();
        $employeeTimeSheet->fill($request->all());

        if ($request->has('isExtraDay')) {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_EXTRA');
            $employeeTimeSheet->isPaid         = 0;
        }
        else {
            $employeeTimeSheet->workdaytype_id = config('constants.WORKDAY_ID_USUAL');
            $employeeTimeSheet->isPaid         = 1;
        }

        if ($request->has('timeSheetLock')) {
            $employeeTimeSheet->timeSheetLock = 1;
        }

        $toDayJalali = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')
            ->format('l'));
        /** @var Employeeschedule $employeeSchedule */
        $employeeSchedule = Employeeschedule::where('user_id', $employeeTimeSheet->user_id)
            ->where('day', $toDayJalali)
            ->get()
            ->first();

        $allowedLunchBreak = $employeeTimeSheet->getOriginal('allowedLunchBreakInSec');
        if (!isset($allowedLunchBreak)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->allowedLunchBreakInSec = $employeeSchedule->getOriginal('lunchBreakInSeconds');
            }
        }

        $beginTime = $employeeTimeSheet->getOriginal('userBeginTime');
        if (!isset($beginTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userBeginTime = $employeeSchedule->getOriginal('beginTime');
            }
        }

        $finishTime = $employeeTimeSheet->getOriginal('userFinishTime');
        if (!isset($finishTime)) {
            if (isset($employeeSchedule)) {
                $employeeTimeSheet->userFinishTime = $employeeSchedule->getOriginal('finishTime');
            }
        }
        if ($employeeTimeSheet->save()) {
            session()->flash('success', 'ساعت کاری با موفقیت درج شد');
            return redirect()->back();
        }
        else {
            session()->flash('error', Lang::get('responseText.Database error.'));
            return redirect()->back();
        }
    }

    public function edit(Request $request, Employeetimesheet $employeeTimeSheet)
    {
        if($request->user()->id == 8992)
        {// Agha majid
            if(!in_array($employeeTimeSheet->user_id, [397580 , 285202])){
                abort(403);
            }
        }

        $isExtra = false;
        if ($employeeTimeSheet->workdaytype_id == config('constants.WORKDAY_ID_EXTRA')) {
            $isExtra = true;
        }

        if($request->user()->hasRole('admin')){
            $employeeovertimestatus = Employeeovertimestatus::all()->pluck('display_name' , 'id');
        }else{
            $employeeovertimestatus = Employeeovertimestatus::where('name' , '<>' , 'rejected')->get()->pluck('display_name' , 'id');
        }


        return view('employeeTimeSheet.edit', compact('employeeTimeSheet', 'isExtra' , 'employeeovertimestatus'));
    }

    public function update(Request $request, Employeetimesheet $employeeTimeSheet)
    {
        if($request->user()->id == 8992)
        {// Agha majid
            if(!in_array($employeeTimeSheet->user_id, [397580 , 285202])){
                abort(403);
            }
        }

        $request->offsetSet('modifier_id', $request->get('modifier_id' , $request->user()->id));
        $employeeTimeSheet->fill($request->all());

        $employeeTimeSheet->workdaytype_id = ($request->has('isExtraDay'))?config('constants.WORKDAY_ID_EXTRA'):config('constants.WORKDAY_ID_USUAL');
        $employeeTimeSheet->timeSheetLock = ($request->has('timeSheetLock'))?1:0;
        $employeeTimeSheet->isPaid = ($request->has('isPaid'))?1:0;

        if ($employeeTimeSheet->update()) {
            session()->flash('success', 'ساعت کاری با موفقیت اصلاح شد');
            return redirect()->back();
        }else {
            session()->flash('error', 'خطای پایگاه داده');
            return redirect()->back();
        }
    }

    public function destroy(Employeetimesheet $employeeTimeSheet, Response $response)
    {
        if ($employeeTimeSheet->delete()) {
            return $response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Storing user's work time (for employees)
     *
     * @param Request $request
     * @param Employeetimesheet|null $employeeTimeSheet
     * @return Response
     */
    public function submitWorkTime(Request $request , Employeetimesheet $employeeTimeSheet=null)
    {
        if(isset($employeeTimeSheet) && !$request->has('action')){
            $request->offsetUnset('overtime_status_id');
            $employeeTimeSheet->fill($request->all());
            $employeeTimeSheet->workdaytype_id = ($request->has('isExtraDay'))?config('constants.WORKDAY_ID_EXTRA'):config('constants.WORKDAY_ID_USUAL');
            $employeeTimeSheet->timeSheetLock = ($request->has('timeSheetLock'))?1:0;
            $employeeTimeSheet->isPaid = ($request->has('isPaid'))?1:0;
            $employeeTimeSheet->update();
            session()->flash('success', 'ساعت کاری با موفقیت ذخیره شد');
            return redirect()->back();
        }

        if(!$request->has('action')){
            session()->flash('error', 'نوع ساعت کاری نامشخص است');
            return redirect()->back();
        }

        $done = false;
        $actionMap = [
            'action-clockIn'          => 'clockIn',
            'action-beginLunchBreak'  => 'beginLunchBreak',
            'action-finishLunchBreak' => 'finishLunchBreak',
            'action-clockOut'         => 'clockOut',
        ];

        $userId = $request->user()->id;
        $presentTime = Carbon::now('Asia/Tehran')->format('H:i:s');
        $toDayJalali      = $this->convertToJalaliDay(Carbon::today('Asia/Tehran')->format('l'));

        $employeeSchedule = Employeeschedule::where('user_id', $userId)
            ->where('day', $toDayJalali)
            ->get()
            ->first();

        $userTimeSheets = Employeetimesheet::where('date', Carbon::today('Asia/Tehran'))->where('user_id', $userId)->get();
        if ($userTimeSheets->count() == 0) {
            $employeeSheet = Employeetimesheet::create([
                $actionMap[$request->get('action' , 'action-clockIn')] => $presentTime ,
                'user_id'               => $userId,
                'date'                  => Carbon::today('Asia/Tehran')->format('Y-m-d'),
                'userBeginTime'         => optional($employeeSchedule)->getOriginal('beginTime'),
                'userFinishTime'        => optional($employeeSchedule)->getOriginal('finishTime'),
                'allowedLunchBreakInSec'=> gmdate('H:i:s', optional($employeeSchedule)->getOriginal('lunchBreakInSeconds')),
                'modifier_id'           => $userId,
                'overtime_status_id'    => config('constants.EMPLOYEE_OVERTIME_STATUS_UNCONFIRMED'),
            ]);
            if(isset($employeeSheet)) {
                $done = true;
            }
        }
        elseif ($userTimeSheets->count() == 1) {
            $done = $userTimeSheets->first()->update([
                $actionMap[
                $request->get('action' , 'action-clockIn')] => $presentTime ,
                'modifier_id'           => $userId,
            ]);
        } else {
            session()->flash('error', 'شما بیش از یک ساعت کاری برای امروز ثبت نموده اید!');
            return redirect()->back();
        }

        if ($done) {
            session()->flash('success', 'ساعت کاری با موفقیت ذخیره شد');
        }
        else {
            session()->flash('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }
}
