<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Usersurveyanswer;
use Auth;
use Illuminate\Http\Request;


class UserSurveyAnswerController extends Controller
{
    public function index(Request $request)
    {
        $eventIds    = $request->get("event_id");
        $surveyIds   = $request->get("survey_id");
        $questionIds = $request->get("question_id");
        if ($request->has("user_id")) {
            $userIds = $request->get("user_id");
        } else {
            $userIds = [Auth::user()->id];
        }
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

    public function store(Request $request)
    {
        $eventId    = $request->get("event_id");
        $surveyId   = $request->get("survey_id");
        $questionId = $request->get("question_id");
        if ($request->has("user_id")) {
            $userId = $request->get("user_id");
        } else {
            $userId = Auth::user()->id;
        }

        $userSurveyAnswer = Usersurveyanswer::where("user_id", $userId)
            ->where("event_id", $eventId)
            ->where("question_id", $questionId)
            ->where("survey_id",
                $surveyId)
            ->get()
            ->first();
        if (!isset($userSurveyAnswer)) {
            $userSurveyAnswer = new Usersurveyanswer();
            $userSurveyAnswer->fill($request->all());
            $userSurveyAnswer->user_id = $userId;
            $userSurveyAnswer->answer  = json_encode($request->get("answer"), JSON_UNESCAPED_UNICODE);
            $userSurveyAnswer->save();
        } else {
            $userSurveyAnswer->answer = json_encode($request->get("answer"), JSON_UNESCAPED_UNICODE);
            $userSurveyAnswer->update();
        }
    }
}
