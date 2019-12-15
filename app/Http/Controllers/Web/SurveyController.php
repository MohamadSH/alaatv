<?php

namespace App\Http\Controllers\Web;

use App\Event;
use App\Province;
use App\Survey;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Route;

class SurveyController extends Controller
{
    /**
     * Showing a survey to user to take part in
     *
     * @return Response
     */
    public function show()
    {
        // return redirect(action("Web\ErrorPageController@error404"));
        $event   = Event::FindOrFail(1);
        $survey = $event->surveys->first();
        $questionsData = collect();
        $answersData   = collect();
        $questions     = (isset($survey))?$survey->questions->sortBy("pivot.order"):collect();
        $this->getQuestionsAndAnswerData($questions, $event, $survey, $answersData, $questionsData);
        $pageName = "showSurvey";

        return view("survey.show", compact("event" , 'survey', "questions", "questionsData", "answersData", "pageName"));
    }

    /**
     * @param                                  $questions
     * @param                                  $event
     * @param  Survey                     $survey
     * @param  Collection                      $answersData
     * @param  Collection                      $questionsData
     */
    private function getQuestionsAndAnswerData($questions, $event, Survey $survey, Collection &$answersData, Collection &$questionsData): void
    {
        foreach ($questions as $question) {
            $requestBaseUrl = $question->dataSourceUrl;
            /**
             * Getting raw answer
             */
            $this->getRawAnswer($event, $survey, $answersData, $question, $requestBaseUrl);
            /**
             *  Making questions
             */
            $this->makeQuestions($questionsData, $question, $requestBaseUrl);
        }
    }

    /**
     * @param                                  $event
     * @param  Survey                     $survey
     * @param  Collection                      $answersData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getRawAnswer($event, Survey $survey, Collection &$answersData, $question, $requestBaseUrl): void
    {
        $requestUrl    = action("Web\UserSurveyAnswerController@index");
        $requestUrl    .= "?event_id[]=".$event->id."&survey_id[]=".$survey->id."&question_id[]=".$question->id;
        $originalInput = Request::input();
        $request       = Request::create($requestUrl, 'GET');
        Request::replace($request->input());
        $response          = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        Request::replace($originalInput);
        $questionAnswerArray = [];
        foreach ($answersCollection as $answerCollection) {
            /** Making answers */
            $answerArray   = $answerCollection->userAnswer->answer;
            $requestUrl    = url("/").$requestBaseUrl."?ids=$answerArray";
            $originalInput = Request::input();
            $request       = Request::create($requestUrl, 'GET');
            Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            Request::replace($originalInput);
            foreach ($dataJson as $data) {
                $questionAnswerArray = Arr::add($questionAnswerArray, $data->id, $data->name);
            }
        }
        $answersData->put($question->id, $questionAnswerArray);
    }

    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function makeQuestions(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        if (strpos($question->dataSourceUrl, "major") !== false) {
            $this->getQusetionDataInMajorStatus($questionsData, $question, $requestBaseUrl);
        }
        elseif (strpos($question->dataSourceUrl, "city") !== false) {
            $this->getQuestionDataInCityStatus($questionsData, $question, $requestBaseUrl);
        }
    }

    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getQusetionDataInMajorStatus(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        $userMajor  = Auth()->user()->major;
        $userMajors = $this->getUserMajors($userMajor);
        $requestUrl = url("/").$requestBaseUrl."?";
        foreach ($userMajors as $major) {
            $requestUrl .= "&parents[]=$major";
        }
        $originalInput = Request::input();
        $request       = Request::create($requestUrl, 'GET');
        Request::replace($request->input());
        $response = Route::dispatch($request);
        $dataJson = json_decode($response->content());
        Request::replace($originalInput);
        $rootMajorArray = [];
        $majorsArray    = [];
        foreach ($dataJson as $item) {
            $majorsArray = Arr::add($majorsArray, $item->id, $item->name);
        }
        $rootMajorArray = Arr::add($rootMajorArray, $userMajor->name, $majorsArray);
        $questionsData->put($question->id, $rootMajorArray);
    }

    /**
     * @param $userMajor
     *
     * @return array|Collection
     */
    private function getUserMajors($userMajor)
    {
        $userMajors = collect();
        $userMajors->push($userMajor);
        foreach ($userMajors as $major) {
            $accessibleMajors = $major->accessibles;
            foreach ($accessibleMajors as $accessibleMajor) {
                $userMajors->push($accessibleMajor);
            }
        }
        $userMajors = $userMajors->pluck('id')
            ->toArray();

        return $userMajors;
    }

    /**
     * @param  Collection                      $questionsData
     * @param                                  $question
     * @param                                  $requestBaseUrl
     */
    private function getQuestionDataInCityStatus(Collection &$questionsData, $question, $requestBaseUrl): void
    {
        $provinces         = Province::orderBy("name")
            ->get();
        $provinceCityArray = [];
        foreach ($provinces as $province) {
            $requestUrl    = url("/").$requestBaseUrl."?provinces[]=$province->id";
            $originalInput = Request::input();
            $request       = Request::create($requestUrl, 'GET');
            Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            Request::replace($originalInput);
            $citiesArray = [];
            foreach ($dataJson as $item) {
                $citiesArray = Arr::add($citiesArray, $item->id, $item->name);
            }
            $provinceCityArray = Arr::add($provinceCityArray, $province->name, $citiesArray);
            $questionsData->put($question->id, $provinceCityArray);
        }
    }

}
