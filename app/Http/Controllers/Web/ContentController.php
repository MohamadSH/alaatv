<?php

namespace App\Http\Controllers\Web;
use App\Classes\Search\ContentSearch;
use App\Classes\Search\ContentsetSearch;
use App\Classes\Search\ProductSearch;
use App\Content;
use App\Contentset;
use App\Contenttype;
use App\Http\Controllers\Controller;
use App\Http\Requests\{ContentIndexRequest, EditContentRequest, InsertContentRequest, Request};
use App\Traits\{APIRequestCommon,
    CharacterCommon,
    FileCommon,
    Helper,
    MetaCommon,
    ProductCommon,
    RequestCommon,
    SearchCommon};
use App\User;
use App\Websitesetting;
use Carbon\Carbon;
use Exception;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\{Config};
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;


class ContentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Traits
    |--------------------------------------------------------------------------
    */

    use ProductCommon;
    use Helper;
    use FileCommon;
    use RequestCommon;
    use APIRequestCommon;
    use CharacterCommon;
    use MetaCommon;
    use SearchCommon;

    /*
    |--------------------------------------------------------------------------
    | Properties
    |--------------------------------------------------------------------------
    */
    const PARTIAL_SEARCH_TEMPLATE_ROOT = 'partials.search';
    const PARTIAL_INDEX_TEMPLATE       = 'content.index';
    protected $response;
    protected $setting;
    /**
     * @var ContentSearch
     */
    private $contentSearch;
    /**
     * @var ContentsetSearch
     */
    private $setSearch;

    /**
     * @var ProductSearch
     */
    private $productSearch;

    /*
    |--------------------------------------------------------------------------
    | Private methods
    |--------------------------------------------------------------------------
    */

    public function __construct(Agent $agent, Response $response, Websitesetting $setting, ContentSearch $contentSearch, ContentsetSearch $setSearch, ProductSearch $productSearch)
    {
        $this->response = $response;
        $this->setting = $setting->setting;
        $authException = $this->getAuthExceptionArray($agent);
        $this->callMiddlewares($authException);
        $this->contentSearch = $contentSearch;
        $this->setSearch = $setSearch;
        $this->productSearch = $productSearch;
    }

    /**
     * @param Agent $agent
     *
     * @return array
     */
    private function getAuthExceptionArray(Agent $agent): array
    {
        if ($agent->isRobot()) {
            $authException = [
                "index",
                "show",
                "embed",
            ];
        } else {
            $authException = ["index"];
        }
        //TODO:// preview(Telegram)
        $authException = [
            "index",
            "show",
            "search",
            "embed",
            "attachContentToContentSet",
        ];
        return $authException;
    }

    /**
     * @param $authException
     */
    private function callMiddlewares($authException): void
    {
        $this->middleware('auth', ['except' => $authException]);
        $this->middleware('permission:' . Config::get('constants.INSERT_EDUCATIONAL_CONTENT_ACCESS'), [
            'only' => [
                'store',
                'create',
                'create2',
            ],
        ]);
        $this->middleware('permission:' . Config::get("constants.EDIT_EDUCATIONAL_CONTENT"), [
            'only' => [
                'update',
                'edit',
            ],
        ]);
        $this->middleware('permission:' . Config::get("constants.REMOVE_EDUCATIONAL_CONTENT_ACCESS"), ['only' => 'destroy']);
        $this->middleware('convert:order|title', [
            'only' => [
                'store',
                'update',
            ],
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param ContentIndexRequest $request
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContentIndexRequest $request)
    {
        $contentTypes = array_filter($request->get('contentType',Contenttype::List()));
        $contentOnly = $request->get('contentOnly', false);
        $tags = (array)$request->get('tags');
        $filters = $request->all();

        $result = $this->contentSearch->get(compact('filters','contentTypes'));

        $result->offsetSet('set', !$contentOnly ? $this->setSearch->get($filters) : null);
        $result->offsetSet('product', !$contentOnly ? $this->productSearch->get($filters) : null);

        $pageName = "content-search";
        if (request()->expectsJson()) {
            return $this->response
                ->setStatusCode(Response::HTTP_OK)
                ->setContent([
                    'result' => $result,
                    'tags'   => empty($tags) ? null : $tags,
                ]);
        }

        //ToDo : put in composer
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
        $allLessons= collect([
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
        ])->sortBy("index")->values();
        $riaziLessons= collect([
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
        ])->sortBy("index")->values();
        $tajrobiLessons= collect([
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
        ])->sortBy("index")->values();
        $ensaniLessons= collect([
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
        ])->sortBy("index")->values();

        $filterData = [
            'lessonTeacher'=>$lessonTeacher,
            'lessons'=> [
                'allLessons'=>$allLessons,
                'riaziLessons'=>$riaziLessons,
                'tajrobiLessons'=>$tajrobiLessons,
                'ensaniLessons'=>$ensaniLessons
            ]
        ];

        return view("pages.content-search", compact("result", "contentTypes", 'tags','pageName', 'filterData'));
    }

    public function embed(Request $request, Content $content)
    {
        $url = action('ContentController@show', $content);
        $this->generateSeoMetaTags($content);
        if ($content->contenttype_id != Content::CONTENT_TYPE_VIDEO)
            return redirect($url, Response::HTTP_MOVED_PERMANENTLY);
        $video = $content;
        [
            $contentsWithSameSet,
            $contentSetName,
        ] = $video->getSetMates();
        return view("content.embed", compact('video', 'contentsWithSameSet', 'contentSetName'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $rootContentTypes = Contenttype::getRootContentType();
        $contentsets = Contentset::latest()
                                 ->pluck("name", "id");
        $authors = User::getTeachers()
                       ->pluck("full_name", "id");

        return view("content.create2", compact("rootContentTypes", "contentsets", "authors"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create2()
    {
        $contenttypes = Contenttype::getRootContentType()
                                   ->pluck('displayName', 'id');

        return view("content.create3", compact("contenttypes"));
    }

    /**
     * Display the specified resource.
     *
     * @param Request       $request
     * @param  \App\Content $content
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function show(Request $request, Content $content)
    {
        if ($content->isActive()) {

            $adItems = $content->getAddItems();
            $tags = $content->retrievingTags();
            [
                $author,
                $content,
                $contentsWithSameSet,
                $videosWithSameSet,
                $videosWithSameSetL,
                $videosWithSameSetR,
                $pamphletsWithSameSet,
                $contentSetName,
            ] = $this->getContentInformation($content);

            $this->generateSeoMetaTags($content);
            $seenCount = $content->pageView;

            $userCanSeeCounter = optional(auth()->user())->CanSeeCounter();

//            dd($content->set->contents()->active()->get());
//            dd($videosWithSameSet);
            if (request()->expectsJson()) {
                return $this->response
                    ->setStatusCode(Response::HTTP_OK)
                    ->setContent($content);
            }
            return view("content.show", compact("seenCount", "author", "content", "contentsWithSameSet", "videosWithSameSet", "pamphletsWithSameSet", "contentSetName"
                , "tags", "userCanSeeCounter", "adItems", "videosWithSameSetL", "videosWithSameSetR"));
        } else
            abort(403);
    }

    /**
     * @param Content $content
     *
     * @return array
     */
    private function getContentInformation(Content $content): array
    {
        $author = $content->authorName;

        [
            $contentsWithSameSet,
            $contentSetName,
        ] = $content->getSetMates();
        $contentsWithSameSet = $contentsWithSameSet->normalMates();
        $videosWithSameSet = optional($contentsWithSameSet)->whereIn("type", "video");
        $pamphletsWithSameSet = optional($contentsWithSameSet)->whereIn("type", "pamphlet");
        [
            $videosWithSameSetL,
            $videosWithSameSetR,
        ] = optional($videosWithSameSet)->partition(function ($i) use ($content) {
            return $i["content"]->id < $content->id;
        });

        return [
            $author,
            $content,
            $contentsWithSameSet,
            $videosWithSameSet,
            $videosWithSameSetL,
            $videosWithSameSetR,
            $pamphletsWithSameSet,
            $contentSetName,
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Content $content
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($content)
    {
        $validSinceTime = optional($content->validSince)->format('H:i:s');
        $tags = optional($content->tags)->tags;
        $tags = implode(",", isset($tags) ? $tags : []);
        $contentset = $content->set;

//        $rootContentTypes = $this->getRootsContentTypes();

        $result = compact("content",
            "rootContentTypes",
            "validSinceTime",
            "tags",
            "contentset"
//            "rootContentTypes"
        );
        return view("content.edit", $result);
    }

    /*
    |--------------------------------------------------------------------------
    | Public methods
    |--------------------------------------------------------------------------
    */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\InsertContentRequest $request
     *
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
        $this->fillContentFromRequest($request, $content);

        if ($content->save()) {
            return $this->response
                ->setStatusCode(Response::HTTP_OK)
                ->setContent([
                                 "id" => $content->id,
                             ]);
        }
        return $this->response
            ->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
    }


    /**
     * @param FormRequest $request
     * @param Content     $content
     *
     * @return void
     */
    private function fillContentFromRequest(FormRequest $request, Content &$content): void
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

    /**
     * @param $time
     * @param $validSince
     *
     * @return null|string
     */
    private function getValidSinceDateTime($time, $validSince): string
    {
        if (isset($time)) {
            if (strlen($time) > 0)
                $time = Carbon::parse($time)
                              ->format('H:i:s');
            else
                $time = "00:00:00";
        }
        if (isset($validSince)) {
            $validSince = Carbon::parse($validSince)
                                ->format('Y-m-d'); //Muhammad : added a day because it returns one day behind and IDK why!!
            if (isset($time))
                $validSince = $validSince . " " . $time;
            return $validSince;
        }
        return null;
    }

    /**
     * @param $tagString
     *
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
     *
     * @param array   $files
     */
    private function storeFilesOfContent(Content &$content, array $files): void
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
                                      "uuid"     => Str::uuid()
                                                       ->toString(),
                                      "disk"     => $disk,
                                      "url"      => null,
                                      "fileName" => $fileName,
                                      "size"     => null,
                                      "caption"  => $caption,
                                      "res"      => $res,
                                      "type"     => $type,
                                      "ext"      => pathinfo($fileName, PATHINFO_EXTENSION),
                                  ]);
        }
        /** @var TYPE_NAME $content */
        $content->file = $fileCollection;
    }

    /**
     * @param Request $request
     *
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

        if (isset($lastContent))
            $newContent = $lastContent->replicate();
        else {
            session()->put("error", trans('content.No previous content found'));
            return redirect()->back();
        }
        if ($newContent instanceof Content) {
            $newContent->contenttype_id = $contenttype_id;
            $newContent->name = $name;
            $newContent->description = null;
            $newContent->metaTitle = null;
            $newContent->metaDescription = null;
            $newContent->enable = 0;
            $newContent->validSince = $dateNow;
            $newContent->created_at = $dateNow;
            $newContent->updated_at = $dateNow;

            $files = $this->makeVideoFileArray($fileName, $contentset_id);

            $thumbnailUrl = $this->makeThumbnailUrlFromFileName($fileName, $contentset_id);
            $newContent->thumbnail = $this->makeThumbanilFile($thumbnailUrl);
            $this->storeFilesOfContent($newContent, $files);

            $newContent->save();
            if (!isset($order))
                $order = $lastContent->pivot->order + 1;
            $this->attachContentSetToContent($newContent, $contentset->id, $order);

            return redirect(action("Web\ContentController@edit", $newContent->id));
        } else
            throw new Exception("replicate Error!" . $contentset_id);
    }

    public function makeVideoFileArray($fileName, $contentset_id): array
    {
        $fileUrl = [
            "720p" => "/media/" . $contentset_id . "/HD_720p/" . $fileName,
            "480p" => "/media/" . $contentset_id . "/hq/" . $fileName,
            "240p" => "/media/" . $contentset_id . "/240p/" . $fileName,
        ];
        $files = [];
        $files[] = $this->makeVideoFileStdClass($fileUrl["240p"], "240p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["480p"], "480p");

        $files[] = $this->makeVideoFileStdClass($fileUrl["720p"], "720p");
        return $files;
    }

    /**
     * @param $filename
     * @param $res
     *
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
     * @param $fileName
     * @param $contentset_id
     *
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

    /**
     * @param $thumbnailUrl
     *
     * @return array
     */
    private function makeThumbanilFile($thumbnailUrl): array
    {
        return [
            "uuid"     => Str::uuid()
                             ->toString(),
            "disk"     => "alaaCdnSFTP",
            "url"      => $thumbnailUrl,
            "fileName" => parse_url($thumbnailUrl)['path'],
            "size"     => null,
            "caption"  => null,
            "res"      => null,
            "type"     => "thumbnail",
            "ext"      => pathinfo(parse_url($thumbnailUrl)['path'], PATHINFO_EXTENSION),
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\EditContentRequest $request
     * @param  \App\Content                          $content
     *
     * @return \Illuminate\Http\Response
     */
    public function update(EditContentRequest $request, $content)
    {
        $this->fillContentFromRequest($request, $content);

        //TODO:// update default contentset
        if ($content->update()) {
            session()->put('success', 'اصلاح محتوا با موفقیت انجام شد');
        } else {
            session()->put('error', 'خطای پایگاه داده');
        }
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Content $content
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($content)
    {
        //TODO:// remove Tags From Redis, ( Do it in ContentObserver)
        if ($content->delete()) {
            return $this->response->setStatusCode(Response::HTTP_OK);
        } else {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    }

    /**
     * Search for an educational content
     *
     * @param
     *
     * @return \Illuminate\Http\Response
     */
    public function search()
    {
        return redirect('/c', Response::HTTP_MOVED_PERMANENTLY);
    }
}
