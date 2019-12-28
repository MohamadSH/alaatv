<?php

namespace App\Http\Controllers\Web;

use App\Assignmentstatus;
use App\Consultation;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditConsultationRequest;
use App\Http\Requests\InsertConsultationRequest;
use App\Major;
use App\Question;
use App\User;
use App\Usersurveyanswer;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Lang;

class ConsultationController extends Controller
{
    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:' . config('constants.LIST_CONSULTATION_ACCESS'), ['only' => 'index']);
        $this->middleware('permission:' . config('constants.INSERT_CONSULTATION_ACCESS'), ['only' => 'create']);
        $this->middleware('permission:' . config('constants.REMOVE_CONSULTATION_ACCESS'), ['only' => 'destroy']);
        $this->middleware('permission:' . config('constants.SHOW_CONSULTATION_ACCESS'), ['only' => 'edit']);
        $this->middleware('completeInfo', ['only' => ['uploadConsultingQuestion']]);
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
                $consultation->videoPageLink = "https://" . $consultation->videoPageLink;
            }
        }

        if (strlen($request->get("textScriptLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->textScriptLink) && !preg_match("/^https:\/\//",
                    $consultation->textScriptLink)) {
                $consultation->textScriptLink = "https://" . $consultation->textScriptLink;
            }
        }

        if ($request->hasFile("thumbnail")) {
            $file      = $request->file('thumbnail');
            $extension = $file->getClientOriginalExtension();
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
            if (Storage::disk(config('constants.DISK7'))
                ->put($fileName, File::get($file))) {
                $consultation->thumbnail = $fileName;
            }
        } else {
            $consultation->thumbnail = config('constants.CONSULTATION_DEFAULT_IMAGE');
        }

        if ($consultation->save()) {
            $consultation->majors()
                ->sync($request->get('majors', []));

            return response()->json();
        } else {
            return response()->json([], Response::HTTP_SERVICE_UNAVAILABLE);
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
            $fileName  =
                basename($file->getClientOriginalName(), "." . $extension) . "_" . date("YmdHis") . '.' . $extension;
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
                $consultation->videoPageLink = "https://" . $consultation->videoPageLink;
            }
        }

        if (strlen($request->get("textScriptLink")) > 0) {
            if (!preg_match("/^http:\/\//", $consultation->textScriptLink) && !preg_match("/^https:\/\//",
                    $consultation->textScriptLink)) {
                $consultation->textScriptLink = "https://" . $consultation->textScriptLink;
            }
        }

        if ($consultation->update()) {
            session()->put("success", "اطلاعات مشاوره با موفقیت اصلاح شد");
        } else {
            session()->put("error", Lang::get("responseText.Database error."));
        }

        return redirect()->back();
    }

    public function destroy($consultation)
    {
        if ($consultation->delete()) {
            session()->put('success', 'مشاوره با موفقیت اصلاح شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }

        return redirect()->back();
    }

    /**
     * Display a page where user can upaload his consulting questions
     *
     * @return Response
     */
    public function uploadConsultingQuestion()
    {
        return view("user.uploadConsultingQuestion");
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @param Request $request
     *
     * @return Response
     * @throws FileNotFoundException
     */
    public function consultantEntekhabReshte(Request $request)
    {
        $user = User::FindOrFail($request->get('user'));
        if (Storage::disk('entekhabReshte')
            ->exists($user->id . '-' . $user->major->id . '.txt')) {
            $storedMajors     = json_decode(Storage::disk('entekhabReshte')
                ->get($user->id . '-' . $user->major->id . '.txt'));
            $parentMajorId    = $user->major->id;
            $storedMajorsInfo = Major::whereHas('parents', function ($q) use ($storedMajors, $parentMajorId) {
                $q->where('major1_id', $parentMajorId)
                    ->whereIn('majorCode', $storedMajors);
            })
                ->get();

            $selectedMajors = [];
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor    = $storedMajorInfo->parents->where('id', $parentMajorId)
                    ->first();
                $majorCode      = $storedMajor->pivot->majorCode;
                $majorName      = $storedMajorInfo->name;
                $selectedMajors = Arr::add($selectedMajors, $majorCode, $majorName);
            }
        }
        $eventId       = 1;
        $surveyId      = 1;
        $requestUrl    = action("Web\UserSurveyAnswerController@index");
        $requestUrl    .= '?event_id[]=' . $eventId . '&survey_id[]=' . $surveyId . '&user_id[]=' . $user->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request       = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response          = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $userSurveyAnswers = collect();
        foreach ($answersCollection as $answerCollection) {
            $answerArray    = $answerCollection->userAnswer->answer;
            $question       = Question::FindOrFail($answerCollection->userAnswer->question_id);
            $requestBaseUrl = $question->dataSourceUrl;
            $requestUrl     = url('/') . $requestBaseUrl . "?ids=$answerArray";
            $originalInput  = \Illuminate\Support\Facades\Request::input();
            $request        = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $userSurveyAnswers->push([
                'questionStatement' => $question->statement,
                'questionAnswer'    => $dataJson,
            ]);
        }

        //        Meta::set('title', substr("آلاء|پنل انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view('admin.consultant.consultantEntekhabReshte',
            compact('user', 'storedMajors', 'selectedMajors', 'userSurveyAnswers'));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return Response
     */
    public function consultantEntekhabReshteList()
    {
        $eventId           = 1;
        $surveyId          = 1;
        $usersurveyanswers = Usersurveyanswer::where('event_id', $eventId)
            ->where('survey_id', $surveyId)
            ->get()
            ->groupBy('user_id');

        //        Meta::set('title', substr("آلاء|لیست انتخاب رشته", 0, config("constants.META_TITLE_LIMIT")));
        //        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view('admin.consultant.consultantEntekhabReshteList', compact('usersurveyanswers'));
    }

    /**
     * Storing consultant entekhab reshte
     *
     * @return Response
     */
    public function consultantStoreEntekhabReshte(Request $request)
    {
        $userId      = $request->get('user');
        $user        = User::FindOrFail($userId);
        $parentMajor = $request->get('parentMajor');
        $majorCodes  = json_encode($request->get('majorCodes'), JSON_UNESCAPED_UNICODE);

        Storage::disk('entekhabReshte')
            ->delete($userId . '-' . $parentMajor . '.txt');
        Storage::disk('entekhabReshte')
            ->put($userId . '-' . $parentMajor . '.txt', $majorCodes);
        session()->put('success', 'رشته های انتخاب شده با موفقیت درج شدند');

        return redirect(action("Web\HomeController@consultantEntekhabReshte", ['user' => $user]));
    }

}
