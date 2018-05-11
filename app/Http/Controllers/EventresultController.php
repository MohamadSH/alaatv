<?php

namespace App\Http\Controllers;

use App\Event;
use App\Eventresult;
use App\Http\Requests\InsertEventResultRequest;
use Illuminate\Http\Request;
use Auth ;
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
        $this->middleware('permission:'.Config::get('constants.LIST_EVENTRESULT_ACCESS')."|".Config::get('constants.LIST_SHARIF_REGISTER_ACCESS'),['only'=>'index']);

        $this->response = new Response();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventresults = Eventresult::orderBy("rank");

        $eventIds = Input::get("event_id");
        if(isset($eventIds))
        {
            $eventresults = $eventresults->whereIn("event_id" , $eventIds) ;
        }
        else
        {
            $eventIds = [];
        }
        $eventresults = $eventresults->get();
        $sharifRegisterEvent = Event::where("name" , "sabtename_sharif_97")->get()->first();
        if(isset($sharifRegisterEvent) && in_array($sharifRegisterEvent->id , $eventIds))
            $isSharifRegisterEvent = true;
        else
            $isSharifRegisterEvent = false;

        return view("event.result.index" , compact("eventresults" , "eventIds" , "isSharifRegisterEvent"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertEventResultRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertEventResultRequest $request)
    {

        $eventResult  = new Eventresult();
        $eventResult->fill($request->all());

        if($request->has("participationCode"))
        {
            $eventResult->participationCode = encrypt($request->get("participationCode")) ;
        }

        if($request->has("user_id"))
        {
            $eventResult->user_id = $request->get("user_id");
        }
        elseif(Auth::check())
        {
            $user = Auth::user();
            $eventResult->user_id = $user->id ;
        }

        if($request->has("enableReportPublish")) $eventResult->enableReportPublish = 1 ;
        else $eventResult->enableReportPublish = 0;

        $userUpdate = false ;
        if($request->has("major_id"))
        {
            $userUpdate = true ;
            $user->major_id = $request->get("major_id");
        }

        if($request->has("firstName"))
        {
            $userUpdate = true ;
            $user->firstName = $request->get("firstName");
        }

        if($request->has("lastName"))
        {
            $userUpdate = true ;
            $user->lastName = $request->get("lastName");
        }

//        if($request->has("participationCode"))
//        {
//            if(strlen(preg_replace('/\s+/', '', $request->get("participationCode"))) == 0)
//                $eventResult->participationCodeHash = null;
//            else
//                $eventResult->participationCodeHash = bcrypt($request->get("participationCode")) ;
//        }else{
//            $eventResult->participationCodeHash = null;
//        }

        if ($request->hasFile("reportFile")) {
            $file = $request->reportFile;
            $extension = $file->getClientOriginalExtension();
            $fileName = basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;

//            $oldReportFile = $eventResult->reportFile;

            if (Storage::disk(Config::get('constants.DISK14'))->put($fileName, File::get($file))) {
//                if (isset($oldReportFile)) Storage::disk(Config::get('constants.DISK14'))->delete($oldReportFile);
                $eventResult->reportFile = $fileName;
            }
        }

        if ($eventResult->save()) {
            if($userUpdate ) $user->update();
            if($request->has("fromAPI"))
            {
                $participationCode = $eventResult->participationCode;
                $message = "نتیجه با موفقیت درج شد";
                $status = 200;
            }
            else
            {
                session()->put("success", "کارنامه با موفقیت درج شد");
            }
        } else {
            if($request->has("fromAPI"))
            {
                $message = "خطا در درج نتیجه";
                $status = 503;
            }
            else
            {
                session()->put("error", "خطای پایگاه داده");
            }
        }
        if($request->has("fromAPI"))
            return $this->response->setStatusCode($status)->setContent(["message"=>$message , "participationCode"=>(isset($participationCode)?$participationCode:null)]);
        else
            return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
