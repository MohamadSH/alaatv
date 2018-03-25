<?php

namespace App\Http\Controllers;

use App\Consultationstatus;
use App\Http\Requests\InsertUserUploadRequest;
use App\Http\Requests\SendSMSRequest;
use App\Userupload;
use App\Useruploadstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class UseruploadController extends Controller
{
    protected $response ;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.Config::get('constants.LIST_QUESTION_ACCESS'),['only'=>'index']);
        $this->middleware('permission:'.Config::get('constants.SHOW_QUESTION_ACCESS'),['only'=>'show']);

        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Userupload::all()->sortByDesc("created_at");
        $questionStatuses  = Useruploadstatus::pluck('displayName', 'id');

        $counter = 1;
        return view("userUpload.index" , compact("questions" , "counter" , "questionStatuses"));
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
     * @param  \app\Http\Requests\InsertUserUploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertUserUploadRequest $request)
    {
        $userUpload = new Userupload();
        $userUpload->fill($request->all());

        $userUpload->user_id = Auth::user()->id;
        $userUpload_pending = Useruploadstatus::all()->where("name" , "pending")->first();
        $userUpload->useruploadstatus_id = $userUpload_pending->id;
        if ($request->hasFile("consultingAudioQuestions")) {
            $file = $request->file('consultingAudioQuestions');
            $extension = $file->getClientOriginalExtension();
            $fileName = date("YmdHis") . '.' . $extension;
            if (Storage::disk(Config::get('constants.DISK6'))->put($fileName, File::get($file))) {
                $userUpload->file = $fileName;
            }
            if ($userUpload->save()) {
                session()->flash('success', 'درج سوال مشاوره ای با موفقیت انجام شد');
            }
            else{
                session()->flash('error', 'خطای پایگاه داده');
            }
        }else  session()->flash('error', 'فایلی فرستاده نشده است');


        return response([
            'sessionData' => session()->all()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \app\Userupload $userUpload
     * @return \Illuminate\Http\Response
     */
    public function show(Userupload $userUpload)
    {
        $user = $userUpload->user;
        $counter = 0;
        $consultationStatuses = Consultationstatus::pluck('name', 'id');
        return view("userUpload.show" , compact("user" , "counter" , "consultationStatuses"));
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
     * @param  \app\Userupload $userupload
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Userupload $userupload)
    {
        $oldUserUploadStatus = $userupload->useruploadstatus_id;
        $userupload->fill($request->all());
        if ($userupload->update()) {
            if($oldUserUploadStatus != $userupload->useruploadstatus_id)
            {
                $controller = new HomeController();
                $smsRequest = new SendSMSRequest();
                $fullName = "";
                if(strlen($userupload->user->firstName)>0) $fullName .= $userupload->user->firstName;
                if(strlen($userupload->user->lastName)>0) $fullName .= " ".$userupload->user->lastName;
                $userUploadStatusName = Useruploadstatus::where('id', $userupload->useruploadstatus_id)->pluck('displayName')->toArray();
                if(strlen($fullName)>0) $smsRequest["message"] = $fullName." عزیز وضعیت سوال مشاوره ای شما به حالت ".$userUploadStatusName[0]." تغییر کرد-تخته خاک";
                else $smsRequest["message"] = " کاربر گرامی وضعیت سوال مشاوره ای شما به حالت ".$userUploadStatusName[0]." تغییر کرد-تخته خاک";
                $smsRequest["users"] = $userupload->user_id;
                $smsstatus =  $controller->sendSMS($smsRequest);
                return $this->response->setStatusCode(200)->setContent($smsstatus->getStatusCode());
            }
            else
                return $this->response->setStatusCode(200);
        }
        else{
            return $this->response->setStatusCode(503);
        }
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
