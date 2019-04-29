<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Eventresult;
use App\Eventresultstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertEventResultRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;

class EventresultController extends Controller
{
    protected $response;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.Config::get('constants.LIST_EVENTRESULT_ACCESS')."|".Config::get('constants.LIST_SHARIF_REGISTER_ACCESS'),
            ['only' => 'index']);
        
        $this->response = new Response();
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
                abort(403);
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
            
            if (Storage::disk(Config::get('constants.DISK14'))
                ->put($fileName, File::get($file))) {
                //                if (isset($oldReportFile)) Storage::disk(Config::get('constants.DISK14'))->delete($oldReportFile);
                $eventResult->reportFile = $fileName;
            }
        }
        
        if ($eventResult->save()) {
            if ($userUpdate) {
                $user->update();
            }
            if ($request->expectsJson()) {
                $participationCode = $eventResult->participationCode;
                $resultStatus      = Response::HTTP_OK;
            }
            else {
                session()->put("success", "کارنامه با موفقیت درج شد");
            }
        }
        else {
            if ($request->expectsJson()) {
                $message      = "Database error";
                $resultStatus = Response::HTTP_SERVICE_UNAVAILABLE;
            }
            else {
                session()->put("error", \Lang::get("responseText.Database error."));
            }
        }
        if ($request->expectsJson()) {
            if ($resultStatus == Response::HTTP_OK) {
                $responseContent = [
                    'message'           => 'Result inserted successfully',
                    'participationCode' => $participationCode ?? $participationCode,
                ];
            }
            else {
                $responseContent = [
                    'error' => [
                        'message' => $message,
                        'code'    => $resultStatus,
                    ],
                ];
            }
            
            return response($responseContent, Response::HTTP_OK);
        }
        else {
            return redirect()->back();
        }
    }

    public function update(Request $request, Eventresult $eventResult)
    {
        $eventResult->fill($request->all());
        $updateResult = $eventResult->update();
        if ($request->expectsJson()) {
            return $this->response->setStatusCode(200);
        }
        else {
            if ($updateResult) {
                session()->put("success", "تغییرات با موفقیت ثبت شد");
            }
            
            return redirect()->back();
        }
    }
}
