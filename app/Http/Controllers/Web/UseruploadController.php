<?php

namespace App\Http\Controllers\Web;

use App\Consultationstatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\InsertUserUploadRequest;
use App\Notifications\CounselingStatusChanged;
use App\Userupload;
use App\Useruploadstatus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UseruploadController extends Controller
{
    protected $response;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_QUESTION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.SHOW_QUESTION_ACCESS'), ['only' => 'show']);
        
        $this->response = new Response();
    }

    public function index()
    {
        $questions        = Userupload::all()
            ->sortByDesc("created_at");
        $questionStatuses = Useruploadstatus::pluck('displayName', 'id');
        
        $counter = 1;
        
        return view("userUpload.index", compact("questions", "counter", "questionStatuses"));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \app\Http\Requests\InsertUserUploadRequest  $request
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(InsertUserUploadRequest $request)
    {
        $userUpload = new Userupload();
        $userUpload->fill($request->all());
        
        $userUpload->user_id             = Auth::user()->id;
        $userUpload_pending              = Useruploadstatus::all()
            ->where("name", "pending")
            ->first();
        $userUpload->useruploadstatus_id = $userUpload_pending->id;
        if ($request->hasFile("consultingAudioQuestions")) {
            $file      = $request->file('consultingAudioQuestions');
            $extension = $file->getClientOriginalExtension();
            $fileName  = date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK6'))
                ->put($fileName, File::get($file))) {
                $userUpload->file = $fileName;
            }
            if ($userUpload->save()) {
                session()->flash('success', 'درج سوال مشاوره ای با موفقیت انجام شد');
            }
            else {
                session()->flash('error', 'خطای پایگاه داده');
            }
        }
        else {
            session()->flash('error', 'فایلی فرستاده نشده است');
        }
        
        return response([
            'sessionData' => session()->all(),
        ]);
    }

    public function show(Userupload $userUpload)
    {
        $user                 = $userUpload->user;
        $counter              = 0;
        $consultationStatuses = Consultationstatus::pluck('name', 'id');
        
        return view("userUpload.show", compact("user", "counter", "consultationStatuses"));
    }

    public function update(Request $request, Userupload $userupload)
    {
        $oldUserUploadStatus = $userupload->useruploadstatus_id;
        $userupload->fill($request->all());
        
        if (!$userupload->update()) {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
        
        if ($oldUserUploadStatus != $userupload->useruploadstatus_id) {
            $userUploadStatusName = Useruploadstatus::where('id', $userupload->useruploadstatus_id)
                ->pluck('displayName')
                ->toArray();
            $userupload->user->notify(new CounselingStatusChanged($userUploadStatusName[0]));
        }
        
        return $this->response->setStatusCode(Response::HTTP_OK);
        
    }
}
