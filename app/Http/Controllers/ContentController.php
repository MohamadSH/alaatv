<?php

namespace App\Http\Controllers;

use App\Classes\SEO\SeoMetaTagsGenerator;
use App\Contentset;
use App\Contenttype;
use App\Content;
use App\Grade;
use App\Major;
use App\Product;
use App\User;
use App\Http\Requests\{
    EditContentRequest, InsertContentRequest, Request
};
use App\Traits\{
    APIRequestCommon, FileCommon, Helper, ProductCommon, UserSeenTrait
};

use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\{
    Config, Input, View
};
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;


class ContentController extends Controller
{

    protected $response ;
    protected $setting ;

    use ProductCommon ;
    use Helper;
    use FileCommon ;
    use UserSeenTrait;
    use APIRequestCommon;

    private function getAuthExceptionArray(Agent $agent): array
    {
        if ($agent->isRobot())
        {
            $authException = ["index" , "show" , "search" ,"embed" ];
        }else{
            $authException = ["index" ,"search"  ];
        }
        //TODO:// preview(Telegram)
        $authException = ["index" , "show" , "search" ,"embed","attachContentToContentSet" ];
        return $authException;
    }

    public function __construct(Agent $agent, Response $response)
    {
        $this->response = $response;
        $this->setting = json_decode(app('setting')->setting);
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
                    $query = Content::whereIn("id",$arrayOfId)
                        ->active()
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

//        $tagLabels = View::make(
//            'partials.search.tagLabel',
//            [
//                'tags' => $tagInput,
//                "spanClass"=>"portlet-tag"
//            ]
//        )->render();

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
                        ["value"=>"", "initialIndex"=>"همه دروس"] ,
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
                    ])->sortBy("index")->values()
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break ;
                case "ریاضی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "initialIndex"=>"همه دروس"] ,
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
                    ])->sortBy("index")->values()
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break;
                case "تجربی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "initialIndex"=>"همه دروس"] ,
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
                    ])->sortBy("index")->values()
                    );
                    $defaultLesson = array_merge($defaultLesson , array_intersect( $lessons->pluck("value")->toArray() , $tagInput ))  ;
                    break;
                case "انسانی":
                    $lessons= $lessons->merge(collect([
                        ["value"=>"", "initialIndex"=>"همه دروس"] ,
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
                    ])->sortBy("index")->values()
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
        $defaultMajor = array_intersect( array_flip($majors) , $tagInput )  ;

        $gradeCollection = Grade::whereNotIN("name" , ['graduated' ,"haftom" ,"hashtom" , "nohom" , "davazdahom" ])->get();
        $gradeCollection->push(["displayName"=>"اول دبیرستان" , "description"=>"اول_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"دوم دبیرستان" , "description"=>"دوم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"سوم دبیرستان" , "description"=>"سوم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"چهارم دبیرستان" , "description"=>"چهارم_دبیرستان"]);
        $gradeCollection->push(["displayName"=>"المپیاد" , "description"=>"المپیاد_علمی"]);
        $totalTags = array_merge($totalTags , $gradeCollection->pluck("description")->toArray()) ;
        $grades = $gradeCollection->pluck('displayName' , 'description')->toArray() ;
        $defaultGrade = array_intersect( array_flip($grades) , $tagInput )  ;
//            $grades = array_sort_recursive($grades);

        $lessonTeacher = collect(
            [
                "" => collect(
                    [
                        ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                        ["lastName"=>"ثابتی" , "firstName"=>"محمد صادق" , "value"=>"محمد_صادق_ثابتی"],
                        ["lastName"=>"نصیری" , "firstName"=>"سیروس" , "value"=>"سیروس_نصیری"],
                        ["lastName"=>"شامیزاده" , "firstName"=>"رضا" , "value"=>"رضا_شامیزاده"],
                        ["lastName"=>"شهریان" , "firstName"=>"محسن" , "value"=>"محسن_شهریان"],
                        ["lastName"=>"مؤذنی پور", "firstName"=>"بهمن" , "value"=>"بهمن_مؤذنی_پور"],
                        ["lastName"=>"معینی" , "firstName"=>"سروش" , "value"=>"سروش_معینی"],
                        ["lastName"=>"شاه محمدی" , "firstName"=>"" , "value"=>"شاه_محمدی"],
                        ["lastName"=>"حسینی فرد" , "firstName"=>"محمد رضا" , "value"=>"محمد_رضا_حسینی_فرد"],
                        ["lastName"=>"کبریایی" , "firstName"=>"وحید" , "value"=>"وحید_کبریایی"],
                        ["lastName"=>"مرصعی" , "firstName"=>"حسن" , "value"=>"حسن_مرصعی"],
                        ["lastName"=>"مقصودی" , "firstName"=>"محمدرضا" , "value"=>"محمدرضا_مقصودی"],
                        ["lastName"=>"رحیمی", "firstName"=>"شهروز" , "value"=>"شهروز_رحیمی"],
                        ["lastName"=>"کرد", "firstName"=>"حسین" , "value"=>"حسین_کرد"],
                        ["lastName"=>"امینی راد", "firstName"=>"مهدی" , "value"=>"مهدی_امینی_راد"],
                        ["lastName"=>"نایب کبیر", "firstName"=>"جواد" , "value"=>"جواد_نایب_کبیر"],
                        ["lastName"=>"نباخته", "firstName"=>"محمدامین" , "value"=>"محمدامین_نباخته"],
                        ["lastName"=>"صدری" , "firstName"=>"علی", "value"=>"علی_صدری"],
                        ["lastName"=>"محمد زاده", "firstName"=>"خسرو" , "value"=>"خسرو_محمد_زاده"],
                        ["lastName"=>"علیمرادی", "firstName"=>"پدرام" , "value"=>"پدرام_علیمرادی"],
                        ["lastName"=>"ناصح زاده", "firstName"=>"میلاد" , "value"=>"میلاد_ناصح_زاده"],
                        ["lastName"=>"جلادتی", "firstName"=>"مهدی" , "value"=>"مهدی_جلادتی"],
                        ["lastName"=>"ناصر شریعت" , "firstName"=>"مهدی", "value"=>"مهدی_ناصر_شریعت"],
                        ["lastName"=>"تاج بخش", "firstName"=>"عمار" , "value"=>"عمار_تاج_بخش"],
                        ["lastName"=>"حشمتی" , "firstName"=>"ناصر", "value"=>"ناصر_حشمتی"],
                        ["lastName"=>"آهویی" , "firstName"=>"محسن", "value"=>"محسن_آهویی"],
                        ["lastName"=>"رنجبرزاده", "firstName"=>"جعفر" , "value"=>"جعفر_رنجبرزاده"],
                        ["lastName"=>"آقاجانی", "firstName"=>"محمد رضا" , "value"=>"محمد_رضا_آقاجانی"],
                        ["lastName"=>"صنیعی طهرانی", "firstName"=>"مهدی" , "value"=>"مهدی_صنیعی_طهرانی"],
                        ["lastName"=>"حسین انوشه", "firstName"=>"محمد" , "value"=>"محمد_حسین_انوشه"],
                        ["lastName"=>"حسین شکیباییان" , "firstName"=>"محمد", "value"=>"محمد_حسین_شکیباییان"],
                        ["lastName"=>"پویان نظر" , "firstName"=>"حامد", "value"=>"حامد_پویان_نظر"],
                        ["lastName"=>"حاجی سلیمانی", "firstName"=>"روح الله" , "value"=>"روح_الله_حاجی_سلیمانی"],
                        ["lastName"=>"معینی" , "firstName"=>"محسن", "value"=>"محسن_معینی"],
                        ["lastName"=>"جعفری" , "firstName"=>"", "value"=>"جعفری"],
                        ["lastName"=>"طلوعی" , "firstName"=>"پیمان", "value"=>"پیمان_طلوعی"],
                        ["lastName"=>"فدایی فرد" , "firstName"=>"حمید", "value"=>"حمید_فدایی_فرد"],
                        ["lastName"=>"رمضانی", "firstName"=>"علیرضا" , "value"=>"علیرضا_رمضانی"],
                        ["lastName"=>"داداشی", "firstName"=>"فرشید" , "value"=>"فرشید_داداشی"],
                        ["lastName"=>"کازرانیان", "firstName"=>"" , "value"=>"کازرانیان"],
                        ["lastName"=>"نادریان", "firstName"=>"" , "value"=>"نادریان"],
                        ["lastName"=>"جهانبخش", "firstName"=>"" , "value"=>"جهانبخش"],
                        ["lastName"=>"عزتی", "firstName"=>"علی اکبر" , "value"=>"علی_اکبر_عزتی"],
                        ["lastName"=>"فراهانی" , "firstName"=>"کیاوش", "value"=>"کیاوش_فراهانی"],
                        ["lastName"=>"درویش", "firstName"=>"" , "value"=>"درویش"],
                        ["lastName"=>"تفتی", "firstName"=>"مهدی" , "value"=>"مهدی_تفتی"],
                        ["lastName"=>"سبطی" , "firstName"=>"هامون", "value"=>"هامون_سبطی"],
                        ["lastName"=>"راوش", "firstName"=>"داریوش" , "value"=>"داریوش_راوش"],
                        ["lastName"=>"مرادی", "firstName"=>"عبدالرضا" , "value"=>"عبدالرضا_مرادی"],
                        ["lastName"=>"صادقی", "firstName"=>"محمد" , "value"=>"محمد_صادقی"],
                        ["lastName"=>"کاظمی", "firstName"=>"کاظم" , "value"=>"کاظم_کاظمی"],
                        ["lastName"=>"حسین خانی", "firstName"=>"میثم" , "value"=>"میثم__حسین_خانی"],
                        ["lastName"=>"امینی راد", "firstName"=>"محمد علی" , "value"=>"محمد_علی_امینی_راد"],
                        ["lastName"=>"پازوکی" , "firstName"=>"محمد", "value"=>"محمد_پازوکی"],
                        ["lastName"=>"راستی بروجنی", "firstName"=>"عباس" , "value"=>"عباس_راستی_بروجنی"],
                        ["lastName"=>"جعفری", "firstName"=>"ابوالفضل" , "value"=>"ابوالفضل_جعفری"],
                        ["lastName"=>"موقاری" , "firstName"=>"جلال", "value"=>"جلال_موقاری"],
                        ["lastName"=>"رحیمی"  , "firstName"=>"پوریا", "value"=>"پوریا_رحیمی"],
                        ["lastName"=>"حدادی" , "firstName"=>"مسعود", "value"=>"مسعود_حدادی"],
                        ["lastName"=>"ارشی", "firstName"=>"" , "value"=>"ارشی"],
                        ["lastName"=>"آقاجانی", "firstName"=>"رضا" , "value"=>"رضا_آقاجانی"],
                        ["lastName"=>"جلالی", "firstName"=>"سید حسام الدین" , "value"=>"سید_حسام_الدین_جلالی"],
                        ["lastName"=>"بهمند" , "firstName"=>"یاشار", "value"=>"یاشار_بهمند"],
                        ["lastName"=>"جعفری نژاد" , "firstName"=>"مصطفی", "value"=>"مصطفی_جعفری_نژاد"],
                        ["lastName"=>"زاهدی", "firstName"=>"امید" , "value"=>"امید_زاهدی"],
                    ]
                )->sortBy("lastName")->values(),
                "دیفرانسیل" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"ثابتی" , "firstName"=>"محمد صادق", "value"=>"محمد_صادق_ثابتی"],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"شهریان" , "firstName"=>"محسن", "value"=>"محسن_شهریان"],
                    ["lastName"=>"نصیری" , "firstName"=>"سیروس" , "value"=>"سیروس_نصیری"],
                ])->sortBy("lastName")->values(),
                "گسسته" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"مؤذنی پور" , "firstName"=>"بهمن", "value"=>"بهمن_مؤذنی_پور"],
                    ["lastName"=>"معینی" , "firstName"=>"سروش", "value"=>"سروش_معینی"],
                    ["lastName"=>"محمدی" , "firstName"=>"شاه", "value"=>"شاه_محمدی"],
                ])->sortBy("lastName")->values(),
                "تحلیلی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"شامیزاده", "firstName"=>"رضا" , "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"ثابتی" , "firstName"=>"محمد صادق", "value"=>"محمد_صادق_ثابتی"],
                    ["lastName"=>"حسینی فرد" , "firstName"=>"محمد رضا", "value"=>"محمد_رضا_حسینی_فرد"],
                ])->sortBy("lastName")->values(),
                "هندسه_پایه" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"کبریایی" , "firstName"=>"وحید", "value"=>"وحید_کبریایی"],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"حسینی فرد", "firstName"=>"محمد رضا" , "value"=>"محمد_رضا_حسینی_فرد"],
                    ["lastName"=>"مرصعی" , "firstName"=>"حسن", "value"=>"حسن_مرصعی"],
                ])->sortBy("lastName")->values(),
                "حسابان" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"ثابتی", "firstName"=>"محمد صادق" , "value"=>"محمد_صادق_ثابتی"],
                    ["lastName"=>"مقصودی" , "firstName"=>"محمدرضا", "value"=>"محمدرضا_مقصودی"],
                    ["lastName"=>"رحیمی" , "firstName"=>"شهروز", "value"=>"شهروز_رحیمی"],
                ])->sortBy("lastName")->values(),
                "جبر_و_احتمال" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"کرد" , "firstName"=>"حسین", "value"=>"حسین_کرد"],
                    ["lastName"=>"شامیزاده", "firstName"=>"رضا" , "value"=>"رضا_شامیزاده"],
                ])->sortBy("lastName")->values(),
                "ریاضی_پایه" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"امینی راد" , "firstName"=>"مهدی", "value"=>"مهدی_امینی_راد"],
                    ["lastName"=>"نایب کبیر" , "firstName"=>"جواد", "value"=>"جواد_نایب_کبیر"],
                    ["lastName"=>"شهریان" , "firstName"=>"محسن", "value"=>"محسن_شهریان"],
                    ["lastName"=>"مقصودی", "firstName"=>"محمدرضا" , "value"=>"محمدرضا_مقصودی"],
                ])->sortBy("lastName")->values(),
                "ریاضی_تجربی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"امینی راد" , "firstName"=>"مهدی", "value"=>"مهدی_امینی_راد"],
                    ["lastName"=>"نباخته" , "firstName"=>"محمدامین", "value"=>"محمدامین_نباخته"],
                    ["lastName"=>"حسینی فرد" , "firstName"=>"محمد رضا", "value"=>"محمد_رضا_حسینی_فرد"],
                    ["lastName"=>"صدری" , "firstName"=>"علی", "value"=>"علی_صدری"],
                ])->sortBy("lastName")->values(),
                "ریاضی_انسانی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"محمد زاده" , "firstName"=>"خسرو" , "value"=>"خسرو_محمد_زاده"],
                    ["lastName"=>"امینی راد" , "firstName"=>"مهدی", "value"=>"مهدی_امینی_راد"],
                ])->sortBy("lastName"),
                "عربی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"علیمرادی" , "firstName"=>"پدرام", "value"=>"پدرام_علیمرادی"],
                    ["lastName"=>"ناصح زاده" , "firstName"=>"میلاد", "value"=>"میلاد_ناصح_زاده"],
                    ["lastName"=>"جلادتی" , "firstName"=>"مهدی", "value"=>"مهدی_جلادتی"],
                    ["lastName"=>"ناصر شریعت" , "firstName"=>"مهدی", "value"=>"مهدی_ناصر_شریعت"],
                    ["lastName"=>"تاج بخش" , "firstName"=>"عمار", "value"=>"عمار_تاج_بخش"],
                    ["lastName"=>"حشمتی" , "firstName"=>"ناصر", "value"=>"ناصر_حشمتی"],
                    ["lastName"=>"آهویی" , "firstName"=>"محسن", "value"=>"محسن_آهویی"],
                    ["lastName"=>"رنجبرزاده", "firstName"=>"جعفر" , "value"=>"جعفر_رنجبرزاده"],
                ])->sortBy("lastName")->values(),
                "شیمی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"آقاجانی"  , "firstName"=>"محمد رضا", "value"=>"محمد_رضا_آقاجانی"],
                    ["lastName"=>"طهرانی"  , "firstName"=>"مهدی صنیعی", "value"=>"مهدی_صنیعی_طهرانی"],
                    ["lastName"=>"انوشه"  , "firstName"=>"محمد حسین", "value"=>"محمد_حسین_انوشه"],
                    ["lastName"=>"شکیباییان"  , "firstName"=>"محمد حسین ", "value"=>"محمد_حسین_شکیباییان"],
                    ["lastName"=>"پویان نظر"  , "firstName"=>"حامد ", "value"=>"حامد_پویان_نظر"],
                    ["lastName"=>"حاجی سلیمانی"  , "firstName"=>"روح الله ", "value"=>"روح_الله_حاجی_سلیمانی"],
                    ["lastName"=>"معینی"  , "firstName"=>"محسن ", "value"=>"محسن_معینی"],
                    ["lastName"=>"جعفری"  , "firstName"=>"", "value"=>"جعفری"],
                ])->sortBy("lastName")->values(),
                "فیزیک" =>collect( [
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"طلوعی"  , "firstName"=>"پیمان", "value"=>"پیمان_طلوعی"],
                    ["lastName"=>"فدایی فرد"  , "firstName"=>"حمید", "value"=>"حمید_فدایی_فرد"],
                    ["lastName"=>"رمضانی"  , "firstName"=>"علیرضا", "value"=>"علیرضا_رمضانی"],
                    ["lastName"=>"داداشی"  , "firstName"=>"فرشید", "value"=>"فرشید_داداشی"],
                    ["lastName"=>"کازرانیان"  , "firstName"=>"", "value"=>"کازرانیان"],
                    ["lastName"=>"نادریان"  , "firstName"=>"", "value"=>"نادریان"],
                    ["lastName"=>"جهانبخش"  , "firstName"=>"", "value"=>"جهانبخش"],
                ])->sortBy("lastName")->values(),
                "زبان_انگلیسی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"عزتی", "firstName"=>"علی اکبر" , "value"=>"علی_اکبر_عزتی"],
                    ["lastName"=>"فراهانی" , "firstName"=>"کیاوش", "value"=>"کیاوش_فراهانی"],
                    ["lastName"=>"درویش", "firstName"=>"" , "value"=>"درویش"],
                ])->sortBy("lastName")->values(),
                "دین_و_زندگی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"تفتی" , "firstName"=>"مهدی", "value"=>"مهدی_تفتی"],
                    ["lastName"=>"رنجبرزاده", "firstName"=>"جعفر" , "value"=>"جعفر_رنجبرزاده"],
                ])->sortBy("lastName")->values(),
                "زبان_و_ادبیات_فارسی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"سبطی" , "firstName"=>"هامون" , "value"=>"هامون_سبطی"],
                    ["lastName"=>"راوش" , "firstName"=>"داریوش" , "value"=>"داریوش_راوش"],
                    ["lastName"=>"مرادی" , "firstName"=>"عبدالرضا" , "value"=>"عبدالرضا_مرادی"],
                    ["lastName"=>"صادقی", "firstName"=>"محمد"  , "value"=>"محمد_صادقی"],
                    ["lastName"=>"کاظمی" , "firstName"=>"کاظم" , "value"=>"کاظم_کاظمی"],
                    ["lastName"=>"خانی حسین" , "firstName"=>"میثم" , "value"=>"میثم__حسین_خانی"],
                ])->sortBy("lastName")->values(),
                "آمار_و_مدلسازی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"شامیزاده" , "firstName"=>"رضا", "value"=>"رضا_شامیزاده"],
                    ["lastName"=>"کبریایی" , "firstName"=>"وحید", "value"=>"وحید_کبریایی"],
                    ["lastName"=>"امینی راد" , "firstName"=>"مهدی", "value"=>"مهدی_امینی_راد"],
                ])->sortBy("lastName")->values(),
                "زیست_شناسی" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"امینی راد"  , "firstName"=>"محمد علی", "value"=>"محمد_علی_امینی_راد"],
                    ["lastName"=>"پازوکی"  , "firstName"=>"محمد", "value"=>"محمد_پازوکی"],
                    ["lastName"=>"راستی بروجنی"  , "firstName"=>"عباس", "value"=>"عباس_راستی_بروجنی"],
                    ["lastName"=>"جعفری"  , "firstName"=>"ابوالفضل", "value"=>"ابوالفضل_جعفری"],
                    ["lastName"=>"موقاری"  , "firstName"=>"جلال", "value"=>"جلال_موقاری"],
                    ["lastName"=>"رحیمی"  , "firstName"=>"پوریا", "value"=>"پوریا_رحیمی"],
                    ["lastName"=>"حدادی"  , "firstName"=>"مسعود", "value"=>"مسعود_حدادی"],
                    ["lastName"=>"ارشی"  , "firstName"=>"", "value"=>"ارشی"],
                ])->sortBy("lastName")->values(),
                "ریاضی_و_آمار" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"امینی راد", "firstName"=>"مهدی" , "value"=>"مهدی_امینی_راد"],
                ])->sortBy("lastName")->values(),
                "منطق" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"آقاجانی" , "firstName"=>"رضا", "value"=>"رضا_آقاجانی"],
                    ["lastName"=>"الدین جلالی" , "firstName"=>"سید حسام", "value"=>"سید_حسام_الدین_جلالی"],
                ])->sortBy("lastName")->values(),
                "المپیاد_فیزیک" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"جعفری نژاد" , "firstName"=>"مصطفی", "value"=>"مصطفی_جعفری_نژاد"],
                ])->sortBy("lastName")->values(),
                "المپیاد_نجوم" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"بهمند" , "firstName"=>"یاشار", "value"=>"یاشار_بهمند"],
                ])->sortBy("lastName")->values(),
                "مشاوره" => collect([
                    ["index"=>"همه دبیرها" , "firstName"=>"" , "value"=>""],
                    ["lastName"=>"امینی راد" , "firstName"=>"محمد علی", "value"=>"محمد_علی_امینی_راد"],
                    ["lastName"=>"زاهدی", "firstName"=>"امید" , "value"=>"امید_زاهدی"],
                ])->sortBy("lastName")->values(),
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


        $extraTagDiff  = array_diff($tagInput , $totalTags );
        $extraTagArray = [];
        foreach ($extraTagDiff as $item)
        {
            $key = array_search($item , $tagInput);
            $extraTagArray = array_add($extraTagArray , $key , $item) ;
        }

        if(!is_null(array_last($defaultMajor)))
            $defaultMajor = array_last($defaultMajor);
        else
            $defaultMajor = "";

        if(!is_null(array_last($defaultGrade)))
            $defaultGrade = array_last($defaultGrade);
        else
            $defaultGrade = "";

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
                    "itemTypes"=>$itemTypes ,
                    "tagLabels" => $tagInput ,
                    "extraTags" => $extraTagArray
                ]);
        }
        else
        {

            $sideBarMode = "closed";
//            $ads1 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-1.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
//            $ads2 = [
//                //DINI SEBTI
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-2.jpg' => 'https://sanatisharif.ir/landing/4',
//                'https://cdn.sanatisharif.ir/upload/ads/SMALL-SLIDE-3.jpg' => 'https://sanatisharif.ir/landing/4',
//            ];
            $ads1 = [];
            $ads2 = [];
            return view("pages.search" , compact("items" ,"itemTypes" ,"tagArray" , "extraTagArray",
                "majors" , "grades"  , "defaultLesson" , "sideBarMode" , "majorLesson" , "lessonTeacher" , "defaultTeacher"
                , "ads1" , "ads2" , 'tagInput' ,'defaultGrade' , 'defaultMajor' ));
        }
    }

    public function embed(Request $request , Content $content){
        $url = action('ContentController@show', $content);
        $this->generateSeoMetaTags($content);
        if($content->contenttype_id != Content::CONTENT_TYPE_VIDEO)
            return redirect($url, 301);
        $video = $content;

        [
            $contentsWithSameSet ,
            $contentSetName
        ]  = $video->getSetMates();
        $files = $video->files;

        return view("content.embed",compact('video','files','contentsWithSameSet','contentSetName'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rootContentTypes = $this->getRootsContentTypes();
        $contentsets = Contentset::latest()
                                ->pluck("name" , "id");
        $authors =User::getTeachers();

        return view("content.create2" , compact("rootContentTypes" ,
                                                                        "contentsets" ,
                                                                            "authors"
                                                                        )) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {
        $contenttypes = collect();
        $contenttypes->put(Content::CONTENT_TYPE_VIDEO , "فیلم");
        $contenttypes->put(Content::CONTENT_TYPE_PAMPHLET , "جزوه");

        return view("content.create3" , compact("contenttypes")) ;
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @param  \App\Content $content
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Request $request, Content $content)
    {
        if ($content->isActive()) {

            $sideBarMode = "closed";
            $adItems = $content->getAddItems();
            $tags = $content->retrievingTags();
            [
                $author, $content, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName
            ] = $this->getContentInformation($content);

            $this->generateSeoMetaTags($content);
            $seenCount = $this->getSeenCountFromRequest($request);
            $userCanSeeCounter = optional(auth()->user())->CanSeeCounter();

            $result = compact( "seenCount","author", "content", "rootContentType", "childContentType", "contentsWithSameType", "soonContentsWithSameType", "contentSet", "contentsWithSameSet", "videosWithSameSet", "pamphletsWithSameSet", "contentSetName", "videoSources"
              , "tags", "sideBarMode", "userCanSeeCounter", "adItems", "videosWithSameSetL", "videosWithSameSetR","contentId");

            return view("content.show", $result);
        } else
            abort(403);
    }

    private function generateSeoMetaTags(Content $content)
    {
        try {
            $seo = new SeoMetaTagsGenerator($content);
        } catch (\Exception $e) {
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content   $content
     * @return \Illuminate\Http\Response
     */
    public function edit($content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags = optional($content->tags)->tags;
        $tags = implode(",", isset($tags) ? $tags : []);
        $contentset = $content->contentset;
        $rootContentTypes = $this->getRootsContentTypes();

        $result = compact("content" ,"rootContentTypes" ,"validSinceTime" ,"tags" ,"contentset" ,"rootContentTypes" );
        return view("content.edit" , $result) ;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertContentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InsertContentRequest $request)
    {
        //TODO:// validate Data Format in Requests
        /* files
         {
            {
                fileName --> required
                caption
                res
                type
                res
            },
            {
                        fileName
                caption
                res
                type
                res
            }
        }
        */
        $content = new Content();
        $contentset_id = $request->get("contentset_id");
        $order = $request->get("order");
        $this->fillContentFromRequest($request, $content);

        if($content->save()){
            if(isset($contentset_id))
                $this->attachContentSetToContent($content, $contentset_id,$order);
            return $this->response
                ->setStatusCode(Response::HTTP_OK )
                ->setContent([
                    "id"=>$content->id
                ]);
        }
        return $this->response
            ->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws Exception
     */
    public function basicStore(Request $request)
    {
        $contentset_id = $request->get("contentset_id");
        $contenttype_id = $request->get("contenttype_id");
        $name = $request->get("name");
        $order = $request->get("order");
        $fileName = $request->get("fileName");
        $dateNow = Carbon::now();

        $contentset = Contentset::FindOrFail($contentset_id);
        $lastContent = $contentset->getLastContent();

        if(isset($lastContent))
            $newContent = $lastContent->replicate();
        else
        {
            session()->put("error" , trans('content.No previous content found'));
            return redirect()->back();
        }
        if($newContent instanceof Content){
            $newContent->contenttype_id = $contenttype_id ;
            $newContent->name = $name;
            $newContent->description = null;
            $newContent->metaTitle = null;
            $newContent->metaDescription = null;
            $newContent->enable = 0;
            $newContent->validSince = $dateNow;
            $newContent->created_at = $dateNow;
            $newContent->updated_at = $dateNow;

            $files = $this->makeVideoFileArray($fileName , $contentset_id);

            $thumbnailUrl          = $this->makeThumbnailUrlFromFileName($fileName, $contentset_id);
            $newContent->thumbnail = $this->makeThumbanilFile($thumbnailUrl);
            $this->storeFilesOfContent($newContent, $files);

            $newContent->save();
            if(!isset($order))
                $order = $lastContent->pivot->order + 1;
            $this->attachContentSetToContent($newContent,$contentset->id,$order);

            return redirect(action("ContentController@edit" , $newContent->id));
        }else
            throw new Exception("replicate Error!". $contentset_id);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditContentRequest  $request
     * @param  \App\Content   $content
     * @return \Illuminate\Http\Response
     */
    public function update(EditContentRequest $request, $content)
    {
        $this->fillContentFromRequest($request, $content);

        //TODO:// update default contentset
        if($content->update()){
            session()->put('success', 'اصلاح محتوا با موفقیت انجام شد');
        }
        else{
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content $content
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($content)
    {
        //TODO:// remove Tags From Redis, ( Do it in ContentObserver)
        if ($content->delete()){
            return $this->response->setStatusCode(Response::HTTP_OK) ;
        }
        else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE) ;
        }
    }

    /**
     * Search for an educational content
     *
     * @param
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return redirect('/c',Response::HTTP_MOVED_PERMANENTLY);
    }

    /**
     * @param Content $content
     * @return array
     */
    private function getContentInformation(Content $content): array
    {
        $author = $content->author;

        [
            $contentsWithSameSet,
            $contentSetName
        ] = $content->getSetMates();
        $contentsWithSameSet = $contentsWithSameSet->normalMates();
        $videosWithSameSet = optional($contentsWithSameSet)->whereIn("type", "video");
        $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn("type", "pamphlet");
        [
            $videosWithSameSetL,
            $videosWithSameSetR
        ] = optional($videosWithSameSet)->partition(function ($i) use ($content) {
            return $i["content"]->id < $content->id;
        });

        return [
            $author, $content, $contentsWithSameSet, $videosWithSameSet, $videosWithSameSetL, $videosWithSameSetR, $pamphletsWithSameSet, $contentSetName
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    private function getRootsContentTypes()
    {
        $rootContentTypes = Contenttype::whereDoesntHave("parents")->get();
        return $rootContentTypes;
    }


    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), ['only' => ['store', 'create', 'create2']]);
        $this->middleware('permission:' . Config::get("constants.EDIT_EDUCATIONAL_CONTENT"), ['only' => ['update', 'edit']]);
        $this->middleware('permission:' . Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"), ['only' => 'destroy']);
        $this->middleware('convert:order|title', ['only' => ['store' , 'update']]);
    }



    /**
     * @param $time
     * @param $validSince
     * @return null|string
     */
    private function getValidSinceDateTime($time, $validSince): string
    {
        if (isset($time)) {
            if (strlen($time) > 0)
                $time = Carbon::parse($time)->format('H:i:s');
            else
                $time = "00:00:00";
        }
        if (isset($validSince)) {
            $validSince = Carbon::parse($validSince)->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
            if (isset($time))
                $validSince = $validSince . " " . $time;
            return $validSince;
        }
        return null;
    }

    /**
     * @param $tagString
     * @return array
     */
    private function getTagsArrayFromTagString($tagString): array
    {
        $tags = explode(",", $tagString);
        $tags = array_filter($tags);
        return $tags;
    }

    /**
     * @param Content $content
     * @param $contentset_id
     * @param $order
     * @param int $isDefault
     */
    private function attachContentSetToContent(Content &$content, $setId,$order, $isDefault = 1 ): void
    {
        $content->contentsets()->attach($setId, [
            "order" =>isset($order) ? $order : 0,
            "isDefault" => $isDefault
        ]);
    }

    //TODO:// implement
    public function attachContentToContentSet(Request $request, Content $content, Contentset $set){
        abort(Response::HTTP_FORBIDDEN);
        /*$order = $request->get('order', 0);
        $this->attachContentSetToContent($content, $set, $order,0);*/
    }
    public function updateContentSetPivots(Request $request, Content $content, Contentset $set){
        abort(Response::HTTP_FORBIDDEN);
        /*$order = $request->get('order', 0);
        $content->contentsets()
            ->updateExistingPivot($set->id, [
                'order' => $order
            ], false);*/
    }

    /**
     * @param $fileName
     * @return boolean
     */
    private function strIsEmpty($str):bool
    {
        return strlen(preg_replace('/\s+/', '', $str)) == 0 ;
    }

    /**
     * @param Content $content
     *
     * @param array $files
     */
    private function storeFilesOfContent(Content &$content, array $files):void
    {
        $disk = $content->isFree ? config("constants.DISK_FREE_CONTENT") : config("constants.DISK_PRODUCT_CONTENT");

        $fileCollection = collect();

        foreach ($files as $key => $file) {
            $fileName = isset($file->name) ? $file->name : null;
            $caption = isset($file->caption) ? $file->caption : null;
            $res = isset($file->res) ? $file->res : null;
            $type = isset($file->type) ? $file->type : null;
            if ($this->strIsEmpty($fileName))
                continue;
            $fileCollection->push([
                "uuid" => Str::uuid()->toString(),
                "disk" => $disk,
                "url" => null,
                "fileName" => $fileName,
                "size" => null,
                "caption" => $caption,
                "res" => $res,
                "type" => $type,
                "ext" => pathinfo($fileName, PATHINFO_EXTENSION)
            ]);
        }
        $content->file = $fileCollection;
    }

    /**
     * @param FormRequest $request
     * @param Content $content
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Content &$content):void
    {
        $inputData = $request->all();
        $time = $request->get("validSinceTime");
        $validSince = $request->get("validSinceDate");
        $enabled = $request->has("enable");
        $tagString = $request->get("tags");
        $files = json_decode($request->get("files"));

        $content->fill($inputData);
        $content->validSince = $this->getValidSinceDateTime($time, $validSince);
        $content->enable = $enabled ? 1 : 0;
        $content->tags = $this->getTagsArrayFromTagString($tagString);

        if (isset($files))
            $this->storeFilesOfContent($content, $files);
    }

    public function makeVideoFileArray($fileName,$contentset_id) :array {
        $fileUrl = [
            "720p" =>   "/media/".$contentset_id."/HD_720p/".$fileName,
            "480p" => "/media/".$contentset_id."/hq/".$fileName,
            "240p" =>"/media/".$contentset_id."/240p/".$fileName
        ];
        $files = [];
        $files[] = $this->makeVideoFileStdClass($fileUrl["240p"],"240p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["480p"],"480p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["720p"],"720p");
        return $files;
    }
    /**
     * @param $filename
     * @param $res
     * @return \stdClass
     */
    private function makeVideoFileStdClass($filename, $res): \stdClass
    {
        $file = new \stdClass();
        $file->name = $filename;
        $file->res = $res;
        $file->caption = Content::videoFileCaptionTable()[$res];
        $file->type = "video";
        return $file;
    }

    /**
     * @param $thumbnailUrl
     * @return array
     */
    private function makeThumbanilFile($thumbnailUrl): array
    {
        return [
            "uuid" => Str::uuid()->toString(),
            "disk" => "alaaCdnSFTP",
            "url" => $thumbnailUrl,
            "fileName" => parse_url($thumbnailUrl)['path'],
            "size" => null,
            "caption" => null,
            "res" => null,
            "type" => "thumbnail",
            "ext" => pathinfo(parse_url($thumbnailUrl)['path'], PATHINFO_EXTENSION)
        ];
    }

    /**
     * @param $fileName
     * @param $contentset_id
     * @return string
     */
    private function makeThumbnailUrlFromFileName($fileName, $contentset_id): string
    {
        $baseUrl = "https://cdn.sanatisharif.ir/media/";
        //thumbnail
        $thumbnailFileName = pathinfo($fileName, PATHINFO_FILENAME) . ".jpg";
        $thumbnailUrl = $baseUrl . "thumbnails/" . $contentset_id . "/" . $thumbnailFileName;
        return $thumbnailUrl;
    }


    private function getRedisRequestSubPath(Request $request, $itemType , $paginationSetting){

        $requestSubPath = "&withscores=1";
        $bucket = "content";
        $perPage = $paginationSetting->where("itemType" , "video")->first()["itemPerPage"];
        $pageName = $paginationSetting->where("itemType" , "video")->first()["pageName"];
        switch ($itemType)
        {
            case "video":
                $itemTypeTag = "فیلم";
                break;
            case "pamphlet":
                $itemTypeTag = "جزوه";
                break;
            case "article":
                $itemTypeTag = "مقاله";
                break;
            case "contentset":
                $bucket = "contentset";
                $itemTypeTag = "دوره_آموزشی";
                break;
            case "product":
                $perPage = 16;
                $pageName = "other";
                $bucket = "product";
                $itemTypeTag = "محصول";
                break;
            default:
                $perPage = 16;
                $pageName = "other";
                $bucket = $itemType;
                $itemTypeTag = "other";
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
                $query->load('contents');
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
                        "name" => $item->display_name,
                        "videoDescribe" => $item->description,
                        "url" => action('ContentController@show',$item),
                        "videoLink480" => $hq,
                        "videoLink240" => $h240,
                        "videoviewcounter" =>"0",
                        "videoDuration" => 0,
                        "session" => $sessionNumber."",
                        "thumbnail" => (isset($thumbnail->name))?$thumbnail->name:""
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
}
