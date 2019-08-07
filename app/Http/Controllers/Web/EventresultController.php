<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Eventresult;
use App\Eventresultstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertEventResultRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class EventresultController extends Controller
{
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_EVENTRESULT_ACCESS')."|".config('constants.LIST_SHARIF_REGISTER_ACCESS'),
            ['only' => 'index']);
    }

    public function index()
    {
        $eventresults = Eventresult::orderBy("rank");

        $eventIds = Input::get("event_id");
        if (isset($eventIds)) {
            $eventresults = $eventresults->whereIn("event_id", $eventIds);
        }
        else {
            $eventIds = [];
        }
        $eventresults        = $eventresults->get();
        $sharifRegisterEvent = Event::where("name", "sabtename_sharif_97")
            ->get()
            ->first();
        if (isset($sharifRegisterEvent) && in_array($sharifRegisterEvent->id, $eventIds)) {
            $isSharifRegisterEvent = true;
        }
        else {
            $isSharifRegisterEvent = false;
        }

        $eventResultStatuses = Eventresultstatus::pluck('displayName', 'id');

        return view("event.result.index",
            compact("eventresults", "eventIds", "isSharifRegisterEvent", "eventResultStatuses"));
    }

    public function store(InsertEventResultRequest $request)
    {
        $eventResult = new Eventresult();
        $eventResult->fill($request->all());

        if ($request->has("participationCode")) {
            $eventResult->participationCode = encrypt($request->get("participationCode"));
        }

        $user = $request->user();
        if ($request->has("user_id")) {
            if ($user->can(config('constants.INSET_EVENTRESULT_ACCESS'))) {
                $eventResult->user_id = $request->get("user_id");
            }
            else {
                abort(Response::HTTP_FORBIDDEN);
            }
        }
        else {
            $eventResult->user_id = $user->id;
        }

        $eventResult->enableReportPublish = $request->get("enableReportPublish", 0);

        $userUpdate = false;
        if ($request->has("major_id")) {
            $userUpdate     = true;
            $user->major_id = $request->get("major_id");
        }

        if ($request->has("firstName")) {
            $userUpdate      = true;
            $user->firstName = $request->get("firstName");
        }

        if ($request->has("lastName")) {
            $userUpdate     = true;
            $user->lastName = $request->get("lastName");
        }

        if ($request->has("participationCode")) {
            if (strlen(preg_replace('/\s+/', '', $request->get("participationCode"))) == 0) {
                $eventResult->participationCodeHash = null;
            }
            else {
                $eventResult->participationCodeHash = bcrypt($request->get("participationCode"));
            }
        }
        else {
            $eventResult->participationCodeHash = null;
        }

        if ($request->hasFile("reportFile")) {
            $file      = $request->reportFile;
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;

            //            $oldReportFile = $eventResult->reportFile;

            if (Storage::disk(config('constants.DISK14'))
                ->put($fileName, File::get($file))) {
                //                if (isset($oldReportFile)) Storage::disk(config('constants.DISK14'))->delete($oldReportFile);
                $eventResult->reportFile = $fileName;
            }
        }

        $resultStatus = Response::HTTP_SERVICE_UNAVAILABLE;
        $done = false;
        if ($eventResult->save()) {
            if ($userUpdate) {
                $user->update();
            }
            $done = true;
            $resultStatus      = Response::HTTP_OK;
            $participationCode = $eventResult->participationCode;
            $successText = 'کارنامه با موفقیت ثبت شد';
        }else{
            $errorText = \Lang::get("responseText.Database error.");
        }

        if ($done) {
            $responseContent = [
                'message'           => $successText??'',
                'participationCode' => $participationCode ??null,
            ];
        }else {
            $responseContent = [
                'error' => [
                    'message' => $errorText??'',
                    'code'    => $resultStatus??null,
                ],
            ];
        }

        if ($request->expectsJson()) {
            return response()->json($responseContent , $resultStatus);
        }
        else {
            if (isset($successText)) {
                session()->put("success", $successText);
            }
            if(isset($errorText)){
                session()->put("error", $errorText);
            }
            return redirect()->back();
        }
    }

    public function update(Request $request, Eventresult $eventResult)
    {
        $eventResult->fill($request->all());
        $updateResult = $eventResult->update();
        if ($request->expectsJson()) {
            return response()->json();
        }
        else {
            if ($updateResult) {
                session()->put("success", "تغییرات با موفقیت ثبت شد");
            }

            return redirect()->back();
        }
    }

    public function create(Request $request){
        return redirect(action('Web\UserController@show' , $request->user()).'#ثبت_رتبه' , Response::HTTP_FOUND);
    }
}
