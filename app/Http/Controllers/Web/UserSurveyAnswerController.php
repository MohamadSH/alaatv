<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Usersurveyanswer;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class UserSurveyAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $eventIds = Input::get("event_id");
        $surveyIds = Input::get("survey_id");
        $questionIds = Input::get("question_id");
        if (Input::has("user_id"))
            $userIds = Input::get("user_id");
        else $userIds = [Auth::user()->id];
        $userAnswers = Usersurveyanswer::OrderBy("created_at");
        if (isset($eventIds)) {
            $userAnswers = $userAnswers->whereIn("event_id", $eventIds);
        }

        if (isset($surveyIds)) {
            $userAnswers = $userAnswers->whereIn("survey_id", $surveyIds);
        }

        if (isset($questionIds)) {
            $userAnswers = $userAnswers->whereIn("question_id", $questionIds);
        }

        if (isset($userIds)) {
            $userAnswers = $userAnswers->whereIn("user_id", $userIds);
        }

        $output = collect();
        foreach ($userAnswers->get() as $userAnswer) {
            $output->push([
                              "questionQuerySourceUrl" => $userAnswer->question->dataSourceUrl,
                              "userAnswer"             => $userAnswer,
                          ]);
        }

        return $output;
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
     * @param  \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $eventId = $request->get("event_id");
        $surveyId = $request->get("survey_id");
        $questionId = $request->get("question_id");
        if ($request->has("user_id"))
            $userId = $request->get("user_id");
        else $userId = Auth::user()->id;

        $userSurveyAnswer = Usersurveyanswer::where("user_id", $userId)
                                            ->where("event_id", $eventId)
                                            ->where("question_id", $questionId)
                                            ->where("survey_id", $surveyId)
                                            ->get()
                                            ->first();
        if (!isset($userSurveyAnswer)) {
            $userSurveyAnswer = new Usersurveyanswer();
            $userSurveyAnswer->fill($request->all());
            $userSurveyAnswer->user_id = $userId;
            $userSurveyAnswer->answer = json_encode($request->get("answer"), JSON_UNESCAPED_UNICODE);
            $userSurveyAnswer->save();
        } else {
            $userSurveyAnswer->answer = json_encode($request->get("answer"), JSON_UNESCAPED_UNICODE);
            $userSurveyAnswer->update();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
