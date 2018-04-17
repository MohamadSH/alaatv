<?php

namespace App\Http\Controllers;

use App\Contentset;
use App\Educationalcontent;
use App\Sanatisharifmerge;
use App\Traits\MetaCommon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SanatisharifmergeController extends Controller
{
    use MetaCommon;
    protected $response;

    private function s($deplessonid, & $c , $mod){
        switch ($deplessonid)
        {
            case 1 :
                if($mod=1)
                    $c=["ریاضی"];
                else
                    $c = " جمع بندی بازتاب نور";
                break;
            case 3 :
                break;
            case 4 :
                break;
            case 5 :
                break;
            case 6 :
                break;
            case 8 :
                break;
            case 9 :
                break;
            case 10 :
                break;
            case 11 :
                break;
            case 12 :
                break;
            case 13 :
                break;
            case 17 :
                break;
            case 20 :
                break;
            case 21 :
                break;
            case 22 :
                break;
            case 23 :
                break;
            case 25 :
                break;
            case 26 :
                break;
            case 27 :
                break;
            case 28 :
                break;
            case 29 :
                break;
            case 30 :
                break;
            case 31 :
                break;
            case 32 :
                break;
            case 35 :
                break;
            case 36 :
                break;
            case 37 :
                break;
            case 38 :
                break;
            case 39 :
                break;
            case 40 :
                break;
            case 41 :
                break;
            case 42 :
                break;
            case 43 :
                break;
            case 44 :
                break;
            case 45 :
                break;
            case 46 :
                break;
            case 47 :
                break;
            case 48 :
                break;
            case 50 :
                break;
            case 51 :
                break;
            case 52 :
                break;
            case 53 :
                break;
            case 54 :
                break;
            case 56 :
                break;
            case 57 :
                break;
            case 58 :
                break;
            case 60 :
                break;
            case 61 :
                break;
            case 62 :
                break;
            case 63 :
                break;
            case 64 :
                break;
            case 65 :
                break;
            case 66 :
                break;
            case 68 :
                break;
            case 69 :
                break;
            case 72 :
                break;
            case 73 :
                break;
            case 74 :
                break;
            case 75 :
                break;
            case 76 :
                break;
            case 77 :
                break;
            case 78 :
                break;
            case 79 :
                break;
            case 80 :
                break;
            case 81 :
                break;
            case 84 :
                break;
            case 86 :
                break;
            case 88 :
                break;
            case 89 :
                break;
            case 90 :
                break;
            case 91 :
                break;
            case 92 :
                break;
            case 93 :
                break;
            case 94 :
                break;
            case 95 :
                break;
            case 96 :
                break;
            case 97 :
                break;
            case 98 :
                break;
            case 99 :
                break;
            case 100 :
                break;
            case 101 :
                break;
            case 102 :
                break;
            case 103 :
                break;
            case 104 :
                break;
            case 105 :
                break;
            case 106 :
                break;
            case 107 :
                break;
            case 108 :
                break;
            case 109 :
                break;
            case 110 :
                break;
            case 111 :
                break;
            case 112 :
                break;
            case 113 :
                break;
            case 114 :
                break;
            case 115 :
                break;
            case 116 :
                break;
            case 117 :
                break;
            case 118 :
                break;
            case 119 :
                break;
            case 120 :
                break;
            case 121 :
                break;
            case 122 :
                break;
            case 123 :
                break;
            case 124 :
                break;
            case 125 :
                break;
            case 126 :
                break;
            case 127 :
                break;
            case 128 :
                break;
            case 129 :
                break;
            case 130 :
                break;
            case 131 :
                break;
            case 132 :
                break;
            case 133 :
                break;
            case 134 :
                break;
            case 135 :
                break;
            case 136 :
                break;
            case 137 :
                break;
            case 138 :
                break;
            case 139 :
                break;
            case 140 :
                break;
            case 141 :
                break;
            case 142 :
                break;
            case 143 :
                break;
            case 144 :
                break;
            case 145 :
                break;
            case 146 :
                break;
            case 147 :
                break;
            case 148 :
                break;
            case 149 :
                break;
            case 150 :
                break;
            case 151 :
                break;
            case 152 :
                break;
            case 153 :
                break;
            case 155 :
                break;
            case 156 :
                break;
            case 157 :
                break;
            case 158 :
                break;
            case 159 :
                break;
            case 160 :
                break;
            case 162 :
                break;
            case 163 :
                break;
            case 164 :
                break;
            case 165 :
                break;
            case 166 :
                break;
            case 167 :
                break;
            case 168 :
                break;
            case 169 :
                break;
            case 170 :
                break;
            case 171 :
                break;
            case 172 :
                break;
            case 173 :
                break;
            case 174 :
                break;
            case 175 :
                break;
            case 177 :
                break;
            case 178 :
                break;
            case 179 :
                break;
            case 180 :
                break;
            case 181 :
                break;
            case 182 :
                break;
            case 183 :
                break;
            case 184 :
                break;
            case 185 :
                break;
            case 186 :
                break;
            case 187 :
                break;
            case 188 :
                break;
            case 189 :
                break;
            case 190 :
                break;
            case 191 :
                break;
            case 192 :
                break;
            case 193 :
                break;
            case 194 :
                break;
            case 195 :
                break;
            case 196 :
                break;
            case 197 :
                break;
            default:
                break;
        }
    }

    protected function determineTags($deplessonid)
    {
        $tags = array();
        s($deplessonid,$tags,1);
        return $tags;
    }
    protected function determineContentSetName($deplessonid)
    {
        $name = null;
        s($deplessonid,$name,0);
        return $name;
    }

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

//        foreach ($sanatisharifRecords as $lastSanatisharifRecord)
//        {
//            if(!isset($lastSanatisharifRecord->videolink)
//                && !isset($lastSanatisharifRecord->videolinkhq)
//                && !isset($lastSanatisharifRecord->videolink240p)) continue;
//            if(!$lastSanatisharifRecord->departmentlessonEnable && $lastSanatisharifRecord->videosession == 0) continue;
//
//            $lastEducationalContent = Educationalcontent::where("name" , $lastSanatisharifRecord->videoname)->get();
//            if($lastEducationalContent->isNotEmpty())
//            {
//                $lastEducationalContent->first()->forceDelete();
//                dump($lastEducationalContent." was removed because it wasn't complete");
//                break;
//            }
//        }

        $threshold = 500;
        $counter = 0 ;
        foreach ($sanatisharifRecords as $sanatisharifRecord)
        {
            if($counter >= $threshold) break;
            dump("Videoid ".$sanatisharifRecord->videoid." started");
            try{

            /**   conditional by passing some records   */
            if( (!isset($sanatisharifRecord->videolink)
            && !isset($sanatisharifRecord->videolinkhq)
            && !isset($sanatisharifRecord->videolink240p) ) ||
            (!$sanatisharifRecord->departmentlessonEnable && $sanatisharifRecord->videosession == 0))
            {
                dump("Videoid ".$sanatisharifRecord->videoid." skipped");
                $request = new Request();
                $request->offsetSet("videoTransferred" , 2);
                $response = $this->update($request , $sanatisharifRecord);
                if($response->getStatusCode() == 200)
                {

                }elseif($response->getStatusCode() == 503)
                {
                    dump("Skipped status wasn't saved for video: ".$sanatisharifRecord->videoid);
                }
                continue;
            }
            $request = new \App\Http\Requests\InsertEducationalContentRequest();
            $request->offsetSet("template_id" , 1);
            if(strlen($sanatisharifRecord->videoname) > 0)
            {
                $request->offsetSet("name" , $sanatisharifRecord->videoname);
                $metaTitle = strip_tags(htmlspecialchars(substr($sanatisharifRecord->videoname ,0,55)));
                $request->offsetSet("metaTitle" , $metaTitle );
            }
            if(strlen($sanatisharifRecord->videodescrip) > 0)
            {
                $request->offsetSet("description" , $sanatisharifRecord->videodescrip);
                $metaDescription =  htmlspecialchars(strip_tags(substr($sanatisharifRecord->videodescrip, 0 , 155)));
                $request->offsetSet("metaDescription" , $metaDescription);
            }

            if(strlen($sanatisharifRecord->videoname)>0 || strlen($sanatisharifRecord->videodescrip)>0)
            {
                $video_meta_description_complete = htmlspecialchars(strip_tags($sanatisharifRecord->videoname) . " " . strip_tags($sanatisharifRecord->videodescrip));
                $video_meta_description_complete = preg_replace('/[^\p{L}|\p{N}]+/u', ' ', $video_meta_description_complete);
                $video_meta_description_complete = preg_replace('/[\p{Z}]{2,}/u', " ", $video_meta_description_complete);

                $addKeyword = 'دبیرستان,دانشگاه,صنعتی,شریف,آلاء,الا,دانشگاه شریف, دبیرستان شریف, فیلم, آموزش,رایگان,کنکور,امتحان نهایی,تدریس';
                $manualKeyword = '';
                $metaKeywords = $this->generateKeywordsMeta($video_meta_description_complete, $manualKeyword, $addKeyword);
                $request->offsetSet("metaKeywords" , $metaKeywords);
            }

            $tags = $this->determineTags($sanatisharifRecord->departmentlessonid);
            array_push($tags , $sanatisharifRecord->teacherfirstname . " ".$sanatisharifRecord->teacherlastname);
            array_push($tags , $sanatisharifRecord->depyear);
            array_push($tags , $sanatisharifRecord->depname);
            dump($tags);

            if($sanatisharifRecord->departmentlessonEnable) $request->offsetSet("enable" , 1);
//            $request->offsetSet("validSince" , ""); //ToDo

            $request->offsetSet("contenttypes" , [8]);
            if(Contentset::where("id",$sanatisharifRecord->departmentlessonid)->get()->isNotEmpty())
                $request->offsetSet("contentsets" , [["id"=>$sanatisharifRecord->departmentlessonid , "order"=>$sanatisharifRecord->videosession , "isDefault"=>1]]);
            else
                dump("contentset was not exist. id: ".$sanatisharifRecord->departmentlessonid);
            $request->offsetSet("fromAPI" , true);

            $files = array();
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolink , "caption"=>"کیفیت عالی" , "label"=>"hd" ]);
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolinkhq , "caption"=>"کیفیت بالا" , "label"=>"hq" ]);
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->videolink240p , "caption"=>"کیفیت متوسط" , "label"=>"240p" ]);
            if(isset($sanatisharifRecord->videolink)) array_push($files ,["name"=>$sanatisharifRecord->thumbnail , "caption"=>"تامبنیل" , "label"=>"thumbnail" ]);
            if(!empty($files)) $request->offsetSet("files" , $files );

            $controller = new EducationalContentController();
//            $response = $controller->store($request);
//            $responseContent =  json_decode($response->getContent());
//            if($response->getStatusCode() == 200)
//            {
//                $request = new Request();
//                $request->offsetSet("videoTransferred" , 1);
//                if(isset($responseContent->id))
//                    $request->offsetSet("educationalcontent_id" , $responseContent->id);
//                $response = $this->update($request , $sanatisharifRecord);
//                if($response->getStatusCode() == 200)
//                {
//
//                }elseif($response->getStatusCode() == 503)
//                {
//                    dump("Transferred status wasn't saved for video: ".$sanatisharifRecord->videoid);
//                }
//            }elseif($response->getStatusCode() == 503)
//            {
//                dump("video wasn't transferred. id: ".$sanatisharifRecord->videoid);
//            }
            $counter++ ;
            dump("Videoid ".$sanatisharifRecord->videoid." done");
            } catch (\Exception $e){
                dump($e->getMessage());
                dump("Video ID: ".$sanatisharifRecord->videoid);
            }
        }

        dump($counter." رکورد منتقل شد.");
        return $this->response->setStatusCode(200)->setContent(["message"=>"پایان عملیات انتقال"]);
    }
}
