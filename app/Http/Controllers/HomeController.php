<?php

namespace App\Http\Controllers;

use App\Assignmentstatus;
use App\Attribute;
use App\Attributecontrol;
use App\Attributeset;
use App\Checkoutstatus;
use App\Consultationstatus;
use App\Contentset;
use App\Contenttype;
use App\Coupon;
use App\Coupontype;
use App\Educationalcontent;
use App\Event;
use App\Eventresult;
use App\Gender;
use App\Grade;
use App\Http\Requests\ContactUsFormRequest;
use App\Http\Requests\SendSMSRequest;
use App\Lottery;
use App\Major;
use App\Order;
use App\Orderstatus;
use App\Paymentmethod;
use App\Paymentstatus;
use App\Permission;
use App\Product;
use App\Productfile;
use App\Producttype;
use App\Question;
use App\Relative;
use App\Role;
use App\Slideshow;
use App\Traits\APIRequestCommon;
use App\Traits\CharacterCommon;
use App\Traits\DateCommon;
use App\Traits\Helper;
use App\Traits\ProductCommon;
use App\Transactionstatus;
use App\User;
use App\Userbonstatus;
use App\Userstatus;
use App\Usersurveyanswer;
use App\Userupload;
use App\Useruploadstatus;
use App\Websitesetting;
use App\Websitepage;
use App\Http\Requests\Request;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;
use League\Flysystem\Filesystem;
use League\Flysystem\Sftp\SftpAdapter;

use SSH;
use Auth;
use SEO;

use Watson\Sitemap\Facades\Sitemap;

//use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    use Helper;
    use APIRequestCommon ;
    use ProductCommon;
    use DateCommon;
    use CharacterCommon;
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    protected $response;
    protected $sideBarAdmin;
    protected $setting;

    private static $TAG = HomeController::class;

    public function debug(Request $request){
        abort(404);
    }
    public function __construct()
    {
//        $agent = new Agent();
//        if ($agent->isRobot())
//        {
//            $authException = ['index' , 'getImage' , 'error404' , 'error403' , 'error500' , 'errorPage' , 'siteMapXML', 'download' ];
//        }else{
        $authException = ['index', 'getImage', 'error404', 'error403', 'error500', 'errorPage', 'aboutUs', 'contactUs', 'sendMail', 'rules', 'siteMapXML', 'uploadFile' , 'search' , 'schoolRegisterLanding'];
//        }
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('ability:' . Config::get("constants.ROLE_ADMIN") . ',' . Config::get("constants.USER_ADMIN_PANEL_ACCESS"), ['only' => 'admin']);
        $this->middleware('permission:' . Config::get('constants.CONSULTANT_PANEL_ACCESS'), ['only' => 'consultantAdmin']);
        $this->middleware('permission:' . Config::get("constants.PRODUCT_ADMIN_PANEL_ACCESS"), ['only' => 'adminProduct']);
        $this->middleware('permission:' . Config::get("constants.CONTENT_ADMIN_PANEL_ACCESS"), ['only' => 'adminContent']);
        $this->middleware('permission:' . Config::get("constants.LIST_ORDER_ACCESS"), ['only' => 'adminOrder']);
        $this->middleware('permission:' . Config::get("constants.SMS_ADMIN_PANEL_ACCESS"), ['only' => 'adminSMS']);
        $this->middleware('permission:' . Config::get("constants.REPORT_ADMIN_PANEL_ACCESS"), ['only' => 'adminReport']);
        $this->middleware('ability:' . Config::get("constants.ROLE_ADMIN") . ',' . Config::get("constants.TELEMARKETING_PANEL_ACCESS"), ['only' => 'adminTeleMarketing']);
        $this->response = new Response();
        $this->setting = json_decode(app('setting')->setting);

    }

    private function getRedisRequestSubPath(Request $request, $itemType , $paginationSetting){

        $requestSubPath = "&withscores=1";
        $bucket = "content";
        switch ($itemType)
        {
            case "video":
                $perPage = $paginationSetting->where("itemType" , "video")->first()["itemPerPage"];
                $pageName = $paginationSetting->where("itemType" , "video")->first()["pageName"];
                $itemTypeTag = "فیلم";
                break;
            case "pamphlet":
                $perPage = $paginationSetting->where("itemType" , "pamphlet")->first()["itemPerPage"];
                $pageName = $paginationSetting->where("itemType" , "pamphlet")->first()["pageName"];
                $itemTypeTag = "جزوه";
                break;
            case "article":
                $perPage = $paginationSetting->where("itemType" , "article")->first()["itemPerPage"];
                $pageName = $paginationSetting->where("itemType" , "article")->first()["pageName"];
                $itemTypeTag = "مقاله";
                $pageNum = $request->get($pageName);
                break;
            case "contentset":
                $perPage = $paginationSetting->where("itemType" , "contentset")->first()["itemPerPage"];
                $pageName = $paginationSetting->where("itemType" , "contentset")->first()["pageName"];
                $bucket = "contentset";
                $itemTypeTag = "دوره_آموزشی";
                break;
            case "product":
                $perPage = 16;
                $bucket = "product";
                $itemTypeTag = "محصول";
                $pageName = "other";
                break;
            default:
                $perPage = 16;
                $bucket = $itemType;
                $itemTypeTag = "other";
                $pageName = "other";
                break;
        }
        $requestSubPath .= "&limit=".(int)$perPage;

        if(isset($pageName))
        {
            $pageNum = $request->get($pageName);
            if(!isset($pageNum))
                $pageNum = 1;
            $offset = (int)$perPage * ((int)$pageNum - 1);
            $requestSubPath .= "&offset=".$offset;
        }
        else
        {

            $requestSubPath .= "&offset=0";
            $pageName = "other";
        }
        return [
            $requestSubPath,
            $bucket,
            $itemTypeTag,
            $perPage,
            $pageName
        ];
    }

    private function getIdFromRedis(string  $bucket , array  $bucketTags, string $requestSubPath){

        $strTags = implode("\",\"",$bucketTags);
        $strTags = "[\"$strTags\"]";
        $requestBasePath = config('constants.TAG_API_URL') . "tags/";
        $bucketRequestPath = $requestBasePath . $bucket . "?tags=".$strTags. $requestSubPath;
        $response = $this->sendRequest($bucketRequestPath, "GET");
        if ($response["statusCode"] == 200) {
            $result = json_decode($response["result"]);
            $total_items_db = $result->data->total_items_db;
            $arrayOfId = [];
            foreach ($result->data->items as $item) {
                array_push($arrayOfId, $item->id);
            }
            return [
                $total_items_db,
                $arrayOfId
            ];
        }


    }

    private function getPartialSearchFromIds(Request $request, $query, string $itemType, int $perPage, int $total_items_db,string $pageName){
        $options = [
            "pageName" => $pageName
        ];
        $query = new LengthAwarePaginator(
            $query,
            $total_items_db,
            $perPage,
            null  ,
            $options
        );
        switch ($itemType)
        {
            case "video":
                $query->load('files');
                break;
            case "pamphlet":
            case "article":
                break;
            case "contentset":
                $query->load('educationalcontents');
                break;
            case "product":
                break;
        }
        $partialSearch = View::make(
            'partials.search.'.$itemType,
            [
                'items' => $query
            ]
        )->render();
        return $partialSearch;
    }
    private function getJsonFromIds(Request $request, $query){
        return $query;
    }
    private function makeJsonForAndroidApp(Collection $items){
        $items = $items->pop();
        $key = md5($items->pluck("id")->implode(","));
        $response = Cache::remember($key,Config::get("constants.CACHE_60"),function () use($items){
            $response = collect();
            $items->load('files');
            foreach ($items as $item){
                $hq = "";
                $h240 ="" ;
                if (isset($item->files)) {
                    $hq= $item->files->where('pivot.label','hq')->first();

                    if (isset($hq)) {
                        $hq = $hq->name;
                        $h240 = $hq;
                    }
                }

                if (isset($item->files)) {
                    $temp = $item->files->where('pivot.label','240p')->first();
                    if (isset($temp)) {
                        $h240 = $temp->name;
                    }
                }

                $thumbnail = $item->files->where('pivot.label','thumbnail')->first();
                $contenSets = $item->contentsets->where("pivot.isDefault" , 1)->first();
                $sessionNumber = $contenSets->pivot->order;
                $response->push(
                    [
                        "videoId" => $item->id,
                        "name" => $item->getDisplayName(),
                        "videoDescribe" => $item->description,
                        "url" => action('EducationalContentController@show',$item),
                        "videoLink480" => $hq,
                        "videoLink240" => $h240,
                        "videoviewcounter" =>"0",
                        "videoDuration" => 0,
                        "session" => $sessionNumber."",
                        "thumbnail" => $thumbnail->name
                    ]
                );
                //dd($response);
                //return response()->make("ok");
            }
            $response->push(json_decode("{}"));
            return $response;
        });
        return $response;
    }

    public function search( Request $request )
    {
        $itemTypes = $request->get('itemTypes');
        $tagInput  = $request->get('tags');

        if(isset($itemTypes))
        {
            if(!is_array($itemTypes))
                return $this->response
                    ->setStatusCode(422)
                    ->setContent(["message"=>"bad input: itemTypes"]) ;
            $itemTypes = array_filter($itemTypes);
        }
        else
        {
            $itemTypes = ["video" , "pamphlet" , "contentset", "product" , "article"];
        }

        //ToDo: Appropriate error page
        if (isset($tagInput)) {
            if(!is_array($tagInput)){
                return $this->response
                    ->setStatusCode(422)
                    ->setContent([
                        "message"=>"bad input: tags"
                    ]) ;
            }
            $tagInput = array_filter($tagInput);
        }else{
            $tagInput = [];
        }
        $isApp = ( strlen(strstr($request->header('User-Agent'),"Alaa")) > 0 )? true : false ;
        $items = collect();
        if($isApp)
            $itemPerPage = "200" ;
        else
            $itemPerPage = "12" ;

        $paginationSetting = collect([
            [
                "itemType"=>"video" ,
                "pageName" => "videopage",
                "itemPerPage" => $itemPerPage
            ],
            [
                "itemType"=>"pamphlet" ,
                "pageName" => "pamphletpage",
                "itemPerPage" => $itemPerPage
            ],
            [
                "itemType"=>"article" ,
                "pageName" => "articlepage",
                "itemPerPage" => $itemPerPage
            ],
            [
                "itemType"=>"contentset" ,
                "pageName" => "contentsetpage",
                "itemPerPage" => $itemPerPage
            ]
        ]);
        foreach ($itemTypes as $itemType)
        {
            [
                $requestSubPath,
                $bucket,
                $itemTypeTag,
                $perPage,
                $pageName
            ] = $this->getRedisRequestSubPath($request,$itemType,$paginationSetting);

            $bucketTags = $tagInput ;
            try {
                if(!in_array($itemTypeTag , $tagInput)){
                    array_push($bucketTags, $itemTypeTag);
                }
                [
                    $total_items_db,
                    $arrayOfId
                ] = $this->getIdFromRedis($bucket,$bucketTags,$requestSubPath);
            }
            catch (\Exception    $e) {
                $message = "unexpected error";
                return $this->response
                    ->setStatusCode(503)
                    ->setContent([
                        "message"=>$message ,
                        "error"=>$e->getMessage() ,
                        "line"=>$e->getLine() ,
                        "file"=>$e->getFile()
                    ]);
            }

            switch ($itemType)
            {
                case "video":
                case "pamphlet":
                case "article":
                    $query = Educationalcontent::whereIn("id",$arrayOfId)
                        ->where('enable',1)
                        ->orderBy("created_at" , "desc")
                        ->get();
                    break;
                case "contentset":
                    $query = Contentset::whereIn("id",$arrayOfId)
                        ->where('enable',1)
                        ->orderBy("created_at" , "desc")
                        ->get();
                    break;
                case "product":
                    $query = Product::getProducts(0,1)->whereIn("id" , $arrayOfId)
                        ->orderBy("order")->get();
                    break;
                default:
                    continue 2;
                    break;
            }
            if($isApp){
                $items->push($this->getJsonFromIds($request, $query));
            }else {
                if ($total_items_db > 0)
                    $partialSearch = $this->getPartialSearchFromIds($request, $query, $itemType, $perPage, $total_items_db, $pageName);
                else
                    $partialSearch = null;
                $items->push([
                    "type"=>$itemType,
                    "totalitems"=> $total_items_db,
                    "view"=>$partialSearch,
                ]);
            }

        }
        if($isApp){
            $response = $this->makeJsonForAndroidApp($items);
            return response()->json($response,200);
        }

        /**
         * Page inputs
         */
        $totalTags = array();
        $majorCollection = collect([
            [
                "name"=>"همه رشته ها" ,
                "description"=>""
            ]
        ]);
        $majorCollection = $majorCollection->merge(Major::all());
        $majorLesson = collect();
        $defaultLesson = [];
        foreach ($majorCollection as $major)
        {
            $lessons = collect([]);
            switch ($major["name"])
            {
                case "همه رشته ها":
                    $lessons= $lessons->merge(collect([
                            ["value"=>"", "index"=>"همه دروس"] ,
                            ["value"=>"مشاوره", "index"=>"مشاوره"] ,
                            ["value"=>"دیفرانسیل", "index"=>"دیفرانسیل"] ,
                            ["value"=>"تحلیلی", "index"=>"تحلیلی"] ,
                            ["value"=>"گسسته", "index"=>"گسسته"] ,
                            ["value"=>"حسابان", "index"=>"حسابان"] ,
                            ["value"=>"جبر_و_احتمال", "index"=>"جبر و احتمال"] ,
                            ["value"=>"ریاضی_پایه", "index"=>"ریاضی پایه"] ,
                            ["value"=>"هندسه_پایه", "index"=>"هندسه پایه"] ,
                            ["value"=>"فیزیک", "index"=>"فیزیک"] ,
                            ["value"=>"شیمی", "index"=>"شیمی" ],
                            ["value"=>"عربی", "index"=>"عربی" ],
                            ["value"=>"زبان_و_ادبیات_فارسی", "index"=>"زبان و ادبیات فارسی" ],
                            ["value"=>"دین_و_زندگی", "index"=>"دین و زندگی" ],
                            ["value"=>"زبان_انگلیسی", "index"=>"زبان انگلیسی" ],
                            ["value"=>"آمار_و_مدلسازی", "index"=>"آمار و مدلسازی"] ,
                            ["value"=>"زیست_شناسی", "index"=>"زیست شناسی"] ,
                            ["value"=>"ریاضی_تجربی", "index"=>"ریاضی تجربی"] ,
                            ["value"=>"ریاضی_انسانی", "index"=>"ریاضی انسانی"] ,
                            ["value"=>"ریاضی_و_آمار", "index"=>"ریاضی و آمار"] ,
                            ["value"=>"منطق", "index"=>"منطق"] ,
                            ["value"=>"اخلاق", "index"=>"اخلاق"] ,
                            ["value"=>"المپیاد_نجوم", "index"=>"المپیاد نجوم"] ,
                            ["value"=>"المپیاد_فیزیک", "index"=>"المپیاد فیزیک"] ,
                        ])
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break ;
                case "ریاضی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "index"=>"همه دروس"] ,
                        ["value"=>"مشاوره", "index"=>"مشاوره"] ,
                        ["value"=>"دیفرانسیل", "index"=>"دیفرانسیل"] ,
                        ["value"=>"تحلیلی", "index"=>"تحلیلی"] ,
                        ["value"=>"گسسته", "index"=>"گسسته"] ,
                        ["value"=>"حسابان", "index"=>"حسابان"] ,
                        ["value"=>"جبر_و_احتمال", "index"=>"جبر و احتمال"] ,
                        ["value"=>"ریاضی_پایه", "index"=>"ریاضی پایه"] ,
                        ["value"=>"هندسه_پایه", "index"=>"هندسه پایه"] ,
                        ["value"=>"فیزیک", "index"=>"فیزیک"] ,
                        ["value"=>"شیمی", "index"=>"شیمی" ],
                        ["value"=>"عربی", "index"=>"عربی" ],
                        ["value"=>"زبان_و_ادبیات_فارسی", "index"=>"زبان و ادبیات فارسی" ],
                        ["value"=>"دین_و_زندگی", "index"=>"دین و زندگی" ],
                        ["value"=>"زبان_انگلیسی", "index"=>"زبان انگلیسی" ],
                        ["value"=>"آمار_و_مدلسازی", "index"=>"آمار و مدلسازی"] ,
                        ["value"=>"المپیاد_نجوم", "index"=>"المپیاد نجوم"] ,
                        ["value"=>"المپیاد_فیزیک", "index"=>"المپیاد فیزیک"] ,
                        ])
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break;
                case "تجربی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "index"=>"همه دروس"] ,
                        ["value"=>"مشاوره", "index"=>"مشاوره"] ,
                        ["value"=>"زیست_شناسی", "index"=>"زیست شناسی"] ,
                        ["value"=>"ریاضی_تجربی", "index"=>"ریاضی تجربی"] ,
                        ["value"=>"ریاضی_پایه", "index"=>"ریاضی پایه"] ,
                        ["value"=>"هندسه_پایه", "index"=>"هندسه پایه"] ,
                        ["value"=>"فیزیک", "index"=>"فیزیک"] ,
                        ["value"=>"شیمی", "index"=>"شیمی" ],
                        ["value"=>"عربی", "index"=>"عربی" ],
                        ["value"=>"زبان_و_ادبیات_فارسی", "index"=>"زبان و ادبیات فارسی" ],
                        ["value"=>"دین_و_زندگی", "index"=>"دین و زندگی" ],
                        ["value"=>"زبان_انگلیسی", "index"=>"زبان انگلیسی" ],
                        ["value"=>"آمار_و_مدلسازی", "index"=>"آمار و مدلسازی"] ,
                        ["value"=>"المپیاد_نجوم", "index"=>"المپیاد نجوم"] ,
                        ["value"=>"المپیاد_فیزیک", "index"=>"المپیاد فیزیک"] ,
                        ])
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break;
                case "انسانی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "index"=>"همه دروس"] ,
                        ["value"=>"مشاوره", "index"=>"مشاوره"] ,
                        ["value"=>"ریاضی_انسانی", "index"=>"ریاضی انسانی"] ,
                        ["value"=>"ریاضی_و_آمار", "index"=>"ریاضی و آمار"] ,
                        ["value"=>"منطق", "index"=>"منطق"] ,
                        ["value"=>"اخلاق", "index"=>"اخلاق"] ,
                        ["value"=>"عربی", "index"=>"عربی" ],
                        ["value"=>"زبان_و_ادبیات_فارسی", "index"=>"زبان و ادبیات فارسی" ],
                        ["value"=>"دین_و_زندگی", "index"=>"دین و زندگی" ],
                        ["value"=>"زبان_انگلیسی", "index"=>"زبان انگلیسی" ],
                        ["value"=>"آمار_و_مدلسازی", "index"=>"آمار و مدلسازی"] ,
                        ])
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break;
                default:
                    break;
            }
            $totalTags = array_merge($totalTags , $lessons->pluck("value")->toArray()) ;
            $majorLesson->put( $major["description"], $lessons);
        }
        $totalTags = array_merge($totalTags , $majorCollection->pluck("description")->toArray()) ;
        $majors = $majorCollection->pluck(  "name" , "description")->toArray();

        $gradeCollection = Grade::whereNotIN("name" , ['graduated' ,"haftom" ,"hashtom" , "nohom" , "davazdahom" ])->get();
        $gradeCollection->push(["displayName"=>"اول دبیرستان" , "description"=>"اول_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"دوم دبیرستان" , "description"=>"دوم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"سوم دبیرستان" , "description"=>"سوم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"چهارم دبیرستان" , "description"=>"چهارم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"المپیاد" , "description"=>"المپیاد_علمی"]);
        $totalTags = array_merge($totalTags , $gradeCollection->pluck("description")->toArray()) ;
        $grades = $gradeCollection->pluck('displayName' , 'description')->toArray() ;
//            $grades = array_sort_recursive($grades);

        $lessonTeacher = collect(
            [
                "" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد صادق ثابتی" , "value"=>"محمد_صادق_ثابتی"],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"محسن شهریان" , "value"=>"محسن_شهریان"],
                    ["index"=>"بهمن مؤذنی پور" , "value"=>"بهمن_مؤذنی_پور"],
                    ["index"=>"سروش معینی" , "value"=>"سروش_معینی"],
                    ["index"=>"شاه محمدی" , "value"=>"شاه_محمدی"],
                    ["index"=>"محمد رضا حسینی فرد" , "value"=>"محمد_رضا_حسینی_فرد"],
                    ["index"=>"وحید کبریایی" , "value"=>"وحید_کبریایی"],
                    ["index"=>"حسن مرصعی" , "value"=>"حسن_مرصعی"],
                    ["index"=>"محمدرضا مقصودی" , "value"=>"محمدرضا_مقصودی"],
                    ["index"=>"شهروز رحیمی" , "value"=>"شهروز_رحیمی"],
                    ["index"=>"حسین کرد" , "value"=>"حسین_کرد"],
                    ["index"=>"مهدی امینی راد" , "value"=>"مهدی_امینی_راد"],
                    ["index"=>"جواد نایب کبیر" , "value"=>"جواد_نایب_کبیر"],
                    ["index"=>"محمدامین نباخته" , "value"=>"محمدامین_نباخته"],
                    ["index"=>"علی صدری" , "value"=>"علی_صدری"],
                    ["index"=>"خسرو محمد زاده" , "value"=>"خسرو_محمد_زاده"],
                    ["index"=>"میلاد ناصح زاده" , "value"=>"میلاد_ناصح_زاده"],
                    ["index"=>"مهدی جلادتی" , "value"=>"مهدی_جلادتی"],
                    ["index"=>"مهدی ناصر شریعت" , "value"=>"مهدی_ناصر_شریعت"],
                    ["index"=>"عمار تاج بخش" , "value"=>"عمار_تاج_بخش"],
                    ["index"=>"ناصر حشمتی" , "value"=>"ناصر_حشمتی"],
                    ["index"=>"محسن آهویی" , "value"=>"محسن_آهویی"],
                    ["index"=>"جعفر رنجبرزاده" , "value"=>"جعفر_رنجبرزاده"],
                    ["index"=>"محمد رضا آقاجانی" , "value"=>"محمد_رضا_آقاجانی"],
                    ["index"=>"مهدی صنیعی طهرانی" , "value"=>"مهدی_صنیعی_طهرانی"],
                    ["index"=>"محمد حسین انوشه" , "value"=>"محمد_حسین_انوشه"],
                    ["index"=>"محمد حسین شکیباییان" , "value"=>"محمد_حسین_شکیباییان"],
                    ["index"=>"حامد پویان نظر" , "value"=>"حامد_پویان_نظر"],
                    ["index"=>"روح الله حاجی سلیمانی" , "value"=>"روح_الله_حاجی_سلیمانی"],
                    ["index"=>"محسن معینی" , "value"=>"محسن_معینی"],
                    ["index"=>"جعفری" , "value"=>"جعفری"],
                    ["index"=>"پیمان طلوعی" , "value"=>"پیمان_طلوعی"],
                    ["index"=>"حمید فدایی فرد" , "value"=>"حمید_فدایی_فرد"],
                    ["index"=>"علیرضا رمضانی" , "value"=>"علیرضا_رمضانی"],
                    ["index"=>"فرشید داداشی" , "value"=>"فرشید_داداشی"],
                    ["index"=>"کازرانیان" , "value"=>"کازرانیان"],
                    ["index"=>"جهانبخش" , "value"=>"جهانبخش"],
                    ["index"=>"علی اکبر عزتی" , "value"=>"علی_اکبر_عزتی"],
                    ["index"=>"کیاوش فراهانی" , "value"=>"کیاوش_فراهانی"],
                    ["index"=>"درویش" , "value"=>"درویش"],
                    ["index"=>"مهدی تفتی" , "value"=>"مهدی_تفتی"],
                    ["index"=>"هامون سبطی" , "value"=>"هامون_سبطی"],
                    ["index"=>"داریوش داوش" , "value"=>"داریوش_راوش"],
                    ["index"=>"عبدالرضا مرادی" , "value"=>"عبدالرضا_مرادی"],
                    ["index"=>"محمد صادقی" , "value"=>"محمد_صادقی"],
                    ["index"=>"کاظم کاظمی" , "value"=>"کاظم_کاظمی"],
                    ["index"=>"میثم حسین خانی" , "value"=>"میثم__حسین_خانی"],
                    ["index"=>"محمد علی امینی راد" , "value"=>"محمد_علی_امینی_راد"],
                    ["index"=>"محمد پازوکی" , "value"=>"محمد_پازوکی"],
                    ["index"=>"عباس راستی بروجنی" , "value"=>"عباس_راستی_بروجنی"],
                    ["index"=>"ابوالفضل جعفری" , "value"=>"ابوالفضل_جعری"],
                    ["index"=>"جلال موقاری" , "value"=>"جلال_موقاری"],
                    ["index"=>"مسعود حدادی" , "value"=>"مسعود_حدادی"],
                    ["index"=>"ارشی" , "value"=>"ارشی"],
                    ["index"=>"رضا آقاجانی" , "value"=>"رضا_آقاجانی"],
                    ["index"=>"سید حسام الدین جلالی" , "value"=>"سید_حسام_الدین_جلالی"],
                    ["index"=>"یاشار بهمند" , "value"=>"یاشار_بهمند"],
                    ["index"=>"مصطفی جعفری نژاد" , "value"=>"مصطفی_جعفری_نژاد"],
                    ["index"=>"امید زاهدی" , "value"=>"امید_زاهدی"],
                ],
                "دیفرانسیل" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد صادق ثابتی" , "value"=>"محمد_صادق_ثابتی"],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"محسن شهریان" , "value"=>"محسن_شهریان"],
                ],
                "گسسته" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"بهمن مؤذنی پور" , "value"=>"بهمن_مؤذنی_پور"],
                    ["index"=>"سروش معینی" , "value"=>"سروش_معینی"],
                    ["index"=>"شاه محمدی" , "value"=>"شاه_محمدی"],
                ],
                "تحلیلی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"محمد صادق ثابتی" , "value"=>"محمد_صادق_ثابتی"],
                    ["index"=>"محمد رضا حسینی فرد" , "value"=>"محمد_رضا_حسینی_فرد"],
                ],
                "هندسه_پایه" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"وحید کبریایی" , "value"=>"وحید_کبریایی"],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"محمد رضا حسینی فرد" , "value"=>"محمد_رضا_حسینی_فرد"],
                    ["index"=>"حسن مرصعی" , "value"=>"حسن_مرصعی"],
                ],
                "حسابان" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد صادق ثابتی" , "value"=>"محمد_صادق_ثابتی"],
                    ["index"=>"محمدرضا مقصودی" , "value"=>"محمدرضا_مقصودی"],
                    ["index"=>"شهروز رحیمی" , "value"=>"شهروز_رحیمی"],
                ],
                "جبر_و_احتمال" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"حسین کرد" , "value"=>"حسین_کرد"],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
//                    ["index"=>"بختیاری" , "value"=>"بختیاری"],
                ],
                "ریاضی_پایه" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"مهدی امینی راد" , "value"=>"مهدی_امینی_راد"],
                    ["index"=>"جواد نایب کبیر" , "value"=>"جواد_نایب_کبیر"],
                    ["index"=>"محسن شهریان" , "value"=>"محسن_شهریان"],
                    ["index"=>"محمدرضا مقصودی" , "value"=>"محمدرضا_مقصودی"],
                ],
                "ریاضی_تجربی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"مهدی امینی راد" , "value"=>"مهدی_امینی_راد"],
                    ["index"=>"محمدامین نباخته" , "value"=>"محمدامین_نباخته"],
                    ["index"=>"محمد رضا حسینی فرد" , "value"=>"محمد_رضا_حسینی_فرد"],
                    ["index"=>"علی صدری" , "value"=>"علی_صدری"],
                ],
                "ریاضی_انسانی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"خسرو محمد زاده" , "value"=>"خسرو_محمد_زاده"],
                ],
                "عربی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"میلاد ناصح زاده" , "value"=>"میلاد_ناصح_زاده"],
                    ["index"=>"مهدی جلادتی" , "value"=>"مهدی_جلادتی"],
                    ["index"=>"مهدی ناصر شریعت" , "value"=>"مهدی_ناصر_شریعت"],
                    ["index"=>"عمار تاج بخش" , "value"=>"عمار_تاج_بخش"],
                    ["index"=>"ناصر حشمتی" , "value"=>"ناصر_حشمتی"],
                    ["index"=>"محسن آهویی" , "value"=>"محسن_آهویی"],
                    ["index"=>"جعفر رنجبرزاده" , "value"=>"جعفر_رنجبرزاده"],
//                    ["index"=>"بختیاری" , "value"=>"بختیاری"],
                ],
                "شیمی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد رضا آقاجانی" , "value"=>"محمد_رضا_آقاجانی"],
                    ["index"=>"مهدی صنیعی طهرانی" , "value"=>"مهدی_صنیعی_طهرانی"],
                    ["index"=>"محمد حسین انوشه" , "value"=>"محمد_حسین_انوشه"],
                    ["index"=>"محمد حسین شکیباییان" , "value"=>"محمد_حسین_شکیباییان"],
                    ["index"=>"حامد پویان نظر" , "value"=>"حامد_پویان_نظر"],
                    ["index"=>"روح الله حاجی سلیمانی" , "value"=>"روح_الله_حاجی_سلیمانی"],
                    ["index"=>"محسن معینی" , "value"=>"محسن_معینی"],
                    ["index"=>"جعفری" , "value"=>"جعفری"],
                ],
                "فیزیک" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"پیمان طلوعی" , "value"=>"پیمان_طلوعی"],
                    ["index"=>"حمید فدایی فرد" , "value"=>"حمید_فدایی_فرد"],
                    ["index"=>"علیرضا رمضانی" , "value"=>"علیرضا_رمضانی"],
                    ["index"=>"فرشید داداشی" , "value"=>"فرشید_داداشی"],
                    ["index"=>"کازرانیان" , "value"=>"کازرانیان"],
                    ["index"=>"جهانبخش" , "value"=>"جهانبخش"],
                ],
                "زبان_انگلیسی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"علی اکبر عزتی" , "value"=>"علی_اکبر_عزتی"],
                    ["index"=>"کیاوش فراهانی" , "value"=>"کیاوش_فراهانی"],
                    ["index"=>"درویش" , "value"=>"درویش"],
                ],
                "دین_و_زندگی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"مهدی تفتی" , "value"=>"مهدی_تفتی"],
                    ["index"=>"جعفر رنجبرزاده" , "value"=>"جعفر_رنجبرزاده"],
                ],
                "زبان_و_ادبیات_فارسی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"هامون سبطی" , "value"=>"هامون_سبطی"],
                    ["index"=>"داریوش داوش" , "value"=>"داریوش_راوش"],
                    ["index"=>"عبدالرضا مرادی" , "value"=>"عبدالرضا_مرادی"],
                    ["index"=>"محمد صادقی" , "value"=>"محمد_صادقی"],
                    ["index"=>"کاظم کاظمی" , "value"=>"کاظم_کاظمی"],
                    ["index"=>"میثم حسین خانی" , "value"=>"میثم__حسین_خانی"],
                ],
                "آمار_و_مدلسازی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا شامیزاده" , "value"=>"رضا_شامیزاده"],
                    ["index"=>"وحید کبریایی" , "value"=>"وحید_کبریایی"],
                    ["index"=>"مهدی امینی راد" , "value"=>"مهدی_امینی_راد"],
                ],
                "زیست_شناسی" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد علی امینی راد" , "value"=>"محمد_علی_امینی_راد"],
                    ["index"=>"محمد پازوکی" , "value"=>"محمد_پازوکی"],
                    ["index"=>"عباس راستی بروجنی" , "value"=>"عباس_راستی_بروجنی"],
                    ["index"=>"ابوالفضل جعفری" , "value"=>"ابوالفضل_جعری"],
                    ["index"=>"جلال موقاری" , "value"=>"جلال_موقاری"],
                    ["index"=>"مسعود حدادی" , "value"=>"مسعود_حدادی"],
                    ["index"=>"ارشی" , "value"=>"ارشی"],
                ],
                "ریاضی_و_آمار" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"مهدی امینی راد" , "value"=>"مهدی_امینی_راد"],
                ],
                "منطق" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"رضا آقاجانی" , "value"=>"رضا_آقاجانی"],
                    ["index"=>"سید حسام الدین جلالی" , "value"=>"سید_حسام_الدین_جلالی"],
                ],
                "المپیاد_فیزیک" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"مصطفی جعفری نژاد" , "value"=>"مصطفی_جعفری_نژاد"],
                ],
                "المپیاد_نجوم" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"یاشار بهمند" , "value"=>"یاشار_بهمند"],
                ],
                "مشاوره" => [
                    ["index"=>"همه دبیرها" , "value"=>""],
                    ["index"=>"محمد علی امینی راد" , "value"=>"محمد_علی_امینی_راد"],
                    ["index"=>"امید زاهدی" , "value"=>"امید_زاهدی"],
                ]
            ]
        );

        $teacherTags =  [];
        foreach ($lessonTeacher as $item)
        {
            foreach ($item as $value)
            {
                array_push($teacherTags , $value["value"]);
            }
        }
        $totalTags = array_merge($totalTags , $teacherTags) ;
        $defaultTeacher = array_intersect( $teacherTags , $tagInput )  ;


        $extraTagArray  = array_diff($tagInput , $totalTags );

        if(!is_null(array_last($defaultLesson)))
            $defaultLesson = array_last($defaultLesson);
        else
            $defaultLesson = "";

        if(!is_null(array_last($defaultTeacher)))
            $defaultTeacher = array_last($defaultTeacher);
        else
            $defaultTeacher = "";
        /**
         * End of page inputs
         */
        if(request()->ajax())
        {
            return $this->response
                ->setStatusCode(200)
                ->setContent([
                    "items"=>$items ,
                    "itemTypes"=>$itemTypes
                ]);
        }
        else
        {
            $sideBarMode = "closed";
            $ads1 = [
            //DINI SEBTI
                 'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4',
            ];
            $ads2 = [
                //DINI SEBTI
                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-2.jpg' => 'https://sanatisharif.ir/landing/4',
                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-3.jpg' => 'https://sanatisharif.ir/landing/4',
            ];
            return view("pages.search" , compact("items"  ,"itemTypes" ,"tagArray" , "extraTagArray",
                "majors" , "grades"  , "defaultLesson" , "sideBarMode" , "majorLesson" , "lessonTeacher" , "defaultTeacher" , "ads1" , "ads2" ));
        }
    }

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $url = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

//        $consultationstatus_active = Consultationstatus::all()->where("name", "active")->first();
//        $consultingQuestionCount = Userupload::all()->count();
//        $consultations = Consultation::all()->sortByDesc("created_at")->where("consultationstatus_id", $consultationstatus_active->id);
//        $consultationCount = $consultations->count();
//        $userCount = User::count();

//        $todayDate = $this->convertDate(Carbon::now()->toDateTimeString(), "toJalali");
//        $todayDate = explode("/", $todayDate);
//        $currentDay = $todayDate[2];
//        $currentMonth = $todayDate[1];
//        $currentYear = $todayDate[0];
//        $educationalContents = Educationalcontent::enable()
//            ->valid()
//            ->orderBy("validSince", "DESC")
//            ->take(10)
//            ->get();
//        $educationalContentCollection = collect();
//        foreach ($educationalContents as $educationalContent) {
//            $educationalContentCollection
//                ->push([
//                    "id" => $educationalContent->id,
//                    "displayName" => $educationalContent->getDisplayName(),
//                    "validSince_Jalali" => explode(" ", $educationalContent->validSince_Jalali())[0]
//                ]);
//        }

        $slides = Websitepage::where('url', "/home")
            ->first()
            ->slides()
            ->where("isEnable", 1)
            ->orderBy("order")
            ->get();
        $slideCounter = 1;
        $slideDisk = 9;

        if (Config::has("constants.HOME_EXCLUDED_PRODUCTS"))
            $excludedProducts = Config::get("constants.HOME_EXCLUDED_PRODUCTS");
        else
            $excludedProducts = [];

        if (Config::has("constants.HOME_PRODUCTS_OFFER")) {
            $productIds = Config::get("constants.HOME_PRODUCTS_OFFER");
            $products = Product::getProducts(0, 1)
                ->orderBy('order')
                ->whereIn("id", $productIds)
                ->whereNotIn("id", $excludedProducts)
                ->take(3)->get();
        } else
        {
//            $products = Product::recentProducts(2)
//                ->whereNotIn("id", $excludedProducts)
//                ->get();
            $products = collect();
        }

//        $costCollection = $this->makeCostCollection($products);
        $costCollection = collect();
        /**
         * Ordroo registration statistics
         *
         * //   BOYS SECTION
         * $boysBlocks = collect([["displayName"=>"سالن ۱" , "capacity"=>"30"] ,["displayName"=>"سالن ۲" , "capacity"=>"30"] ]);
         * $boysOrdooRegisteredCount = Order::whereHas('orderproducts', function($q)
         * {
         * $q->whereIn("product_id",  Product::whereHas('parents', function($q)
         * {
         * $q->whereIn("parent_id",  [1] );
         * })->pluck("id") );
         * })->whereIn("orderstatus_id" , [2])->count();
         *
         * // GIRLS SECTION
         * $girlsBlocks = collect([["displayName"=>"سالن ۱" , "capacity"=>"30"] ,["displayName"=>"سالن ۲" , "capacity"=>"30"] ]);
         * $girlsOrdooRegisteredCount = Order::whereHas('orderproducts', function($q)
         * {
         * $q->whereIn("product_id",  Product::whereHas('parents', function($q)
         * {
         * $q->whereIn("parent_id",  [13] );
         * })->pluck("id") );
         * })->whereIn("orderstatus_id" , [2])->count();
         * /**
         *  end of code
         */


        $pageName = "dashboard";
        return view('pages.dashboard1', compact(
            'pageName',
            'slides',
            'slideCounter',
            'products',
            'costCollection',
            'slideDisk'
        ));
    }

    public function home(){
        return redirect('/',301);
    }

    /**
     * Show the not found page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error404()
    {
        return abort(404);
    }

    /**
     * Show forbidden page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error403()
    {
        return abort(403);
    }

    /**
     * Show general error page.
     *
     * @return \Illuminate\Http\Response
     */
    public function error500()
    {
        return abort(500);
    }

    /**
     * Show the general error page.
     *
     * @param string $message
     * @return \Illuminate\Http\Response
     */
    public function errorPage($message)
    {
//        $message = Input::get("message");
        if (strlen($message) <= 0) $message = "";
        return view("errors.errorPage", compact("message"));
    }

    /**
     * Show admin panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function admin()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
//        $roles = array_add($roles , 0 , "همه نقش ها");
//        $roles = array_sort_recursive($roles);
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [0 => 'همه کاربران', 1 => 'کسانی که سفارش ثبت کرده اند', 2 => 'کسانی که سفارش ثبت نکرده اند'];

        $products = $this->makeProductCollection();

        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

        $tableDefaultColumns = ["نام خانوادگی","نام کوچک", "رشته", "کد ملی", "موبایل", "ایمیل", "شهر", "استان", "وضعیت شماره موبایل", "کد پستی", "آدرس", "مدرسه", "وضعیت", "زمان ثبت نام", "زمان اصلاح", "نقش های کاربر", "تعداد بن", "عملیات"];

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";


        return view("admin.index", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "hasOrder", "products",
            "lockProfileStatus", "mobileNumberVerification", "tableDefaultColumns", "sortBy", "sortType", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Show product admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminProduct()
    {
        $attributecontrols = Attributecontrol::pluck('name', 'id')->toArray();
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];
        $attributesets = Attributeset::pluck('name', 'id')->toArray();
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];

        $products = Product::pluck('name', 'id')->toArray();
        $coupontype = Coupontype::pluck('displayName', 'id');

        $productTypes = Producttype::pluck("displayName", "id");

        $lastProduct = Product::getProducts(0, 1)->get()->sortByDesc("order")->first();
        if (isset($lastProduct)) {
            $lastOrderNumber = $lastProduct->order + 1;
            $defaultProductOrder = $lastOrderNumber;
        } else {
            $defaultProductOrder = 1;
        }

        $pageName = "admin";
        return view("admin.indexProduct", compact("pageName", "attributecontrols", "enableStatus", "attributesets", "limitStatus", "products", "coupontype", "productTypes", "defaultProductOrder"));
    }

    /**
     * Show order admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminOrder()
    {
        $pageName = "admin";
        $user = Auth::user();
        if ($user->can(Config::get('constants.SHOW_OPENBYADMIN_ORDER')))
            $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');
        else
            $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN"), Config::get("constants.ORDER_STATUS_OPEN_BY_ADMIN")])->pluck('displayName', 'id')->toArray();
//        $orderstatuses= array_sort_recursive(array_add($orderstatuses , 0 , "دارای هر وضعیت سفارش")->toArray());

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id')->toArray();
        $majors = Major::pluck('name', 'id');
        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        if($user->hasRole("onlineNoroozMarketing"))
        {
            $products = [Config::get("constants.ORDOO_GHEIRE_HOZOORI_NOROOZ_97_PRODUCT_ROOT")];
            $products = $this->makeProductCollection($products);
        }
        else
        {
            $products = $this->makeProductCollection();
        }


        $paymentMethods = Paymentmethod::pluck('displayName', 'id')->toArray();

        $attributevalueCollection = collect();
        $extraAttributes = Attribute::whereHas("attributegroups", function ($q) {
            $q->where("attributetype_id", 2);
        })->get();
        foreach ($extraAttributes as $attribute) {
            $values = array();
            $values = array_merge($values, $attribute->attributevalues->pluck("id", "name")->toArray());
            if (!empty($values)) $attributevalueCollection->put($attribute->displayName, $values);
        }

        $sortBy = ["updated_at" => "تاریخ اصلاح مدیریتی", "completed_at" => "تاریخ ثبت نهایی", "created_at" => "تاریخ ثبت اولیه", "userFirstName" => "نام مشتری", "userLastName" => "نام خانوادگی مشتری" /* , "productName" => "نام محصول"*/];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];

        $transactionTypes = [0 => "واریز شده", 1 => "بازگشت داده شده"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $transactionStatuses = Transactionstatus::orderBy("order")->pluck("displayName", "id")->toArray();

        $userBonStatuses = Userbonstatus::pluck("displayName", "id");

        $orderTableDefaultColumns = ["محصولات", "نام خانوادگی","نام کوچک", "رشته", "استان", "شهر", "آدرس", "کد پستی", "موبایل", "مبلغ(تومان)", "عملیات", "ایمیل", "پرداخت شده(تومان)", "مبلغ برگشتی(تومان)", "بدهکار/بستانکار(تومان)", "توضیحات مسئول", "کد مرسوله پستی", "توضیحات مشتری", "وضعیت سفارش", "وضعیت پرداخت", "کدهای تراکنش", "تاریخ اصلاح مدیریتی", "تاریخ ثبت نهایی", "ویژگی ها", "تعداد بن استفاده شده", "تعداد بن اضافه شده به شما از این سفارش", "کپن استفاده شده", "تاریخ ایجاد اولیه"];
        $transactionTableDefaultColumns = ["نام مشتری", "تراکنش پدر", "موبایل", "مبلغ سفارش", "مبلغ تراکنش", "کد تراکنش", "نحوه پرداخت", "تاریخ ثبت", "عملیات", "توضیح مدیریتی", "مبلغ فیلتر شده", "مبلغ آیتم افزوده"];
        $userBonTableDefaultColumns = ["نام کاربر", "تعداد بن تخصیص داده شده", "وضعیت بن", "نام کالایی که از خرید آن بن دریافت کرده است", "تاریخ درج", "عملیات"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];


        return view("admin.indexOrder", compact("pageName", "orderstatuses", "products", "paymentMethods", "majors", "paymentstatuses", "sortBy", "sortType", "transactionTypes", "orderTableDefaultColumns", "coupons", "transactionStatuses", "transactionTableDefaultColumns", "userBonTableDefaultColumns", "userBonStatuses", "attributevalueCollection", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Show content admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminContent()
    {
        $majors = Major::pluck('name', 'id');
        $assignmentStatuses = Assignmentstatus::pluck('name', 'id');
        $assignmentStatuses->prepend("انتخاب وضعیت");
        $consultationStatuses = Consultationstatus::pluck('name', 'id');
        $consultationStatuses->prepend("انتخاب وضعیت");



        $pageName = "admin";
        return view("admin.indexContent", compact("pageName", "assignmentStatuses", "consultationStatuses", "majors"));
    }

    /**
     * Show consultant admin panel page
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantAdmin()
    {
        $questions = Userupload::all()->sortByDesc('created_at');
        $questionStatusDone = Useruploadstatus::all()->where("name", "done")->first();
        $questionStatusPending = Useruploadstatus::all()->where("name", "pending")->first();
        $newQuestionsCount = Userupload::all()->where("useruploadstatus_id", $questionStatusPending->id)->count();
        $answeredQuestionsCount = Userupload::all()->where("useruploadstatus_id", $questionStatusDone->id)->count();
        $counter = 0;


        $pageName = "consultantAdmin";
        return view("admin.consultant.consultantAdmin", compact("questions", "counter", "pageName", "newQuestionsCount", "answeredQuestionsCount"));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function consultantEntekhabReshte()
    {
        $user = User::FindOrFail(Input::get("user"));
        if (Storage::disk('entekhabReshte')->exists($user->id . "-" . $user->major->id . ".txt")) {
            $storedMajors = json_decode(Storage::disk('entekhabReshte')->get($user->id . "-" . $user->major->id . ".txt"));
            $parentMajorId = $user->major->id;
            $storedMajorsInfo = Major::whereHas("parents", function ($q) use ($storedMajors, $parentMajorId) {
                $q->where("major1_id", $parentMajorId)->whereIn("majorCode", $storedMajors);
            })->get();

            $selectedMajors = array();
            foreach ($storedMajorsInfo as $storedMajorInfo) {
                $storedMajor = $storedMajorInfo->parents->where("id", $parentMajorId)->first();
                $majorCode = $storedMajor->pivot->majorCode;
                $majorName = $storedMajorInfo->name;
                $selectedMajors = array_add($selectedMajors, $majorCode, $majorName);
            }
        }
        $eventId = 1;
        $surveyId = 1;
        $requestUrl = action("UserSurveyAnswerController@index");
        $requestUrl .= "?event_id[]=" . $eventId . "&survey_id[]=" . $surveyId . "&user_id[]=" . $user->id;
        $originalInput = \Illuminate\Support\Facades\Request::input();
        $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
        \Illuminate\Support\Facades\Request::replace($request->input());
        $response = Route::dispatch($request);
        $answersCollection = json_decode($response->content());
        \Illuminate\Support\Facades\Request::replace($originalInput);
        $userSurveyAnswers = collect();
        foreach ($answersCollection as $answerCollection) {
            $answerArray = $answerCollection->userAnswer->answer;
            $question = Question::FindOrFail($answerCollection->userAnswer->question_id);
            $requestBaseUrl = $question->dataSourceUrl;
            $requestUrl = url("/") . $requestBaseUrl . "?ids=$answerArray";
            $originalInput = \Illuminate\Support\Facades\Request::input();
            $request = \Illuminate\Support\Facades\Request::create($requestUrl, 'GET');
            \Illuminate\Support\Facades\Request::replace($request->input());
            $response = Route::dispatch($request);
            $dataJson = json_decode($response->content());
            \Illuminate\Support\Facades\Request::replace($originalInput);
            $userSurveyAnswers->push(["questionStatement" => $question->statement, "questionAnswer" => $dataJson]);
        }


//        Meta::set('title', substr("آلاء|پنل انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
//        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.consultant.consultantEntekhabReshte", compact("user", "storedMajors", "selectedMajors", "userSurveyAnswers"));
    }

    /**
     * Show consultant admin entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantEntekhabReshteList()
    {
        $eventId = 1;
        $surveyId = 1;
        $usersurveyanswers = Usersurveyanswer::where("event_id", $eventId)->where("survey_id", $surveyId)->get()->groupBy("user_id");


//        Meta::set('title', substr("آلاء|لیست انتخاب رشته", 0, Config::get("constants.META_TITLE_LIMIT")));
//        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.consultant.consultantEntekhabReshteList", compact("usersurveyanswers"));
    }

    /**
     * Storing consultant entekhab reshte
     *
     * @return \Illuminate\Http\Response
     */
    public function consultantStoreEntekhabReshte(\Illuminate\Http\Request $request)
    {
        $userId = $request->get("user");
        $user = User::FindOrFail($userId);
        $parentMajor = $request->get("parentMajor");
        $majorCodes = json_encode($request->get("majorCodes"));

        Storage::disk('entekhabReshte')->delete($userId . '-' . $parentMajor . '.txt');
        Storage::disk('entekhabReshte')->put($userId . "-" . $parentMajor . ".txt", $majorCodes);
        session()->put("success", "رشته های انتخاب شده با موفقیت درج شدند");
        return redirect(action("HomeController@consultantEntekhabReshte", ["user" => $user]));
    }

    /**
     * Show adminSMS panel main page
     *
     * @return \Illuminate\Http\Response
     */
    public function adminSMS()
    {
        $pageName = "admin";

        $userStatuses = Userstatus::pluck('name', 'id');
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $roles = Role::pluck('display_name', 'id');

        $orderstatuses = Orderstatus::whereNotIn('name', ['open'])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $products = $this->makeProductCollection();

        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

        $relatives = Relative::pluck('displayName', 'id');
        $relatives->prepend('فرد');

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        $pageName = "admin";

        $smsCredit = (int)$this->medianaGetCredit();

        $smsProviderNumber = Config::get('constants.SMS_PROVIDER_NUMBER');

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);


//        Meta::set('title', substr("آلاء|پنل پیامک", 0, Config::get("constants.META_TITLE_LIMIT")));
//        Meta::set('image', route('image', ['category' => '11', 'w' => '100', 'h' => '100', 'filename' => $this->setting->site->siteLogo]));

        return view("admin.indexSMS", compact("pageName", "majors", "userStatuses",
            "roles", "relatives", "orderstatuses", "paymentstatuses", "genders", "products", "allRootProducts", "lockProfileStatus",
            "mobileNumberVerification", "sortBy", "sortType", "smsCredit", "smsProviderNumber",
            "numberOfFatherPhones", "numberOfMotherPhones", "coupons", "addressSpecialFilter", "checkoutStatuses"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()->where('url', "/home")->first()->id;
        $slides = $slideController->index()->where("websitepage_id", $slideWebsitepageId);
        $slideDisk = 9;
        $slideContentName = "عکس اسلاید صفحه اصلی";
        $sideBarMode = "closed";
        $section = "slideShow";



        return view("admin.siteConfiguration.slideShow", compact("slides", "sideBarMode", "section", "slideDisk", "slideContentName", "slideWebsitepageId"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminArticleSlideShow()
    {

        $slideController = new SlideShowController();
        $slideWebsitepageId = $websitePageId = Websitepage::all()->where('url', "/لیست-مقالات")->first()->id;
        $slides = $slideController->index()->where("websitepage_id", $slideWebsitepageId);
        $slideDisk = 13;
        $slideContentName = "عکس اسلاید صفحه مقالات";
        $sideBarMode = "closed";
        $section = "articleSlideShow";
        return view("admin.siteConfiguration.articleSlideShow", compact("slides", "sideBarMode", "slideWebsitepageId", "section", "slideDisk", "slideContentName"));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminSiteConfig()
    {
        $this->setting = Websitesetting::where("version", 1)->get()->first();

        return redirect(action('WebsiteSettingController@show', $this->setting));
    }

    /**
     * Admin panel for adjusting site configuration
     */
    public function adminMajor()
    {
        $parentName = Input::get("parent");
        $parentMajor = Major::all()->where("name", $parentName)->where("majortype_id", 1)->first();

        $majors = Major::where("majortype_id", 2)->orderBy("name")->whereHas("parents", function ($q) use ($parentMajor) {
            $q->where("major1_id", $parentMajor->id);
        })->get();


        return view("admin.indexMajor", compact("parentMajor", "majors"));
    }

    /**
     * Admin panel for getting a special report
     */
    public function adminReport()
    {
        $userStatuses = Userstatus::pluck('displayName', 'id');
        $userStatuses->prepend("انتخاب وضعیت");
        $majors = Major::pluck('name', 'id');
        $genders = Gender::pluck('name', 'id');
        $permissions = Permission::pluck('display_name', 'id');
        $roles = Role::pluck('display_name', 'id');
//        $roles = array_add($roles , 0 , "همه نقش ها");
//        $roles = array_sort_recursive($roles);
        $limitStatus = [0 => 'نامحدود', 1 => 'محدود'];
        $enableStatus = [0 => 'غیرفعال', 1 => 'فعال'];

        $orderstatuses = Orderstatus::whereNotIn('id', [Config::get("constants.ORDER_STATUS_OPEN")])->pluck('displayName', 'id');

        $paymentstatuses = Paymentstatus::pluck('displayName', 'id');

        $hasOrder = [0 => 'همه کاربران', 1 => 'کسانی که سفارش ثبت کرده اند', 2 => 'کسانی که سفارش ثبت نکرده اند'];

        $bookProductsId = [176 , 167];
        $bookProducts = $this->makeProductCollection($bookProductsId);

        $products = $this->makeProductCollection();


        $lockProfileStatus = [0 => "پروفایل باز", 1 => "پروفایل قفل شده"];
        $mobileNumberVerification = [0 => "تایید نشده", 1 => "تایید شده"];

//        $tableDefaultColumns = ["نام" , "رشته"  , "موبایل"  ,"شهر" , "استان" , "وضعیت شماره موبایل" , "کد پستی" , "آدرس" , "مدرسه" , "وضعیت" , "زمان ثبت نام" , "زمان اصلاح" , "نقش های کاربر" , "تعداد بن" , "عملیات"];

        $sortBy = ["updated_at" => "تاریخ اصلاح", "created_at" => "تاریخ ثبت نام", "firstName" => "نام", "lastName" => "نام خانوادگی"];
        $sortType = ["desc" => "نزولی", "asc" => "صعودی"];
        $addressSpecialFilter = ["بدون فیلتر خاص", "بدون آدرس ها", "آدرس دارها"];

        $coupons = Coupon::pluck('name', 'id')->toArray();
        $coupons = array_sort_recursive($coupons);

        $lotteries = Lottery::pluck("displayName", 'id')->toArray();

        $pageName = "admin";



        $checkoutStatuses = Checkoutstatus::pluck('displayName', 'id')->toArray();
        $checkoutStatuses[0] = "نامشخص";
        $checkoutStatuses = array_sort_recursive($checkoutStatuses);

        return view("admin.indexGetReport", compact("pageName", "majors", "userStatuses", "permissions", "roles", "limitStatus", "orderstatuses", "paymentstatuses", "enableStatus", "genders", "hasOrder", "products",
            "bookProducts", "lockProfileStatus", "mobileNumberVerification", "sortBy", "sortType", "coupons", "addressSpecialFilter", "lotteries", "checkoutStatuses"));
    }

    /**
     * Admin panel for lotteries
     */
    public function adminLottery()
    {
        $lottery = Lottery::where("name", Config::get("constants.HAMAYESH_DEY_LOTTERY"))->get()->first();
        $userlotteries = $lottery->users->where("pivot.rank", ">", 0)->sortBy("pivot.rank");


        $pageName = "admin";
        return view("admin.indexLottery", compact("userlotteries", "pageName"));
    }

    /**
     * Admin panel for tele marketing
     */
    public function adminTeleMarketing(Request $request)
    {
        if($request->has("group-mobile"))
        {
            $marketingProducts = [210,211,212,213,214,215,216,217,218,219,220,221] ;
            $mobiles = $request->get("group-mobile");
            $mobileArray = [];
            foreach ($mobiles as $mobile)
            {
                array_push($mobileArray , $mobile["mobile"]);
            }
            $baseDataTime = Carbon::createFromTimeString("2018-05-03 00:00:00");
            $orders = Order::whereHas("user" , function ($q) use ($mobileArray , $baseDataTime){
                $q->whereIn("mobile" , $mobileArray) ;
            })->whereHas("orderproducts" , function ($q2) use($marketingProducts){
                $q2->whereIn("product_id" , $marketingProducts);
            })
            ->where("orderstatus_id" , Config::get("constants.ORDER_STATUS_CLOSED"))
            ->where("paymentstatus_id" ,  Config::get("constants.PAYMENT_STATUS_PAID"))
            ->where("completed_at" , ">=" , $baseDataTime)
            ->get();
            $orders->load("orderproducts");
        }
        return view("admin.indexTeleMarketing" , compact("orders" , "marketingProducts"));
    }

    /**
     * Send a custom SMS to the user
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function sendSMS(SendSMSRequest $request)
    {
        $from = $request->get("smsProviderNumber");
        $message = $request->get("message");
        $usersId = $request->get("users");
        $usersId = explode(',', $usersId);
        $relatives = $request->get("relatives");
        $relatives = explode(',', $relatives);

        $smsNumber = config('constants.SMS_PROVIDER_DEFAULT_NUMBER');
        $users = User::whereIn("id", $usersId)->get();
        if ($users->isEmpty())
            return $this->response->setStatusCode(451);

        if (!isset($from) || strlen($from) == 0)
            $from = $smsNumber;

        /**
         *  for customized message to every user

        foreach ($users as $user) {
        $customizedMessage = "";
        $mobiles = [];
        if (in_array(0, $relatives))
        array_push($mobiles, ltrim($user->mobile, '0'));
        if (in_array(1, $relatives)) {
        if (!$user->contacts->isEmpty()) {
        $fatherMobiles = $user->contacts->where("relative_id", 1)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
        if (!$fatherMobiles->isEmpty())
        foreach ($fatherMobiles as $fatherMobile) {
        array_push($mobiles, ltrim($fatherMobile->phoneNumber, '0'));
        }

        }
        }
        if (in_array(2, $relatives)) {
        if (!$user->contacts->isEmpty()) {
        $motherMobiles = $user->contacts->where("relative_id", 2)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
        if (!$motherMobiles->isEmpty())
        foreach ($motherMobiles as $motherMobile) {
        array_push($mobiles, ltrim($motherMobile->phoneNumber, '0'));
        }
        }
        }
        $smsInfo = array();
        $gender = "";
        if(isset($user->gender_id))
        {
        if($user->gender->name=="خانم")
        $gender = "خانم ";
        elseif($user->gender->name=="آقا")
        $gender = "آقای ";
        else
        $gender = "";
        }else{
        $gender = "";
        }
        $customizedMessage = "سلام ".$gender.$user->getfullName()."\n".$message;
        $smsInfo["message"] = $customizedMessage;
        $smsInfo["to"] = $mobiles;
        $smsInfo["from"] = "+985000145";
        $response = $this->medianaSendSMS($smsInfo);
        if (!$response["error"]) {

        } else {
        dump("SMS was not sent to user: ".$user->id) ;
        }
        }
        dd("done");


        /**
         *
         */

        $mobiles = [];
        foreach ($users as $user) {
            if (in_array(0, $relatives))
                array_push($mobiles, ltrim($user->mobile, '0'));
            if (in_array(1, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $fatherMobiles = $user->contacts->where("relative_id", 1)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
                    if (!$fatherMobiles->isEmpty())
                        foreach ($fatherMobiles as $fatherMobile) {
                            array_push($mobiles, ltrim($fatherMobile->phoneNumber, '0'));
                        }

                }
            }
            if (in_array(2, $relatives)) {
                if (!$user->contacts->isEmpty()) {
                    $motherMobiles = $user->contacts->where("relative_id", 2)->first()->phones->where("phonetype_id", 1)->sortBy("priority");
                    if (!$motherMobiles->isEmpty())
                        foreach ($motherMobiles as $motherMobile) {
                            array_push($mobiles, ltrim($motherMobile->phoneNumber, '0'));
                        }
                }
            }
        }
        $smsInfo = array();
        $smsInfo["message"] = $message;
        $smsInfo["to"] = $mobiles;
        $smsInfo["from"] = $from;
        $response = $this->medianaSendSMS($smsInfo);
        if (!$response["error"]) {
            $smsCredit = $this->medianaGetCredit();
            return $this->response->setContent($smsCredit)->setStatusCode(200);
        } else {
            return $this->response->setStatusCode(503);
        }
    }

    function download()
    {
        $fileName = Input::get('fileName');
        $contentType = Input::get('content');
        $user = Auth::user();
        switch ($contentType) {
            case "عکس پروفایل":
                $diskName = Config::get('constants.DISK1');
                break;
            case "عکس محصول":
                $diskName = Config::get('constants.DISK4');
                break;
            case "تمرین":
                // check if he has permission for downloading the assignment :

                //if(!Auth::user()->permissions->contains(Permission::all()->where("name", Config::get('constants.DOWNLOAD_ASSIGNMENT_ACCESS'))->first()->id)) return redirect(action(("HomeController@error403"))) ;
                //  checking permission through the user's role
                //$user->hasRole('goldenUser');
                $diskName = Config::get('constants.DISK2');
                break;
            case "پاسخ تمرین":
                $diskName = Config::get('constants.DISK3');
                break;
            case "کاتالوگ محصول":
                $diskName = Config::get('constants.DISK5');
                break;
            case "سؤال مشاوره ای":
                $diskName = Config::get('constants.DISK6');
                break;
            case "تامبنیل مشاوره":
                $diskName = Config::get('constants.DISK7');
                break;
            case "عکس مقاله" :
                $diskName = Config::get('constants.DISK8');
                break;
            case "عکس اسلاید صفحه اصلی" :
                $diskName = Config::get('constants.DISK9');
                break;
            case "فایل سفارش" :
                $diskName = Config::get('constants.DISK10');
                break;
            case "فایل محصول" :
                $productId = Input::get("pId");
                if (!$user->can(Config::get("constants.DOWNLOAD_PRODUCT_FILE"))) {
                    $products = Product::whereIn('id',
                        Product::whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('complimentaryproducts', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('gifts', function ($q) use ($fileName) {
                        $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                            $q->where("file", $fileName);
                        });
                    })->pluck("id")
                    )->OrwhereIn('id', Product::whereHas('parents', function ($q) use ($fileName) {
                        $q->whereHas('complimentaryproducts', function ($q) use ($fileName) {
                            $q->whereHas('validProductfiles', function ($q) use ($fileName) {
                                $q->where("file", $fileName);
                            });
                        });
                    })->pluck("id")
                    )
                        ->get();
                    $validOrders = $user->orders()->whereHas('orderproducts', function ($q) use ($products) {
                        $q->whereIn("product_id", $products->pluck("id"));
                    })->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED"), Config::get("constants.ORDER_STATUS_POSTED"), Config::get("constants.ORDER_STATUS_READY_TO_POST")])->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID")])->get();

                    if ($products->isEmpty()) {
                        $message = "چنین فایلی وجود ندارد ویا غیر فعال شده است";
                    } elseif ($validOrders->isEmpty()) {

                        $message = "شما ابتدا باید یکی از این محصولات را سفارش دهید و یا اگر سفارش داده اید مبلغ را تسویه نمایید: " . "<br>";
                        $productIds = array();
                        foreach ($products as $product) {
                            $myParents = $this->makeParentArray($product);
                            if (!empty($myParents)) {
                                $rootParent = end($myParents);
                                if (!in_array($rootParent->id, $productIds)) {
                                    $message .= "<a href='" . action('ProductController@show', $rootParent->id) . "'>" . $rootParent->name . "</a><br>";
                                    array_push($productIds, $rootParent->id);
                                }
                            } else {
                                if (!in_array($product->id, $productIds)) {
                                    $message .= "<a  href='" . action('ProductController@show', $product->id) . "'>" . $product->name . "</a><br>";
                                    array_push($productIds, $product->id);
                                }
                            }
                        }
                    }
//
                    if (isset($message) && strlen($message) > 0) {
                        return $this->errorPage($message);
                    }
                }
                $diskName = Config::get('constants.DISK13');
                $cloudFile = Productfile::where("file", $fileName)->where("product_id", $productId)->get()->first()->cloudFile;
                //TODO: verify "$productFileLink = "http://".env("SFTP_HOST" , "").":8090/". $cloudFile;"
                $productFileLink = config("constants.DOWNLOAD_HOST_PROTOCOL" , "https://").config('constants.DOWNLOAD_HOST_NAME'). $cloudFile;
                $unixTime = Carbon::today()->addDays(2)->timestamp;
                $userIP = request()->ip();
                //TODO: fix diffrent Ip
                $ipArray = explode(".",$userIP);
                $ipArray[3] = 0;
                $userIP = implode(".",$ipArray);

                $linkHash = $this->generateSecurePathHash($unixTime, $userIP, "TakhteKhak", $cloudFile);
                $externalLink = $productFileLink . "?md5=" . $linkHash . "&expires=" . $unixTime;
//                dd($temp."+".$userIP);
                break;
            case "فایل کارنامه" :
                $diskName = Config::get('constants.DISK14');
                break;
            case Config::get('constants.DISK18') :
                if (Storage::disk(Config::get('constants.DISK18_CLOUD'))->exists($fileName))
                    $diskName = Config::get('constants.DISK18_CLOUD');
                else
                    $diskName = Config::get('constants.DISK18');
                break;
            case Config::get('constants.DISK19'):
                if (Storage::disk(Config::get('constants.DISK19_CLOUD'))->exists($fileName))
                    $diskName = Config::  get('constants.DISK19_CLOUD');
                else
                    $diskName = Config::get('constants.DISK19');
                break;
            case Config::get('constants.DISK20'):
                if (Storage::disk(Config::get('constants.DISK20_CLOUD'))->exists($fileName))
                    $diskName = Config::  get('constants.DISK20_CLOUD');
                else
                    $diskName = Config::get('constants.DISK20');
                break;
            default :
                $file = \App\File::where("uuid", $fileName)->get();
                if ($file->isNotEmpty() && $file->count() == 1) {
                    $file = $file->first();
                    if($file->disks->isNotEmpty())
                    {
                        $diskName = $file->disks->first()->name;
                        $fileName = $file->name;
                    }
                    else
                    {
                        $externalLink = $file->name ;
                    }
                } else {
                    abort("404");
                }
        }
        if (isset($downloadPriority) && strcmp($downloadPriority, "cloudFirst") == 0)
        {
            if (isset($externalLink)) {
                return redirect($externalLink);
            } elseif (Storage::disk($diskName)->exists($fileName)) {
//            Other download method :  problem => it changes the file name to download
//            $file = Storage::disk($diskName)->get($fileName);
//            return (new Response($file, 200))
//                ->header('Content-Type', $contentMime)
//                ->header('Content-Disposition'  , 'attachment')
//                ->header('filename',$fileName);

//                $filePrefixPath =Storage::drive($diskName)->getAdapter()->getPathPrefix() ;
//                if(isset($filePrefixPath))
//                    return response()->download(Storage::drive($diskName)->path($fileName));
//                else
//                    return response()->download(Storage::drive($diskName)->getAdapter()->getRoot() . $fileName);

                $filePrefixPath = Storage::drive($diskName)->getAdapter()->getPathPrefix();
                if (isset($filePrefixPath)) {
                    $fs = Storage::disk($diskName)->getDriver();
                    $stream = $fs->readStream($fileName);
                    return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                        fpassthru($stream);
                    }, 200, [
                        "Content-Type" => $fs->getMimetype($fileName),
                        "Content-Length" => $fs->getSize($fileName),
                        "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                    ]);
                } else {
                    $fileHost = Storage::drive($diskName)->getAdapter()->getHost();
                    if (isset($fileHost)) {
                        $fileRoot = Storage::drive($diskName)->getAdapter()->getRoot();
                        //TODO: verify "$fileRemotePath = "http://" . $fileHost . ":8090" . "/public" . explode("public", $fileRoot)[1];"

                        $fileRemotePath = config("constants.DOWNLOAD_HOST_PROTOCOL" ). config("constants.DOWNLOAD_HOST_NAME" ). "/public" . explode("public", $fileRoot)[1];
                        return response()->redirectTo($fileRemotePath . $fileName);
                    } else {
                        $fs = Storage::disk($diskName)->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type" => $fs->getMimetype($fileName),
                            "Content-Length" => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                    }
                }

//
            }
        }
        else
        {
            if ( isset($diskName) && Storage::disk($diskName)->exists($fileName)) {
//            Other download method :  problem => it changes the file name to download
//            $file = Storage::disk($diskName)->get($fileName);
//            return (new Response($file, 200))
//                ->header('Content-Type', $contentMime)
//                ->header('Content-Disposition'  , 'attachment')
//                ->header('filename',$fileName);

//                $filePrefixPath =Storage::drive($diskName)->getAdapter()->getPathPrefix() ;
//                if(isset($filePrefixPath))
//                    return response()->download(Storage::drive($diskName)->path($fileName));
//                else
//                    return response()->download(Storage::drive($diskName)->getAdapter()->getRoot() . $fileName);
//
                $diskAdapter = Storage::disk($diskName)->getAdapter();
                $diskType = class_basename($diskAdapter);
                switch ($diskType) {
                    case "SftpAdapter" :
                        if (isset($file))
                        {
                            $url = $file->getUrl();
                            if (isset($url[0]))
                            {
                                return response()->redirectTo($url);
                            }
                            else
                            {
                                $fs = Storage::disk($diskName)->getDriver();
                                $stream = $fs->readStream($fileName);

                                return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                                    fpassthru($stream);
                                }, 200, [
                                    "Content-Type" => $fs->getMimetype($fileName),
                                    "Content-Length" => $fs->getSize($fileName),
                                    "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                                ]);
                            }
                        }

                        break;
                    case "Local" :
                        $fs = Storage::disk($diskName)->getDriver();
                        $stream = $fs->readStream($fileName);
                        return \Illuminate\Support\Facades\Response::stream(function () use ($stream) {
                            fpassthru($stream);
                        }, 200, [
                            "Content-Type" => $fs->getMimetype($fileName),
                            "Content-Length" => $fs->getSize($fileName),
                            "Content-disposition" => "attachment; filename=\"" . basename($fileName) . "\"",
                        ]);
                        break;
                    default:
                        break;
                }
            } elseif (isset($externalLink)) {
                return redirect($externalLink);
            }
        }
        abort(404);
    }

    public function getImage($category, $w, $h, $fileName)
    {
        switch ($category) {
            case "1";
                $diskName = Config::get('constants.DISK1');
                break;
            case "4":
                $diskName = Config::get('constants.DISK4');
                break;
            case "7":
                $diskName = Config::get('constants.DISK7');
                break;
            case "8":
                $diskName = Config::get('constants.DISK8');
                break;
            case "9":
                $diskName = Config::get('constants.DISK9');
                break;
            case "11":
                $diskName = Config::get('constants.DISK11');
                break;
            default:
                break;
        }
        if (Storage::disk($diskName)->exists($fileName)) {
            $file = Storage::disk($diskName)->get($fileName);
            $type = Storage::disk($diskName)->mimeType($fileName);
            $etag = md5($file);
            $lastModified = Storage::disk($diskName)->lastModified($fileName);
            $size = strlen($file);
            return response($file, 200)
                ->header('Content-Type', $type)
                ->header('Content-Length', $size)
                ->setMaxAge(3600)
                ->setPublic()
                ->setEtag($etag)
                ->setLastModified(Carbon::createFromTimestamp($lastModified));
        }
        return redirect(action("HomeController@error404"));
    }

    function aboutUs(Request $request)
    {
        $url = $request->url();
        $title ="آلاء|درباره ما";
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        return view("pages.aboutUs");
    }

    function contactUs(Request $request)
    {
        $url = $request->url();
        $title ="آلاء|تماس با ما";
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        $emergencyContacts = collect();
        foreach ($this->setting->branches->main->emergencyContacts as $emergencyContact)
        {
            $number = "";
            if(isset($emergencyContact->number)  && strlen($emergencyContact->number)>0) $number =$emergencyContact->number;

            $description = "";
            if(isset($emergencyContact->description) && strlen($emergencyContact->description)>0) $description =$emergencyContact->description;

            if(strlen($number)>0 || strlen($description)>0)
                $emergencyContacts->push(["number"=>$number , "description"=>$description]);
        }
        return view("pages.contactUs" , compact("emergencyContacts"));
    }

    function rules(Request $request)
    {
        $url = $request->url();
        $title ="آلاء|قوانین";
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        return view("pages.rules");
    }

    function siteMap(Request $request)
    {

        $url = $request->url();
        $title ='آلاء|نقشه سایت';
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);

        $products = Product::getProducts(0, 1)->orderBy("order")->get();
//        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
//        $articlesWithoutCategory = Article::where('articlecategory_id', null)->get();
        return view("pages.siteMap", compact('products', 'articlecategories', 'articlesWithoutCategory'));
    }

    function siteMapXML()
    {
        $products = Product::getProducts(0, 1)->orderBy("order")->get();
        foreach ($products as $product) {
            Sitemap::addTag(route('product.show', $product), $product->updated_at, 'daily', '0.8');
        }

//        $articlecategories = Articlecategory::where('enable', 1)->orderBy('order')->get();
//
//        foreach ($articlecategories as $articlecategory)
//        {
//            Sitemap::addTag(action('ArticleController@showList', ["categoryId"=>$articlecategory]), $articlecategory->updated_at, 'daily', '0.8');
//            foreach ($articlecategory->articles as $article)
//            {
//                Sitemap::addTag(route('article.show', $article), $article->updated_at, 'daily', '0.8');
//            }
//        }
//
//        $articlesWithoutCategory = Article::where('articlecategory_id' , null)->get();
//        foreach ($articlesWithoutCategory as $articleWithoutCategory)
//        {
//            Sitemap::addTag(route('article.show', $articleWithoutCategory), $articleWithoutCategory->updated_at, 'daily', '0.8');
//
//        }

//        Sitemap::addTag(action("HomeController@contactUs"), '', 'daily', '0.8');
//        Sitemap::addTag(action("HomeController@aboutUs"), '', 'daily', '0.8');
//        Sitemap::addTag(action("HomeController@certificates"), '', 'daily', '0.8');
        return Sitemap::render();
    }

    /**
     * Sends an email to the website's own email
     *
     * @param \app\Http\Requests\ContactUsFormRequest $request
     * @return \Illuminate\Http\Response
     */
    public function sendMail(ContactUsFormRequest $request)
    {

        $this->setting = Websitesetting::where("version", 1)->get()->first();
        $wSetting = json_decode($this->setting->setting);

//        try {
//            $sent = Mail::send('emailLayouts.contactUs',
//                array(
//                    'name' =>  $request->get('fullName'),
//                    'email' => $request->get('email'),
//                    'phone' =>  $request->get('phone'),
//                    'comment' => $request->get('message')
//                ), function($message) use ($request , $wSetting)
//                {
//                    if(isset($wSetting->branches->main->emails[0]->address)) $to = $wSetting->branches->main->emails[0]->address;
//                    else $to = "";
////                    $to = "mohamad.shahrokhi@gmail.com";
//                    $message->from('info@itecsgroup.com');
//                    $message->to($to, 'itecsgroup.com')->subject('تماس با ما');
//                    $email =$request->get("email");
//                    if(strlen($email)>0)  $message->replyTo($request->get('email'), $request->get('fullName'));
//                });
//
//            if($sent)
//            {
//                session()->flash('success', 'پیام با موفقیت ارسال شد');
//                return redirect()->back();
//            }else
//            {
//                session()->flash('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
//                return redirect()->back();
//            }
//        } catch ( \Exception    $error) {
//            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
//            return $this->errorPage($message) ;
//        }


        $email = $request->get('email');
        $name = $request->get('fullName');
        $phone = $request->get('phone');
        $comment = $request->get('message');

        //create a boundary for the email. This
        $boundary = uniqid('sh');

        // multiple recipients
//    $to  = 'info@sanatisharif.ir' . ', '; // note the comma
//    $to .= 'foratmail@gmail.com';

        if (isset($wSetting->branches->main->emails[0]->address)) $to = $wSetting->branches->main->emails[0]->address;
        else $to = "";
        // To send HTML mail, the Content-type header must be set
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"" . $boundary . "\"\r\n";//';charset=UTF-8' .
        $headers .= "From: " . strip_tags(config('constants.MAIL_USERNAME')) . "\r\n" .
            "Reply-To: " . strip_tags($email) . "\r\n" .
            "X-Mailer: PHP/" . phpversion();


        $orginaltext = $request->get('message');

        $orginaltext = str_replace('\"', '"', $orginaltext);
        $orginaltext = str_replace('\\\\', '\\', $orginaltext);

        $sender = '<p dir="rtl"> نام فرستنده: ' . $name . '</p>';
        if (strlen($email) > 0) $sender .= '<p dir="rtl"> ایمیل فرستنده: ' . $email . '</p>';
        if (strlen($phone) > 0) $sender .= '<p dir="rtl">  شماره تماس فرستنده: ' . $phone . '</p>';

        //plainText version
        $text = "\r\n\r\n--" . $boundary . "\r\n"; //header
        $text .= "Content-type: text/plain; charset=utf-8 \r\n\r\n"; //header

        $text .= strip_tags($orginaltext) . "\r\n" . strip_tags($sender);

        //htmlText version

        $text .= "\r\n\r\n--" . $boundary . "\r\n"; //header
        $text .= "Content-type: text/html; charset=utf-8 \r\n\r\n"; //header

//            $text .= $sender.str_replace('\"','\'','<p dir="rtl" style="text-align: right">'.$orginaltext.'</p>') ;
        $text .= view("emailLayouts.contactUs", compact("email", "phone", "comment", "name"));


        /*$text .='
        <html>
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                <title><h1>'.$subject.'</h1></title>
            </head>
            <body dir="rtl">
                '.$orginaltext.'\r\n'.$sender.'
            </body>
        </html>
            ';*/

        $text .= "\r\n\r\n--" . $boundary . "--";

        $subject = "آلاء - تماس با ما";

        try {
            $numSent = mail($to, $subject, $text, $headers);
            if ($numSent) {
                session()->put('success', 'پیام با موفقیت ارسال شد');
                return redirect()->back();
            } else {
                session()->put('error', 'خطا در ارسال پیام ، لطفا دوباره اقدام نمایید');
                return redirect()->back();
            }
        } catch (\Exception    $error) {
            $message = "با عرض پوزش مشکلی در ارسال پیام پیش آمده است . لطفا بعدا اقدام نمایید";
            return $this->errorPage($message);
        }


    }

    /**
     * Sends an email to the website's own email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function uploadFile(\Illuminate\Http\Request $request)
    {

        $filePath = $request->header("X-File-Name");
        $fileName = $request->header("X-Dataname");
        $filePrefix="";
        $contentId = $request->header("X-Dataid");
        $disk = $request->header("X-Datatype");
        $done = false;

        try {
            $dirname = pathinfo($filePath, PATHINFO_DIRNAME);
            $ext = pathinfo($fileName, PATHINFO_EXTENSION);
            $fileName = basename($fileName, "." . $ext) . "_" . date("YmdHis") . '.' . $ext;

            $newFileNameDir = $dirname . '/' . $fileName;

            if (File::exists($newFileNameDir)) {
                File::delete($newFileNameDir);
            }
            File::move($filePath, $newFileNameDir);

            if (strcmp($disk , "product") == 0) {
                if($ext == "mp4") $directory = "video";
                elseif($ext == "pdf") $directory = "pamphlet";
                $adapter = new SftpAdapter([
                    'host' => config('constants.SFTP_HOST'),
                    'port' =>config('constants.SFTP_PORT'),
                    'username' => config('constants.SFTP_USERNAME'),
                    'password' => config('constants.SFTP_PASSSWORD'),
                    'privateKey' => config('constants.SFTP_PRIVATE_KEY_PATH'),
                    'root' =>config('constants.SFTP_ROOT') . '/private/'.$contentId.'/',
                    'timeout' => config('constants.SFTP_TIMEOUT'),
                    'directoryPerm' => 0755
                ]);
                $filesystem = new Filesystem($adapter);
                if(isset($directory)){
                    if(!$filesystem->has($directory))
                    {
                        $filesystem->createDir($directory) ;
                    }

                    $filePrefix = $directory."/";
                    $filesystem = $filesystem->get($directory  );
                    $path = $filesystem->getPath();
                    $filesystem->setPath($path."/".$fileName);
                    if($filesystem->put(File::get($newFileNameDir))) $done = true;
                }else{
                    if($filesystem->put($fileName , File::get($newFileNameDir))) $done = true;
                }

            }else{
                $filesystem = Storage::disk($disk . "Sftp");
                if($filesystem->put($fileName, fopen($newFileNameDir, 'r+'))) {
                    $done = true;
//                    dd($done);
                }

            }
            if($done)
                return $this->response->setStatusCode(200)->setContent(["fileName"=>$fileName , "prefix"=>$filePrefix]);
            else
                return $this->response->setStatusCode(503);
        } catch (\Exception $e) {
            //            return $this->TAG.' '.$e->getMessage();
            return $this->response->setStatusCode(503)->setContent(["message"=>"خطای غیرمنتظره در آپلود فایل"]);
        }
    }

    public function smsBot()
    {
        abort("403");
        /**
        $lottery = Lottery::where("name", Config::get("constants.HAMAYESH_DEY_LOTTERY"))->get()->first();
        $userlotteries = $lottery->users->where("pivot.rank", ">", 0)->sortBy("pivot.rank");

        $counter = 0;
        foreach ($userlotteries as $userlottery) {
        $counter++;
        $smsInfo = array();
        $smsInfo["to"] = array(ltrim($userlottery->mobile, '0'));
        $smsInfo["from"] = config("constants.SMS_PROVIDER_DEFAULT_NUMBER");
        //
        //            $prize = json_decode($userlottery->pivot->prizes)->items[0]->name ;
        $smsInfo["message"] = "سلام ، کاربر گرامی نتیجه قرعه کشی در پروفایل شما قرار داده شد - آلاء";
        $response = $this->medianaSendSMS($smsInfo);
        dump($response);

        }
        dd($counter);
         */
    }
//    public function certificates()
//    {
//        return view("pages.certificates");
//    }

    public function bot()
    {
        /**
         * Fixing contentset tags

        if(Input::has("id"))
            $contentsetId = Input::get("id");
        else
            dd("Wring inputs, Please pass id as input");

        if(!is_array($contentsetId))
            dd("The id input must be an array!");
        $contentsets = Contentset::whereIn("id" , $contentsetId)->get();
        dump("number of contentsets:".$contentsets->count());
        $contentCounter = 0;
        foreach ($contentsets as $contentset)
        {
            $baseTime = Carbon::createFromDate("2017" , "06" , "01" , "Asia/Tehran");
            $contents = $contentset->educationalcontents->sortBy("pivot.order");
            $contentCounter += $contents->count();
            foreach ($contents as $content)
            {
                $content->created_at = $baseTime;
                if($content->update())
                {
                    if(isset($content->tags))
                    {
                        $params = [
                            "tags"=> json_encode($content->tags->tags) ,
                        ];
                        if(isset($content->created_at) && strlen($content->created_at) > 0 )
                            $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $content->created_at )->timestamp;

                        $response =  $this->sendRequest(
                            config("constants.AG_API_URL")."id/content/".$content->id ,
                            "PUT",
                            $params
                        );

                        if($response["statusCode"] == 200)
                        {
                        }
                        else
                        {
                            dump("tag request for content id ".$content->id." failed. response : ".$response["statusCode"]);
                        }
                    }
                    else
                    {
                        dump("content id ".$content->id."did not have ant tags!");
                    }
                }
                 else
                 {
                     dump("content id ".$content->id." was not updated");
                 }
                $baseTime = $baseTime->addDay();
            }

        }
        dump("number of total processed contents: ".$contentCounter);
        dd("done!");
         */

        /***
        $contents = Educationalcontent::where("contenttype_id" , 8);
        $contentArray = $contents->pluck("id")->toArray();
        $sanatishRecords = Sanatisharifmerge::whereIn("educationalcontent_id" , $contentArray)->get();
        $contents = $contents->get();
        $successCounter = 0 ;
        $failedCounter = 0 ;
        dump("number of contents: ".$contents->count());
        foreach ($contents as $content)
        {
        $myRecord =  $sanatishRecords->where("educationalcontent_id" , $content->id)->first();
        if(isset($myRecord))
        if(isset($myRecord->videoEnable))
        {
        if($myRecord->isEnable)
        $content->enable = 1;
        else
        $content->enable = 0 ;
        if($content->update())
        $successCounter++;
        else
        $failedCounter++;
        }


        }
        dump("success counter: ".$successCounter);
        dump("fail counter: ".$failedCounter);

        dd("finish");
         */

        /**
        $contents =  Educationalcontent::where("id" , "<" , 158)->get();
        dump("number of contents: ".$contents->count());
        $successCounter= 0 ;
        $failedCounter = 0;
        foreach ($contents as $content)
        {
            $contenttype = $content->contenttypes()->whereDoesntHave("parents")->get()->first();
            $content->contenttype_id = $contenttype->id ;
            if($content->update())
            {
                $successCounter++;
            }
            else
            {
                $failedCounter++;
                dump("content for ".$content->id." was not saved.") ;
            }
        }
        dump("successful : ".$successCounter);
        dump("failed: ".$failedCounter) ;
        dd("finish");
        **/
        /**
         * Giving gift to users

        $carbon = new Carbon("2018-02-20 00:00:00");
        $orderproducts = Orderproduct::whereIn("product_id" ,[ 100] )->whereHas("order" , function ($q) use ($carbon)
        {
        //           $q->where("orderstatus_id" , 1)->where("created_at" ,">" , $carbon);
        $q->where("orderstatus_id" , 2)->whereIn("paymentstatus_id" , [2,3])->where("completed_at" ,">" , $carbon);
        })->get();
        dump("تعداد سفارش ها" . $orderproducts->count());
        $users = array();
        $counter = 0;
        foreach ($orderproducts as $orderproduct)
        {
        $order = $orderproduct->order;
        if($order->orderproducts->where("product_id" , 107)->isNotEmpty()) continue ;

        $giftOrderproduct = new Orderproduct();
        $giftOrderproduct->orderproducttype_id = Config::get("constants.ORDER_PRODUCT_GIFT");
        $giftOrderproduct->order_id = $order->id ;
        $giftOrderproduct->product_id = 107 ;
        $giftOrderproduct->cost = 24000 ;
        $giftOrderproduct->discountPercentage = 100 ;
        $giftOrderproduct->save() ;

        $giftOrderproduct->parents()->attach($orderproduct->id , ["relationtype_id"=>Config::get("constants.ORDER_PRODUCT_INTERRELATION_PARENT_CHILD")]);
        $counter++;
        if(isset($order->user->id))
        array_push($users , $order->user->id);
        else
        array_push($users , 0);
        }
        dump($counter." done");
        dd($users);
         */
        /**
         *  Converting Hamayesh with Poshtibani to without poshtibani
        if (!Auth::user()->hasRole("admin")) abort(404);

        $productsArray = [164, 160, 156, 152, 148, 144, 140, 136, 132, 128, 124, 120];
        $orders = Order::whereHas("orderproducts", function ($q) use ($productsArray) {
        $q->whereIn("product_id", $productsArray);
        })->whereIn("orderstatus_id", [Config::get("constants.ORDER_STATUS_CLOSED"), Config::set("constants.ORDER_STATUS_POSTED")])->whereIn("paymentstatus_id", [Config::get("constants.PAYMENT_STATUS_PAID"), Config::get("constants.PAYMENT_STATUS_INDEBTED")])->get();


        dump("Number of orders: ".$orders->count());
        $counter = 0;
        foreach ($orders as $order)
        {
        if($order->successfulTransactions->isEmpty()) continue ;
        $totalRefund = 0;
        foreach ($order->orderproducts->whereIn("product_id", $productsArray) as $orderproduct)
        {
        $orderproductTotalRefund = 0 ;
        $orderproductRefund = (int)((($orderproduct->cost / 88000) * 9000))  ;
        $orderproductRefundWithBon = $orderproductRefund * (1 - ($orderproduct->getTotalBonNumber() / 100)) ;
        if($order->couponDiscount>0 && $orderproduct->includedInCoupon)
        $orderproductTotalRefund += $orderproductRefundWithBon * (1 - ($order->couponDiscount / 100)) ;
        else
        $orderproductTotalRefund += $orderproductRefundWithBon ;

        $totalRefund += $orderproductTotalRefund ;
        $orderproduct->cost = $orderproduct->cost - $orderproductRefund ;
        switch ($orderproduct->product_id)
        {
        case 164:
        $orderproduct->product_id = 165 ;
        break;
        case 160:
        $orderproduct->product_id = 161 ;
        break;
        case 156:
        $orderproduct->product_id = 157 ;
        break;
        case 152:
        $orderproduct->product_id = 153 ;
        break;
        case 148:
        $orderproduct->product_id = 149 ;
        break;
        case 144:
        $orderproduct->product_id = 145 ;
        break;
        case 140:
        $orderproduct->product_id = 141 ;
        break;
        case 136:
        $orderproduct->product_id = 137 ;
        break;
        case 132:
        $orderproduct->product_id = 133 ;
        break;
        case 128:
        $orderproduct->product_id = 129 ;
        break;
        case 124:
        $orderproduct->product_id = 125 ;
        break;
        case 120:
        $orderproduct->product_id = 121 ;
        break;
        default:
        break;
        }
        if(!$orderproduct->update()) dump("orderproduct ".$orderproduct->id." wasn't saved");
        }
        $newOrder = Order::where("id" , $order->id)->get()->first();
        $orderCostArray = $newOrder->obtainOrderCost(true , false , "REOBTAIN");
        $newOrder->cost = $orderCostArray["rawCostWithDiscount"] ;
        $newOrder->costwithoutcoupon = $orderCostArray["rawCostWithoutDiscount"];
        $newOrder->update();

        if($totalRefund > 0 )
        {
        $transactionRequest =  new \App\Http\Requests\InsertTransactionRequest();
        $transactionRequest->offsetSet("comesFromAdmin" , true);
        $transactionRequest->offsetSet("order_id" , $order->id);
        $transactionRequest->offsetSet("cost" , -$totalRefund);
        $transactionRequest->offsetSet("managerComment" , "ثبت سیستمی بازگشت هزینه پشتیبانی همایش 1+5");
        $transactionRequest->offsetSet("destinationBankAccount_id" , 1);
        $transactionRequest->offsetSet("paymentmethod_id" , Config::get("constants.PAYMENT_METHOD_ATM"));
        $transactionRequest->offsetSet("transactionstatus_id" ,  Config::get("constants.TRANSACTION_STATUS_SUCCESSFUL"));
        $transactionController = new TransactionController();
        $transactionController->store($transactionRequest);

        if(session()->has("success")) {
        session()->forget("success");
        }elseif(session()->has("error")){
        dump("Transaction wasn't saved ,Order: ".$order->id);
        session()->forget("error");
        }
        $counter++;
        }
        }
        dump("Processed: ".$counter) ;
         */
        /**
         *  Fixing complementary products
         *
        $products = \App\Product::all();
        $counter = 0 ;
        foreach ($products as $product)
        {
        $orders = \App\Order::whereHas("orderproducts" , function ($q2) use ($product){
        $q2->where("product_id" , $product->id)->whereNull("orderproducttype_id");
        })->whereIn("orderstatus_id" , [Config::get("constants.ORDER_STATUS_CLOSED") , Config::get("constants.ORDER_STATUS_POSTED") , Config::get("constants.ORDER_STATUS_READY_TO_POST")])
        ->whereIn("paymentstatus_id" , [Config::get("constants.PAYMENT_STATUS_INDEBTED") , Config::get("constants.PAYMENT_STATUS_PAID")])->get();

        dump("Number of orders: ".$orders->count());
        foreach ($orders as $order)
        {
        if ($product->hasGifts())
        {
        foreach ($product->gifts as $gift)
        {
        if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
        {
        $orderproduct = new \App\Orderproduct();
        $orderproduct->orderproducttype_id = 2;
        $orderproduct->order_id = $order->id;
        $orderproduct->product_id = $gift->id;
        $orderproduct->cost = $gift->basePrice;
        $orderproduct->discountPercentage = 100;
        if ($orderproduct->save()) $counter++;
        else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
        }
        }
        }
        //$parentsArray = $product->parents;
        $parentsArray = $this->makeParentArray($product);
        if (!empty($parentsArray)) {
        foreach ($parentsArray as $parent) {
        foreach ($parent->gifts as $gift) {
        if($order->orderproducts->where("product_id" , $gift->id)->isEmpty())
        {
        $orderproduct = new \App\Orderproduct();
        $orderproduct->orderproducttype_id = 2;
        $orderproduct->order_id = $order->id;
        $orderproduct->product_id = $gift->id;
        $orderproduct->cost = $gift->basePrice;
        $orderproduct->discountPercentage = 100;
        if ($orderproduct->save()) $counter++;
        else dump("orderproduct was not saved! order: " . $order->id . " ,product: " . $gift->id);
        }
        }
        }
        }
        }
        }
        dump("Number of processed : ".$counter);
        dd("finish");
         * */
    }

    public function checkDisableContentTagBot()
    {
        $disableContents = Educationalcontent::where("enable" , 0)->get();
        $counter = 0;
        foreach ($disableContents as $content)
        {
            $tags = $content->retrievingTags();
            if(!empty($tags))
            {
                $author = "";
                if(isset($content->author_id))
                    $author = $content->user->lastName;
                dump($content->id." has tags! type: ".$content->contenttype_id." author: ".$author);
                $counter++;
            }
        }
        dump("count: ".$counter);
        dd("finish");
    }

    public function tagBot()
    {
        $counter = 0;
        try{
            dump( "start time:". Carbon::now("asia/tehran"));
            if(!Input::has("t"))    return $this->response->setStatusCode(422)->setContent(["message"=>"Wrong inputs: Please pass parameter t. Available values: v , p , cs , pr , e , b ,a"]);
            $type = Input::get("t");
            switch($type)
            {
                case "v": //Video
                    $bucket = "content";
                    $items = Educationalcontent::where("contenttype_id" , 8)->where("enable" , 1);
                    if(Input::has("id"))
                    {
                        $contentId = Input::get("id");
                        $items->where("id" , $contentId);
                    }
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "فیلم"
                        ];
                        $majors = $item->majors->pluck("description")->toArray() ;
                        if(!empty($majors))
                            $myTags = array_merge($myTags ,  $majors);
                        $grades = $item->grades->where("name" , "graduated")->pluck("description")->toArray() ;
                        if(!empty($grades))
                            $myTags = array_merge($myTags , $grades );
                        switch ($item->id)
                        {
                            case 130:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                    "میلاد_ناصح_زاده"
                                ] );
                                break;
                            case 131:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ]);
                                break;
                            case 144:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ]);
                                break;
                            case 145:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 156:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 157:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 158:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 159:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 160:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 161:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 162:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 163:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 164:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            case 165:
                                $myTags = array_merge($myTags , [
                                    "عربی" ,
                                    "ضبط_استودیویی",
                                    "جمع_بندی",
                                    "میلاد_ناصح_زاده",
                                    "پیش",
                                    "پایه",
                                    "نظام_آموزشی_قدیم" ,
                                    "نظام_آموزشی_جدید" ,
                                ] );
                                break;
                            default :
                                break;
                        }
                        $myTags = array_merge($myTags ,["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                case "p": //Pamphlet
                    $bucket = "content";
                    $items = Educationalcontent::where("contenttype_id" , 1)->where("enable" , 1);
                    if(Input::has("id"))
                    {
                        $contentId = Input::get("id");
                        $items->where("id" , $contentId);
                    }
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "جزوه" ,
                            "PDF"
                        ];
                        $majors = $item->majors->pluck("description")->toArray() ;
                        if(!empty($majors))
                            $myTags = array_merge($myTags ,  $majors);
                        $grades = $item->grades->where("name" , "graduated")->pluck("description")->toArray() ;
                        if(!empty($grades))
                            $myTags = array_merge($myTags , $grades );
                        switch ($item->id)
                        {
                            case 115:
                                $myTags = array_merge($myTags , [
                                    "گسسته",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 112:
                                $myTags = array_merge($myTags , [
                                    "تحلیلی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 126:
                            case 114:
                            case 127:
                                $myTags = array_merge($myTags , [
                                    "آمار_و_مدلسازی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 133:
                                $myTags = array_merge($myTags , [
                                    "پیش",
                                ]);
                                break;
                            case 136:
                                $myTags = array_merge($myTags , [
                                    "فیزیک",
                                    "پیش",
                                    "همایش",
                                    "نظام_آموزشی_قدیم" ,
                                ] );
                                break;
                            case 119:
                            case 128:
                            case 129:
                            case 143:
                            case 146:
                                $myTags = array_merge($myTags , [
                                    "عربی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ] );
                                break;
                            case 120:
                                $myTags = array_merge($myTags , [
                                    "زیست_شناسی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 121:
                                $myTags = array_merge($myTags , [
                                    "زیست_شناسی",
                                    "پایه",
                                    "نظام_آموزشی_جدید" ,
                                ]);
                                break;
                            case 122:
                                $myTags = array_merge($myTags , [
                                    "زبان_و_ادبیات_فارسی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 123:
                            case 124:
                            case 125:
                            case 2:
                            case 3:
                            case 55:
                            case 56:
                            case 57:
                            case 58:
                            case 59:
                            case 60:
                            case 61:
                            case 62:
                            case 63:
                            case 64:
                            case 65:
                            case 66:
                            case 67:
                            case 137:
                            case 147:
                            case 148:
                            case 149:
                            case 150:
                            case 151:
                            case 152:
                            case 153:
                            case 154:
                            case 155:
                                $myTags = array_merge($myTags , [
                                    "شیمی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ] );
                                break;
                            default :
                                break;
                        }
                        $myTags = array_merge($myTags ,["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                case "b": //Book
                    $bucket = "content";
                    $items = Educationalcontent::where("contenttype_id" , 7)->where("enable" , 1);
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "کتاب_درسی",
                            "PDF" ,
                            "پایه" ,
                            "نظام_آموزشی_جدید" ,
                        ];
                        $majors = $item->majors->pluck("description")->toArray() ;
                        if(!empty($majors))
                            $myTags = array_merge($myTags ,  $majors);
                        $grades = $item->grades->where("name" , "graduated")->pluck("description")->toArray() ;
                        if(!empty($grades))
                            $myTags = array_merge($myTags , $grades );
                        $myTags = array_merge($myTags ,["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                case "e": //Exam
                    $bucket = "content";
                    $items = Educationalcontent::where("contenttype_id" , 2)->where("enable" , 1);
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "آزمون",
                            "PDF"
                        ];
                        $childContentTypes = Contenttype::whereHas("parents" , function ($q) {
                            $q->where("name" , "exam") ;
                        })->pluck("description")->toArray() ;
                        $myTags = array_merge($myTags , $childContentTypes );

                        $majors = $item->majors->pluck("description")->toArray() ;
                        if(!empty($majors))
                            $myTags = array_merge($myTags ,  $majors);
                        $grades = $item->grades->where("name" , "graduated")->pluck("description")->toArray() ;
                        if(!empty($grades))
                            $myTags = array_merge($myTags , $grades );

                        switch ($item->id)
                        {
                            case 141:
                            case 142:
                                $myTags = array_merge($myTags , [
                                    "عربی",
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                            case 116:
                            case 16:
                            case 17:
                            case 18:
                            case 13:
                            case 14:
                            case 15:
                                $myTags = array_merge($myTags , [
                                    "پایه",
                                    "نظام_آموزشی_جدید" ,
                                ]);
                                break;
                            default:
                                $myTags = array_merge($myTags , [
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                ]);
                                break;
                        }

                        $myTags = array_merge($myTags ,["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                case "a": //Article
                    $bucket = "content";
                    $items = Educationalcontent::where("contenttype_id" , 9)->where("enable" , 1);
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "مقاله"
                        ];
                        $majors = $item->majors->pluck("description")->toArray() ;
                        if(!empty($majors))
                            $myTags = array_merge($myTags ,  $majors);
                        $grades = $item->grades->where("name" , "graduated")->pluck("description")->toArray() ;
                        if(!empty($grades))
                            $myTags = array_merge($myTags , $grades );
                        switch ($item->id)
                        {
                            case 132:
                                $myTags = array_merge($myTags , [
                                    "پیش",
                                    "نظام_آموزشی_قدیم" ,
                                    "مشاوره",
                                    "مهدی_ناصر_شریعت"
                                ]);
                                break;
                            default :
                                break;
                        }

                        $myTags = array_merge($myTags ,["متوسطه2"]);
                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                case "cs": //Contentset
                    $bucket = "contentset";
                    $items = Contentset::orderBy("id")->where("enable" , 1);
                    if(Input::has("id"))
                    {
                        $id = Input::get("id");
                        $items = $items->where("id" , $id);
                    }
                    $items = $items->get();

                    break;
                case "pr": //Product
                    $bucket = "product";
                    if(Input::has("id"))
                    {
                        $id = Input::get("id");
                        $productIds = [$id];
                    }else
                    {
                        $productIds = [99 , 104 , 92 , 91 , 181 , 107 , 69 , 65 , 61 , 163 , 135 , 131 , 139 , 143 , 147 , 155 , 119 , 123 , 183
                            ,210 , 211 , 212 , 213 , 214 , 215 , 216 , 217 , 218 , 219 ,220 ,221];
                    }
                    $items = Product::whereIn("id" , $productIds) ;
                    $items = $items->get();
                    foreach ($items->where("tags" , null) as $item)
                    {
                        $myTags = [
                            "محصول" ,
                            "نظام_آموزشی_قدیم",
                            "پیش"
                        ];
                        switch ($item->id)
                        {
                            case 99:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "شیمی" , 'مهدی_صنیعی_طهرانی'  ]);
                                break;
                            case 104:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  , "رشته_انسانی" ,"کنکور" , "دین_و_زندگی" , 'جعفر_رنجبرزاده' ]);
                                break;
                            case 92:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "فیزیک" , 'پیمان_طلوعی' ]);
                                break;
                            case 91:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "شیمی" , 'مهدی_صنیعی_طهرانی' ]);
                                break;
                            case 181:
                                $myTags = [ "محصول", "رشته_تجربی" ,"دهم" , "نظام_آموزشی_جدید" , "پایه" , "زیست_شناسی" , 'جلال_موقاری' ];
                                break;
                            case 107:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "شیمی" , 'مهدی_صنیعی_طهرانی' ]);
                                break;
                            case 69:
                                $myTags = array_merge($myTags , ["رشته_تجربی"   ,"کنکور" , "زیست_شناسی" , 'محمد_پازوکی' ]);
                                break;
                            case 65:
                                $myTags = array_merge($myTags , ["رشته_تجربی"   ,"کنکور" , "ریاضی_تجربی" , 'رضا_شامیزاده' ]);
                                break;
                            case 61:
                                $myTags = array_merge($myTags , ["رشته_ریاضی"   ,"کنکور" , "دیفرانسیل" , 'محمد_صادق_ثابتی' ]);
                                break;
                            case 163:
                                $myTags = array_merge($myTags , ["رشته_ریاضی"   ,"کنکور" , "گسسته" , 'بهمن_مؤذنی_پور' ]);
                                break;
                            case 135:
                                $myTags = array_merge($myTags , ["رشته_تجربی"   ,"کنکور" , "ریاضی_تجربی" , 'محمدامین_نباخته' ]);
                                break;
                            case 131:
                                $myTags = array_merge($myTags , ["رشته_تجربی"   ,"کنکور" , "ریاضی_تجربی" , 'مهدی_امینی_راد' ]);
                                break;
                            case 139:
                                $myTags = array_merge($myTags , ["رشته_تجربی"   ,"کنکور" , "زیست_شناسی" , 'ابوالفضل_جعفری' ]);
                                break;
                            case 143:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "شیمی" , 'مهدی_صنیعی_طهرانی' ]);
                                break;
                            case 147:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  , "رشته_انسانی" ,"کنکور" , "عربی" , 'محسن_آهویی' ]);
                                break;
                            case 155:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی"  ,"کنکور" , "فیزیک" , 'پیمان_طلوعی' ]);
                                break;
                            case 119:
                                $myTags = array_merge($myTags , ["رشته_ریاضی"   ,"کنکور" , "تحلیلی" , 'محمد_صادق_ثابتی' ]);
                                break;
                            case 123:
                                $myTags = array_merge($myTags , ["رشته_ریاضی"   ,"کنکور" , "دیفرانسیل" , 'محمد_صادق_ثابتی' ]);
                                break;
                            case 183:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "عربی" , 'میلاد_ناصح_زاده' ]);
                                break;
                            case 210:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "ادبیات_و_زبان_فارسی" , 'هامون_سبطی' ]);
                                break;
                            case 211:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "دین_و_زندگی" , 'وحیده_کاعذی' ]);
                                break;
                            case 212:
                                $myTags = array_merge($myTags , [ "رشته_تجربی"  ,"کنکور" , "همایش_طلایی" , "زیست_شناسی" , 'محمد_چلاجور' ]);
                                break;
                            case 213:
                                $myTags = array_merge($myTags , ["رشته_تجربی"  ,"کنکور" , "همایش_طلایی" , "زمین_شناسی" , 'محمد_چلاجور' ]);
                                break;
                            case 214:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "عربی" , 'میلاد_ناصح_زاده' ]);
                                break;
                            case 215:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "عربی" , 'محسن_آهویی' ]);
                                break;
                            case 216:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "فیزیک" , 'پیمان_طلوعی' ]);
                                break;
                            case 217:
                                $myTags = array_merge($myTags , ["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ,"کنکور" , "همایش_طلایی" , "شیمی" , 'مهدی_صنیعی_طهرانی' ]);
                                break;
                            case 218:
                                $myTags = array_merge($myTags , ["رشته_ریاضی"  ,"کنکور" , "همایش_طلایی" , "دیفرانسیل" , 'محمد_صادق_ثابتی' ]);
                                break;
                            case 219:
                                $myTags = array_merge($myTags , [ "رشته_تجربی"  ,"کنکور" , "همایش_طلایی" , "ریاضی_تجربی" , 'مهدی_امینی_راد' ]);
                                break;
                            case 220:
                                $myTags = array_merge($myTags , [ "رشته_تجربی"  ,"کنکور" , "همایش_طلایی" , "ریاضی_تجربی" , 'محمد_امین_نباخته' ]);
                                break;
                            case 221:
                                $myTags = array_merge($myTags , [ "رشته_تجربی"  ,"کنکور" , "همایش_طلایی" , "زیست_شناسی" , 'آل_علی' ]);
                                break;
                            default:
                                break;
                        }
                        $myTags = array_merge($myTags ,["متوسطه2"]);

                        $tagsJson = [
                            "bucket" => $bucket,
                            "tags" => $myTags
                        ];
                        $item->tags = json_encode($tagsJson);
                        $item->update();
                    }
                    break;
                default:
                    return $this->response->setStatusCode(422)->setContent(["message"=>"Unprocessable input t."]);
                    break;
            }
            dump("available items: ".$items->count());
            $successCounter = 0 ;
            $failedCounter = 0 ;
            $warningCounter = 0 ;
            foreach ($items as $item)
            {
                if(!isset($item))
                {
                    $warningCounter++;
                    dump("invalid item at counter".$counter);
                    continue ;
                }
                else
                {
                    if(!isset($item->tags))
                    {
                        $warningCounter++;
                        dump("no tags found for".$item->id);
                        continue ;
                    }
                    else
                    {
                        $itemTagsArray = $item->tags->tags;
                    }
                }

                if(is_array($itemTagsArray) && !empty($itemTagsArray) && isset($item["id"]))
                {
                    $params = [
                        "tags"=> json_encode($itemTagsArray) ,
                    ];
                    if(isset($item->created_at) && strlen($item->created_at) > 0 )
                        $params["score"] = Carbon::createFromFormat("Y-m-d H:i:s" , $item->created_at )->timestamp;

                    $response =  $this->sendRequest(
                        config("constants.TAG_API_URL")."id/$bucket/".$item->id ,
                        "PUT",
                        $params
                    );

                    if($response["statusCode"] == 200)
                    {
                        $successCounter++;
                    }
                    else
                    {
                        dump("item #".$item["id"]." failed. response : ".$response["statusCode"]);
                        $failedCounter++;
                    }
                    $counter++;
                }elseif(is_array($itemTagsArray) && empty($itemTagsArray))
                {
                    $warningCounter++;
                    dump("warning no tags found for item #".$item->id);
                }
            }
            dump($successCounter." items successfully done");
            dump($failedCounter." items failed");
            dump($warningCounter." warnings");
            dump( "finish time:". Carbon::now("asia/tehran"));
            return $this->response->setStatusCode(200)->setContent(["message"=>"Done! number of processed items : ".$counter]);
        }
        catch(\Exception $e)
        {
            $message = "unexpected error";
            dump($successCounter." items successfully done");
            dump($failedCounter." items failed");
            dump($warningCounter." warnings");
            return $this->response->setStatusCode(503)->setContent(["message" => $message,"number of successfully processed items"=>$counter, "error" => $e->getMessage(), "line" => $e->getLine()]);
        }
    }

    /**
     * Showing create form for user's kunkoor result
     *
     * @return \Illuminate\Http\Response
     */
    public function submitKonkurResult()
    {

        $majors = Major::where("majortype_id" ,1)->get()->pluck("name" , "id")->toArray();
        $majors = array_add($majors , 0 , "انتخاب رشته");
        $majors = array_sort_recursive($majors);
        $event = Event::all()->first();
        $sideBarMode = "closed";

        $userEventReport = Eventresult::where("user_id" ,Auth::user()->id)->where("event_id" , $event->id)->get()->first();

        $pageName = "submitKonkurResult";
        $user = Auth::user();
        $userCompletion = (int)$user->completion();
        return view("user.submitEventResultReport" , compact("majors" , "event" , "sideBarMode" , "userEventReport" , "pageName"  , "user" , "userCompletion"));
    }

    public function schoolRegisterLanding(Request $request)
    {
        $eventRegistered = false;
        if(Auth::check())
        {
            $user = Auth::user();
            $event = Event::where("name" , "sabtename_sharif_97")->get();
            if($event->isEmpty())
            {
                dd("ثبت نام آغاز نشده است");
            }
            else
            {
                $event = $event->first() ;
                $events = $user->eventresults->where("user_id" , $user->id)->where("event_id" , $event->id) ;
                $eventRegistered = $events->isNotEmpty();
                if($eventRegistered)
                {
                    $score = $events->first()->participationCodeHash;
                }
                if(isset($user->firstName) && strlen(preg_replace('/\s+/', '', $user->firstName )) > 0 )
                    $firstName = $user->firstName;
                if(isset($user->lastName) && strlen(preg_replace('/\s+/', '', $user->lastName )) > 0 )
                    $lastName = $user->lastName;
                if(isset($user->mobile) && strlen(preg_replace('/\s+/', '', $user->mobile )) > 0 )
                    $mobile = $user->mobile;
                if(isset($user->nationalCode) && strlen(preg_replace('/\s+/', '', $user->nationalCode )) > 0 )
                    $nationalCode = $user->nationalCode;
                $major = $user->major_id;
                $grade = $user->grade_id;

            }

        }
        $url = $request->url();
        $title = $this->setting->site->seo->homepage->metaTitle;
        SEO::setTitle($title);
        SEO::opengraph()->setUrl($url);
        SEO::setCanonical($url);
        SEO::twitter()->setSite("آلاء");
        SEO::setDescription($this->setting->site->seo->homepage->metaDescription);
        SEO::opengraph()->addImage(route('image', ['category'=>'11','w'=>'100' , 'h'=>'100' ,  'filename' =>  $this->setting->site->siteLogo ]), ['height' => 100, 'width' => 100]);
        $pageName = "schoolRegisterLanding";
        return view("pages.schoolRegister" , compact( "pageName", "user" , "major" , "grade" , "firstName" , "lastName" ,
            "mobile" , "nationalCode" , "score" , "eventRegistered"));
    }

}
