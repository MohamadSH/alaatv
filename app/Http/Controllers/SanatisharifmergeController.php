<?php

namespace App\Http\Controllers;

use App\Contentset;
use App\Sanatisharifmerge;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SanatisharifmergeController extends Controller
{
    protected $response;
    public function __construct()
    {
        $this->response = new Response();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $sanatisharifRecord = new Sanatisharifmerge();
        $sanatisharifRecord->fill($request->all());
        if($sanatisharifRecord->save())
        {
            return $this->response->setStatusCode(200);
        }
        else
        {
            return $this->response->setStatusCode(503);
        }
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
     * @param  \App\Sanatisharifmerge  $sanatisharifmerge
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $sanatisharifmerge)
    {
        $sanatisharifmerge->fill($request->all());
        if($sanatisharifmerge->update())
        {
            return $this->response->setStatusCode(200);
        }else
        {
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

    /**
     *    METHODS FOR COPYING DATA IN TO TAKHTEKHAK TABLES
     */

    public function copyDepartmentlesson()
    {
        $sanatisharifRecords = Sanatisharifmerge::whereNull("videoid")->whereNull("pamphletid")->whereNotNull("departmentlessonid")->where("departmentlessonTransferred" , 0)->get();
//        $sanatisharifRecords = Sanatisharifmerge::groupBy('departmentlessonid')->where("departmentlessonTransferred" , 0);
        //Bug: farze kon ye deplesson ham khodesh vared shode ham video barayash vared shode. man chon bar asase sotoone departmentlessonTransferred filter mikonam
        // var recordi ke deplessonid va videoid darad dataye departmentlessonTransferred sefr ast kare filtere man ra kharab mikonad
        foreach ($sanatisharifRecords as $sanatisharifRecord)
        {
            $request = new Request();
            /**making year label* */
//            $year_remanider = (int)$sanatisharifRecord->depyear % 100 ;
            $year_plus_remainder = (int)$sanatisharifRecord->depyear % 100 +1 ;
            $yearLabel = "($sanatisharifRecord->depyear-$year_plus_remainder)" ;

            $name = $sanatisharifRecord->lessonname . " ".$sanatisharifRecord->depname." ".$yearLabel;
            $request->offsetSet("id" , $sanatisharifRecord->departmentlessonid);
            $request->offsetSet("name" , $name);
            $controller = new ContentsetController();
            $response = $controller->store($request);
            if($response->getStatusCode() == 200)
            {
                $request = new Request();
                $request->offsetSet("departmentlessonTransferred" , 1);
                $response = $this->update($request , $sanatisharifRecord);
                if($response->getStatusCode() == 200)
                {

                }elseif($response->getStatusCode() == 503)
                {
                    dump("departmentlesson state wasn't saved. id: ".$sanatisharifRecord->departmentlessonid);
                }
            }
            elseif($response->getStatusCode() == 503)
            {
                dump("departmentlesson wasn't transferred. id: ".$sanatisharifRecord->departmentlessonid);
            }
        }
        return $this->response->setStatusCode(200)->setContent(["message"=>"پلی لیست ها با موفقیت ایجاد شدند"]);
    }

    public function copyVideo()
    {
        $sanatisharifRecords = Sanatisharifmerge::whereNotNull("videoid")->where("videoTransferred" , 0)->get();
        foreach ($sanatisharifRecords as $sanatisharifRecord)
        {
            if(!isset($sanatisharifRecord->videolink)
            && !isset($sanatisharifRecord->videolinkhq)
            && !isset($sanatisharifRecord->videolink240p)) continue;

            if(!$sanatisharifRecord->departmentlessonEnable && $sanatisharifRecord->videosession == 0) continue;
            $request = new \App\Http\Requests\InsertEducationalContentRequest();
            $request->offsetSet("template_id" , 1);
            $request->offsetSet("name" , $sanatisharifRecord->videoname);
            $request->offsetSet("description" , $sanatisharifRecord->videodescrip);
            if($sanatisharifRecord->departmentlessonEnable) $request->offsetSet("enable" , 1);
//            $request->offsetSet("validSince" , ""); //ToDo
            $request->offsetSet("contenttypes" , [8]);
            if(Contentset::where("id",$sanatisharifRecord->departmentlessonid)->get()->isNotEmpty())
                $request->offsetSet("contentsets" , [["id"=>$sanatisharifRecord->departmentlessonid , "order"=>$sanatisharifRecord->videosession]]);
            else
                dump("contentset was not exist. id: ".$sanatisharifRecord->departmentlessonid);
            $request->offsetSet("fromAPI" , true);

            $files = array();
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolink , "caption"=>"کیفیت عالی" , "label"=>"hd" ]);
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolinkhq , "caption"=>"کیفیت بالا" , "label"=>"hq" ]);
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolink240p , "caption"=>"کیفیت متوسط" , "label"=>"240p" ]);
            if(!empty($files)) $request->offsetSet("files" , $files );

            $controller = new EducationalContentController();
            $response = $controller->store($request);
            $responseContent =  json_decode($response->getContent());
            if($response->getStatusCode() == 200)
            {
                $request = new Request();
                $request->offsetSet("videoTransferred" , 1);
                if(isset($responseContent->id))
                    $request->offsetSet("educationalcontent_id" , $responseContent->id);
                $response = $this->update($request , $sanatisharifRecord);
                if($response->getStatusCode() == 200)
                {

                }elseif($response->getStatusCode() == 503)
                {
                    dump("video state wasn't saved. id: ".$sanatisharifRecord->videoid);
                }
            }elseif($response->getStatusCode() == 503)
            {
                dump("video wasn't transferred. id: ".$sanatisharifRecord->videoid);
            }
        }
    }
}
