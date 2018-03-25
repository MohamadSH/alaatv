<?php

namespace App\Http\Controllers;

use App\Sanatisharifmerge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;

class RemoteDataCopyController extends Controller
{
    protected $connection;
    protected $response;
    public function __construct()
    {
        $this->connection =  DB::connection('mysql_remote_sanatisharif');
        $this->response = new Response();
    }

    /**
     * @param SanatisharifmergeController $sanatisharifSyncController
     * @return $this
     */
    public function copyLesson(SanatisharifmergeController $sanatisharifSyncController)
    {
        $lessons = $this->connection->select("SELECT * FROM `lesson`");
        dd($lessons);
        foreach ($lessons as $lesson)
        {
            $lessonid = $lesson->lessonid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("lessonid" , $lessonid);
            $sanatisharifDataRequest->offsetSet("lessonname" , $lesson->lessonname);
            $sanatisharifDataRequest->offsetSet("lessonEnable" , $lesson->lessonIsEnable);
            $sanatisharifDataRequest->offsetSet("pageOldAddress" , "/Sanati-Sharif-Lesson/$lessonid");
            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
        }
        return $this->response->setStatusCode(200)->setContent(["message"=>"همسان سازی با موفقیت انجام شد"]);
    }

    public function copyDepartment(SanatisharifmergeController $sanatisharifSyncController)
    {
        $departments = $this->connection->select("SELECT * FROM `department`");
        dd($departments);
        foreach ($departments as $department)
        {
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("depid" , $department->depid);
            $sanatisharifDataRequest->offsetSet("depname" , $department->depname);
            $sanatisharifDataRequest->offsetSet("depyear" , $department->year);
            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
        }
        return $this->response->setStatusCode(200)->setContent(["message"=>"همسان سازی با موفقیت انجام شد"]);
    }

    public function copyDepartmentlesson(SanatisharifmergeController $sanatisharifSyncController)
    {
//        $lastDeplesson = Sanatisharifmerge::groupBy('departmentlessonid')->get()->max('departmentlessonid');
        // Bug: yek video vared shode va deplesson be vaseteie an vared shode ama khode deplesson be tanhai vared nashode ast
        $lastDeplesson = Sanatisharifmerge::whereNull("videoid")->whereNull("pamphletid")->max('departmentlessonid');
        if(!isset($lastDeplesson)) $lastDeplesson = 0;
        $departmentlessons = $this->connection->select("CALL `getalldepartmentlessondetail`(".$lastDeplesson.")");
//        dd($departmentlessons);
        foreach ($departmentlessons as $departmentlesson)
        {
            $depid = $departmentlesson->depid;
            $lessonid = $departmentlesson->lessonid;
            $departmentlessonid = $departmentlesson->departmentlessonid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("departmentlessonid" , $departmentlessonid );
            $sanatisharifDataRequest->offsetSet("departmentlessonEnable" , $departmentlesson->isenable );
            $sanatisharifDataRequest->offsetSet("depid" , $depid );
            $sanatisharifDataRequest->offsetSet("depname" , $departmentlesson->depname );
            $sanatisharifDataRequest->offsetSet("depyear" , $departmentlesson->year );
            $sanatisharifDataRequest->offsetSet("lessonid" , $lessonid );
            $sanatisharifDataRequest->offsetSet("lessonname" , $departmentlesson->lessonname );
            $sanatisharifDataRequest->offsetSet("lessonEnable" , $departmentlesson->lessonEnable );
            $sanatisharifDataRequest->offsetSet("teacherfirstname" , $departmentlesson->userfirstname );
            $sanatisharifDataRequest->offsetSet("teacherlastname" , $departmentlesson->userlastname );
            $sanatisharifDataRequest->offsetSet("pageOldAddress" , "/Sanati-Sharif-Lesson/$lessonid/$depid");

            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
            if($response->getStatusCode() == 200)
            {

            }elseif($response->getStatusCode() == 503){
                dump("departmentlesson wasn't copied. id: ".$departmentlessonid);
            }
        }
        return $this->response->setStatusCode(200)->setContent(["message"=>"همسان سازی با موفقیت انجام شد"]);
    }

    public function copyVideo(SanatisharifmergeController $sanatisharifSyncController)
    {
        $lastVideo = Sanatisharifmerge::groupBy('videoid')->get()->max('videoid');
        if(!isset($lastVideo)) $lastVideo = 0;
        $videos = $this->connection->select("CALL `getallvideocompleteinfo`(".$lastVideo.")");
        foreach ($videos as $video)
        {
            $depid = $video->depid;
            $lessonid =  $video->lessonid;
            $videoid = $video->videoid;
            $sanatisharifDataRequest = new Request();
            $sanatisharifDataRequest->offsetSet("videoid" , $videoid );
            $sanatisharifDataRequest->offsetSet("videoname" , $video->videoname );
            $sanatisharifDataRequest->offsetSet("videodescrip" , $video->videodescrip );
            $sanatisharifDataRequest->offsetSet("videosession" , $video->session );
//            $sanatisharifDataRequest->offsetSet("keywords" ,  );
            $sanatisharifDataRequest->offsetSet("videolink" , $video->videolink );
            $sanatisharifDataRequest->offsetSet("videolinkhq" , $video->videolinkhq );
            $sanatisharifDataRequest->offsetSet("videolink240p" , $video->videolink240p );
            $sanatisharifDataRequest->offsetSet("videoEnable" , $video->isenable );
            $sanatisharifDataRequest->offsetSet("thumbnail" , $video->thumbnail );
            $sanatisharifDataRequest->offsetSet("lessonid" ,$lessonid );
            $sanatisharifDataRequest->offsetSet("lessonname" , $video->lessonname );
            $sanatisharifDataRequest->offsetSet("lessonEnable" , $video->lessonEnable );
            $sanatisharifDataRequest->offsetSet("depid" , $depid );
            $sanatisharifDataRequest->offsetSet("depname" , $video->depname );
            $sanatisharifDataRequest->offsetSet("depyear" , $video->depyear );
            $sanatisharifDataRequest->offsetSet("departmentlessonid" , $video->departmentlessonid );
            $sanatisharifDataRequest->offsetSet("departmentlessonEnable" , $video->departmentlessonEnable );
            $sanatisharifDataRequest->offsetSet("teacherfirstname" , $video->userfirstname );
            $sanatisharifDataRequest->offsetSet("teacherlastname" , $video->userlastname );
            $sanatisharifDataRequest->offsetSet("pageOldAddress" , "/Sanati-Sharif-Video/$lessonid/$depid/$videoid");

            $response = $sanatisharifSyncController->store($sanatisharifDataRequest);
            if($response->getStatusCode() == 200)
            {

            }elseif($response->getStatusCode() == 503){
                dump("video wasn't copied. id: ".$videoid);
            }
        }

        return $this->response->setStatusCode(200)->setContent(["message"=>"همسان سازی با موفقیت انجام شد"]);
    }

    public function copyPamphlet()
    {

    }



}
