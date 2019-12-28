<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Sanatisharifmerge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RemoteDataCopyController extends Controller
{
    protected $connection;

    protected $response;

    public function __construct()
    {
        $this->middleware('role:admin');
        $this->connection = DB::connection('mysql_sanatisharif');
        $this->response   = new Response();
    }

    /**
     * @param SanatisharifmergeController $sanatisharifSyncController
     *
     * @return Response
     */
    public function copyLesson(SanatisharifmergeController $sanatisharifSyncController)
    {
        $lessons = $this->connection->select("SELECT * FROM `lesson`");
        foreach ($lessons as $lesson) {
            $lessonid                = $lesson->lessonid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("lessonid", $lessonid);
            $sanatisharifDataRequest->offsetSet("lessonname", $lesson->lessonname);
            $sanatisharifDataRequest->offsetSet("lessonEnable", $lesson->lessonIsEnable);
            $sanatisharifDataRequest->offsetSet("pageOldAddress", "/Sanati-Sharif-Lesson/$lessonid");
            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
        }

        return $this->response->setStatusCode(Response::HTTP_OK)
            ->setContent(["message" => "همسان سازی با موفقیت انجام شد"]);
    }

    public function copyDepartment(SanatisharifmergeController $sanatisharifSyncController)
    {
        $departments = $this->connection->select("SELECT * FROM `department`");
        foreach ($departments as $department) {
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("depid", $department->depid);
            $sanatisharifDataRequest->offsetSet("depname", $department->depname);
            $sanatisharifDataRequest->offsetSet("depyear", $department->year);
            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
        }

        return $this->response->setStatusCode(Response::HTTP_OK)
            ->setContent(["message" => "همسان سازی با موفقیت انجام شد"]);
    }

    public function copyDepartmentlesson(SanatisharifmergeController $sanatisharifSyncController)
    {
        //        $lastDeplesson = Sanatisharifmerge::groupBy('departmentlessonid')->get()->max('departmentlessonid');
        // Bug: yek video vared shode va deplesson be vaseteie an vared shode ama khode deplesson be tanhai vared nashode ast
        $lastDeplesson = Sanatisharifmerge::whereNull("videoid")
            ->whereNull("pamphletid")
            ->max('departmentlessonid');
        if (!isset($lastDeplesson)) {
            $lastDeplesson = 0;
        }
        $departmentlessons = $this->connection->select("CALL `getalldepartmentlessondetail`(" . $lastDeplesson . ")");
        //        dd($departmentlessons);
        $successCounter = 0;
        $failedCounter  = 0;
        dump("number of available deplessons : " . count($departmentlessons));
        foreach ($departmentlessons as $departmentlesson) {
            $depid                   = $departmentlesson->depid;
            $lessonid                = $departmentlesson->lessonid;
            $departmentlessonid      = $departmentlesson->departmentlessonid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("departmentlessonid", $departmentlessonid);
            $sanatisharifDataRequest->offsetSet("pic", $departmentlesson->pic);
            $sanatisharifDataRequest->offsetSet("departmentlessonEnable", $departmentlesson->isenable);
            $sanatisharifDataRequest->offsetSet("depid", $depid);
            $sanatisharifDataRequest->offsetSet("depname", $departmentlesson->depname);
            $sanatisharifDataRequest->offsetSet("depyear", $departmentlesson->year);
            $sanatisharifDataRequest->offsetSet("lessonid", $lessonid);
            $sanatisharifDataRequest->offsetSet("lessonname", $departmentlesson->lessonname);
            $sanatisharifDataRequest->offsetSet("lessonEnable", $departmentlesson->lessonEnable);
            $sanatisharifDataRequest->offsetSet("teacherfirstname", $departmentlesson->userfirstname);
            $sanatisharifDataRequest->offsetSet("teacherlastname", $departmentlesson->userlastname);
            $sanatisharifDataRequest->offsetSet("pageOldAddress", "/Sanati-Sharif-Lesson/$lessonid/$depid");

            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
            if ($response->getStatusCode() == Response::HTTP_OK) {
                $successCounter++;
            } else {
                if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                    $failedCounter++;
                    dump("departmentlesson wasn't copied. id: " . $departmentlessonid);
                }
            }
        }
        dump("number of failed videos : " . $failedCounter);
        dump("number of copied videos : " . $successCounter);

        return $this->response->setStatusCode(Response::HTTP_OK)
            ->setContent(["message" => "Data sync done successfully"]);
    }

    public function copyVideo(SanatisharifmergeController $sanatisharifSyncController)
    {
        $lastVideo = Sanatisharifmerge::groupBy('videoid')
            ->get()
            ->max('videoid');
        if (!isset($lastVideo)) {
            $lastVideo = 0;
        }
        $videos         = $this->connection->select("CALL `getallvideocompleteinfo`(" . $lastVideo . ")");
        $successCounter = 0;
        $failedCounter  = 0;
        dump("number of available videos : " . count($videos));
        foreach ($videos as $video) {
            $depid                   = $video->depid;
            $lessonid                = $video->lessonid;
            $videoid                 = $video->videoid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("videoid", $videoid);
            $sanatisharifDataRequest->offsetSet("videoname", $video->videoname);
            $sanatisharifDataRequest->offsetSet("videodescrip", $video->videodescrip);
            $sanatisharifDataRequest->offsetSet("videosession", $video->session);
            $sanatisharifDataRequest->offsetSet("videolink", $video->videolink);
            $sanatisharifDataRequest->offsetSet("videolinkhq", $video->videolinkhq);
            $sanatisharifDataRequest->offsetSet("videolink240p", $video->videolink240p);
            $sanatisharifDataRequest->offsetSet("thumbnail", $video->thumbnail);
            $sanatisharifDataRequest->offsetSet("videolinktakhtesefid", $video->videolinkonline);
            $sanatisharifDataRequest->offsetSet("videoEnable", $video->isenable);

            $sanatisharifDataRequest->offsetSet("lessonid", $lessonid);
            $sanatisharifDataRequest->offsetSet("lessonname", $video->lessonname);
            $sanatisharifDataRequest->offsetSet("lessonEnable", $video->lessonEnable);
            $sanatisharifDataRequest->offsetSet("depid", $depid);
            $sanatisharifDataRequest->offsetSet("depname", $video->depname);
            $sanatisharifDataRequest->offsetSet("depyear", $video->depyear);
            $sanatisharifDataRequest->offsetSet("departmentlessonid", $video->departmentlessonid);
            $sanatisharifDataRequest->offsetSet("departmentlessonEnable", $video->departmentlessonEnable);
            $sanatisharifDataRequest->offsetSet("teacherfirstname", $video->userfirstname);
            $sanatisharifDataRequest->offsetSet("teacherlastname", $video->userlastname);
            $sanatisharifDataRequest->offsetSet("pageOldAddress", "/Sanati-Sharif-Video/$lessonid/$depid/$videoid");

            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
            if ($response->getStatusCode() == Response::HTTP_OK) {
                $successCounter++;
            } else {
                if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                    $failedCounter++;
                    dump("video wasn't copied. id: " . $videoid);
                }
            }
        }
        dump("number of failed videos : " . $failedCounter);
        dump("number of copied videos : " . $successCounter);

        return $this->response->setStatusCode(Response::HTTP_OK)
            ->setContent(["message" => "Data sync done successfully"]);
    }

    public function copyPamphlet(SanatisharifmergeController $sanatisharifSyncController)
    {
        $lastPamphlet = Sanatisharifmerge::groupBy('pamphletid')
            ->get()
            ->max('pamphletid');
        if (!isset($lastPamphlet)) {
            $lastPamphlet = 0;
        }
        $pamphlets      = $this->connection->select("CALL `getallpamphletcompleteinfo`(" . $lastPamphlet . ")");
        $successCounter = 0;
        $failedCounter  = 0;
        dump("number of available pamphlets : " . count($pamphlets));
        foreach ($pamphlets as $pamphlet) {
            $depid                   = $pamphlet->depid;
            $lessonid                = $pamphlet->lessonid;
            $pamphletid              = $pamphlet->pamphletid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("pamphletid", $pamphletid);
            $sanatisharifDataRequest->offsetSet("pamphletname", $pamphlet->pamphletname);
            $sanatisharifDataRequest->offsetSet("pamphletdescrip", $pamphlet->pamphletdescrip);
            $sanatisharifDataRequest->offsetSet("pamphletsession", $pamphlet->session);
            $sanatisharifDataRequest->offsetSet("pamphletaddress", $pamphlet->pamphletaddress);
            $sanatisharifDataRequest->offsetSet("isexercise", $pamphlet->isexercise);

            $sanatisharifDataRequest->offsetSet("pamphletEnable", $pamphlet->isenable);
            $sanatisharifDataRequest->offsetSet("lessonid", $lessonid);
            $sanatisharifDataRequest->offsetSet("lessonname", $pamphlet->lessonname);
            $sanatisharifDataRequest->offsetSet("lessonEnable", $pamphlet->lessonEnable);
            $sanatisharifDataRequest->offsetSet("depid", $depid);
            $sanatisharifDataRequest->offsetSet("depname", $pamphlet->depname);
            $sanatisharifDataRequest->offsetSet("depyear", $pamphlet->depyear);
            $sanatisharifDataRequest->offsetSet("departmentlessonid", $pamphlet->departmentlessonid);
            $sanatisharifDataRequest->offsetSet("departmentlessonEnable", $pamphlet->departmentlessonEnable);
            $sanatisharifDataRequest->offsetSet("teacherfirstname", $pamphlet->userfirstname);
            $sanatisharifDataRequest->offsetSet("teacherlastname", $pamphlet->userlastname);
            $sanatisharifDataRequest->offsetSet("pageOldAddress",
                "/Sanati-Sharif-Pamphlet/$lessonid/$depid/$pamphletid");

            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
            if ($response->getStatusCode() == Response::HTTP_OK) {
                $successCounter++;
            } else {
                if ($response->getStatusCode() == Response::HTTP_SERVICE_UNAVAILABLE) {
                    $failedCounter++;
                    dump("pamphlet wasn't copied. id: " . $pamphletid);
                }
            }
        }
        dump("number of failed pamphlets : " . $failedCounter);
        dump("number of copied pamphlets : " . $successCounter);

        return $this->response->setStatusCode(Response::HTTP_OK)
            ->setContent(["message" => "Data sync done successfully"]);
    }
}
