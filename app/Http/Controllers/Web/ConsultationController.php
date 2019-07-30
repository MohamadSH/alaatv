<?php

namespace App\Http\Controllers\Web;

use App\Assignmentstatus;
use App\Consultation;
use App\Http\Controllers\Controller;
use App\Http\Requests\ConsultationRequest;
use App\Http\Requests\EditConsultationRequest;
use App\Http\Requests\InsertConsultationRequest;
use App\Major;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ConsultationController extends Controller
{
    protected $response;
    
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_CONSULTATION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:'.config('constants.INSERT_CONSULTATION_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:'.config('constants.REMOVE_CONSULTATION_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:'.config('constants.SHOW_CONSULTATION_ACCESS'), ['only' => 'edit']);
        
        $this->response = new Response();
    }

    public function index()
    {
        $consultations = Consultation::all()
            ->sortByDesc('created_at');
        $pageName      = "admin";
        
        return view("consultation.index", compact("consultations", "pageName"));
    }

    public function create()
    {
        return view("consultation.create");
    }

    public function store(InsertConsultationRequest $request)
    {
        $consultation = new Consultation();
        $consultation->fill($request->all());
        
        if (strlen($request->get("videoPageLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->videoPageLink) && !preg_match("/^https:\/\//",
                    $consultation->videoPageLink)) {
                $consultation->videoPageLink = "https://".$consultation->videoPageLink;
            }
        }
        
        if (strlen($request->get("textScriptLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->textScriptLink) && !preg_match("/^https:\/\//",
                    $consultation->textScriptLink)) {
                $consultation->textScriptLink = "https://".$consultation->textScriptLink;
            }
        }
        
        if ($request->hasFile("thumbnail")) {
            $file      = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK7'))
                ->put($fileName, File::get($file))) {
                $consultation->thumbnail = $fileName;
            }
        }
        else {
            $consultation->thumbnail = config('constants.CONSULTATION_DEFAULT_IMAGE');
        }
        
        if ($consultation->save()) {
            $consultation->majors()
                ->sync($request->get('majors', []));
            
            return $this->response->setStatusCode(Response::HTTP_OK);
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    public function show($consultation)
    {
        return redirect(action('Web\ConsultationController@edit', $consultation));
    }

    public function edit($consultation)
    {
        $majors               = Major::pluck('name', 'id')
            ->toArray();
        $consultationMajors   = $consultation->majors->pluck('id')
            ->toArray();
        $consultationStatuses = Assignmentstatus::pluck('name', 'id');
        
        return view("consultation.edit",
            compact("consultation", "majors", "consultationStatuses", "consultationMajors"));
    }

    public function update(EditConsultationRequest $request, $consultation)
    {
        $thumbnail = $consultation->thumbnail;
        $consultation->fill($request->all());
        
        if ($request->hasFile("thumbnail")) {
            $file      = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $fileName  = basename($file->getClientOriginalName(), ".".$extension)."_".date("YmdHis").'.'.$extension;
            if (Storage::disk(config('constants.DISK7'))
                ->put($fileName, File::get($file))) {
                Storage::disk(config('constants.DISK7'))
                    ->delete($thumbnail);
                $consultation->thumbnail = $fileName;
            }
        }
        
        if (strlen($request->get("videoPageLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->videoPageLink) && !preg_match("/^https:\/\//",
                    $consultation->videoPageLink)) {
                $consultation->videoPageLink = "https://".$consultation->videoPageLink;
            }
        }
        
        if (strlen($request->get("textScriptLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->textScriptLink) && !preg_match("/^https:\/\//",
                    $consultation->textScriptLink)) {
                $consultation->textScriptLink = "https://".$consultation->textScriptLink;
            }
        }
        
        if ($consultation->update()) {
            session()->put("success", "اطلاعات مشاوره با موفقیت اصلاح شد");
        }
        else {
            session()->put("error", \Lang::get("responseText.Database error."));
        }
        
        return redirect()->back();
    }

    public function destroy($consultation)
    {
        if ($consultation->delete()) {
            session()->put('success', 'مشاوره با موفقیت اصلاح شد');
        }
        else {
            session()->put('error', 'خطای پایگاه داده');
        }
        
        return redirect()->back();
    }
}
