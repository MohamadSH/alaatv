<?php

namespace App\Http\Controllers\Web;

use Auth;
use App\User;
use App\Product;
use App\Mbtianswer;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class MbtianswerController extends Controller
{
    protected $response;

    protected $numberOfQuestions;

    function __construct()
    {
        /** setting permissions
         *
         */
        $this->middleware('permission:'.config('constants.LIST_MBTIANSWER_ACCESS'), ['only' => 'index']);
    
        $this->response          = new Response();
        $this->numberOfQuestions = config('constants.MBTI_NUMBER_OF_QUESTIONS');
    }

    public function index()
    {
        $mbtiAnswers = Mbtianswer::all()
            ->sortByDesc("created_at");

        return view("mbti.index", compact("mbtiAnswers"));
    }

    public function create()
    {
        $action = Input::get("action");
        if (strcmp($action, "correctExam") == 0) {
            if (!Auth::user()
                ->can(config('constants.LIST_MBTIANSWER_ACCESS'))) {
                redirect(action("Web\HomeController@error403"));
            }
            $userId = Input::get("user_id");
            if (!isset($userId)) {
                redirect(action("Web\HomeController@error404"));
            }
            $pageMode   = "correctExam";
            $mbtiAnswer = Mbtianswer::all()
                ->where("user_id", $userId)
                ->first();
            if (isset($mbtiAnswer)) {
                $answers = json_decode($mbtiAnswer->answers);
            }
        } else {
            if (!$this->isAuthorized()) {
                return redirect(action("Web\HomeController@error403"));
            }
            $takenExam = $this->userHasTakenMBTI(Auth::user());
            $pageMode  = "takeExam";
        }
        $pageName  = "MBTI";
        $questions = collect([
            1  => "دوست دارم حرف بزنم،بشنوم و تفسیر کنم ",
            2  => "من انتقاد شخص را به دل می گیرم. می گویند که من بیش از اندازه حساس هستم",
            3  => "دوست دارم برای هر چیزی جایی داشته باشم و همه چیزهایم در جای خودش باشد",
            4  => "من از اینجا و اکنون لذت می برم",
            5  => "طبق برنامه بودن برای من مهمترین چیز زندکی نیست",
            6  => "قبل از اینکه حرف بزنم مدتی وقت می گذرانم و فکر می کنم که چه باید بگویم",
            7  => "اگر مدتی طولانی تنها بمانم ، احساس بیقراری فراوان و تنهایی می کنم",
            8  => "اگر محیط من سازمان یافته نباشد برایم آرام گرفتن دشوار میشود",
            9  => "رعایت ادب به اندازه صداقت اهمیت دارد",
            10 => "از صحبت کردن با دیگران انرژی می گیرم",
            11 => "اشخاص گاهی مرا تحلیل گر می پندارند",
            12 => "باید مراقب باشم تا به دیگران هم فرصت حرف زدن بدهم",
            13 => "در برنامه های اجتماعی و در میهمانیهایی که دیگران را نمی شناسم راحت نیستم. اما ترجیح می دهم با کسی که او را می شناسم گفتگوی دو نفره داشته باشم",
            14 => "بدنبال پیدا کردن چیزهای خوب در افراد و چیزها هستم",
            15 => "وقتی با اشخاص مخالفت می کنم ، برای من دشوار است موضوع را با آنها در میان بگذارم",
            16 => "دوست دارم درباره برنامه ها و چارچوب های زمانی اطلاع پیدا کنم . اگر برنامه ای در کار نباشد ناراحت می شوم",
            17 => "تقریبا با هر کس حرفی برای صحبت پیدا می کنم",
            18 => "دوست دارم عملی و واقع بین باشم",
            19 => "من فضای میان سطرها را می خوانم و به مطالبی که مطرح نشده اند فکر می کنم",
            20 => "به نظر من صادق بودن بهتر از رعایت جنبه های ادب است",
            21 => "من به تصویرهای بزرگ و کلی توجه می کنم. دوست ندارم به جزئیات بپردازم",
            22 => "من همدل و مهربان هستم",
            23 => "دوست ندارم کارم را ناتمام رها کنم.دوست دارم قبل از شروع هر پروژه ، پروژه قبلی را تمام کنم",
            24 => "من کارها را به سبک و روش خودم انجام می دهم.دوست ندارم دیگران بخواهند به خصوص در آخرین لحظه برنامه مرا تغییر دهند",
            25 => "من دوستان و آشنایان فراوان دارم",
            26 => "درباره اينکه با چه کسی طرح دوستی بریزم بسیار انتخابی عمل میکنم",
            27 => "من تصمیم گیری ها را به تعویق می اندازم . اغلب آنقدر اطلاعات جمع می کنم تا وقت تصمیم گیری الزامی می شود",
            28 => "دوست ندارم احساساتم را به نمایش بگذارم",
            29 => "دوست دارم وقت زیادی را به تنهایی بگذرانم",
            30 => "من در ملاقات و بودن با اشخاص جدید راحت هستم",
            31 => "دوست دارم از مهارتهایی که دارم استفاده کنم و آنها را بهتر کنم",
            32 => "ترجیح می دهم تعداد معدودی دوست داشته باشم",
            33 => "دوست ندارم کانون توجه باشم",
            34 => "اهل صحبت هستم و اغلب ارتباط کلامی را به ارتباط کتبی ترجیح می دهم",
            35 => "شناختن من نسبتا آسان است و من در نظر دیگران شخصی دوستانه و معاشرتی هستم",
            36 => "اشخاص اغلب مرا خجالتی ارزیابی می کنند",
            37 => "دوست دارم پروژه های جدید را شروع کنم . معمولا قبل از تمام کردن پروژه قبلی به سراغ پروژه بعدی می روم",
            38 => "برایم به موقع و سر وقت بودن مهم است و برایم عجیب است که چرا این برای دیگران در اولویت قرار ندارد",
            39 => "ترجیح می دهم به جای اینکه من به سمت دیگران بروم ، دیگران به سمت من بیایند",
            40 => "دوست دارم درباره روابط میان فردی و احساساتم صحبت کنم",
            41 => "اگر زمان زیادی با اشخاص صرف کنم حوصله ام سر می رود. حتی صحبت تلفنی اگر طولانی شود مرا خسته می کند",
            42 => "دوست دارم به امکانات جدید و به آنچه ممکن است وجود داشته باشد فکر کنم",
            43 => "من متهم شده ام که به نیازها و احساسات دیگران بها نمی دهم",
            44 => "من با صحبت کردن به نتیجه گیری می رسم. من با صدای بلند فکر می کنم",
            45 => "می توانم رک و بی پرده باشم",
            46 => "دوست دارم درباره نقطه نظرم بحث کنم.گاهی فقط برای رقابت ذهنی ، درباره هر دو جنبه یک مسئله بحث می کنم",
            47 => "من مشاهده گر خوبی هستم . به اطرافم نگاه می کنم و اغلب جزئیات را به خاطر می سپارم",
            48 => "مردم مرا به خاطر گرما وصمیمتم می خواهند",
            49 => "طرز سازمان دادن به اتاق یا دفتر کارم در نظر دیگران نمونه آشفتگی است",
            50 => "مورد تعریف و قدرشناسی واقع شدن برای من بسیار مهم است",
            51 => "من به نسبت راحت، تطبیق پذیر و با انعطاف هستم . وقتی در آخرین لحظه تغییری ایجاد می شود ، خودم را با آن تطبیق می دهم",
            52 => "من به الهام و برخورد اول و تصور برای کسب اطلاعات متکی هستم",
            53 => "ترجیح می دهم به تنهایی روی پروژه ها کار کنم",
            54 => "برای من توجه کردن به حال حاضر دشوار است.چون من اغلب درباره چند موضوع و مورد مختلف در آن واحد فکر می کنم",
            55 => "من اغلب بر اساس عدالت و منطق تصمیم می گیرم ، نه بر اساس موضوعات شخصی",
            56 => "من به اندیشه دیگران بیش از احساس آنها بها می دهم",
            57 => "اغلب سعی می کنم تا ضرب الاجل نزدیک شود و بعد پروژه را تمام کنم",
            58 => "من به ارقام و آمار بیش از نظریه توجه می کنم",
            59 => "مجبور نیستم که کارم را تمام کنم تا بتوانم آرام بگیرم و استراحت کنم",
            60 => "به جای توجه به آينده دور به آنچه در دست است توجه دارم",
            61 => "من معمولا فهرست کارهایی را که باید انجام بدهم تهیه نمی کنم",
            62 => "در فرایند تصمیم گیری ، برایم بسیار مهم است که تصمیم من روی دیگران چه تاثیری دارد",
            63 => "قبل از اینکه بتوانم استراحت کنم باید کارم را تمام کنم",
            64 => "من از انتزاع و نظریه خوشم می آید و گاهی توجه به جزئیات زندگی روزمره کسل کننده است",
            65 => "من از اصلاح کردن و انتقاد نمودن از دیگران خجالت نمی کشم",
            66 => "می توانم به خوبی فکر کنم و تصمیم بگیرم",
            67 => "من کارهایی را دوست دارم که کاربرد عملی داشته باشد و نتایج ملموس تولید کند",
            68 => "صحبت کردن درباره خواسته هایم برای من دشوار است",
            69 => "نه اینکه من چیزی توجه ندارم . من به شیوه خودم عمل می کنم و از یک پروژه به سراغ پروژه بعدی می روم",
            70 => "دوست دارم کانون توجه باشم",
            71 => "من به کاربردها و استنباطها توجه دارم",
            72 => "به هنگام توضیح دادن و توصیف کردن چیزی از استعاره و قیاس استفاده می کنم",
            73 => "من به آینده نظر دارم و دوست دارم کارهای نو و ابتکاری بکنم و از کارهای تکراری و مشخص بدم می آید",
            74 => "قبل از آنکه پروژه ای را شروع کنم به این فکر می کنم که چه نیازی دارم . دقت می کنم که همه چیز سر جای خود باشد",
            75 => "دوست ندارم موضوعی را بدون تصمیم گیری رها کنم",
            76 => "من به تجربه شخصی خود از چیزهای واقعی و مشخص، اعتماد می کنم",
            77 => "من به آنچه در پبرامونم می گذرد توجه کمی دارم. به اینجا و اکنون توجه نمی کنم",
            78 => "فهرستی از کارهایی را که باید انجام دهم تهیه می کنم و بعد هر کاری را که انجام دادم با علامت مشخص می نمایم",
            79 => "پروژه های دستی مثل ، ساختن مدل های اتومبیل ، سوار کردن چیزها یا سوزن دوزی را دوست دارم",
            80 => "من از چیزهای غیره منتظره لذت می برم",
        ]);

        //soal 34 avaz shod
        return view("mbti.create", compact("pageName", "questions", "pageMode", "takenExam", "mbtiAnswer", "answers"));
    }

    /**
     * Checks whether user is authorized to take the exxam or not
     *
     * @return boolean
     */
    private function isAuthorized()
    {
        $userOrdoo = Auth::user()
            ->orders()
            ->whereHas('orderproducts', function ($q) {
                $q->whereIn("product_id", Product::whereHas('parents', function ($q) {
                    $q->whereIn("parent_id", [
                        1,
                        13,
                    ]);
                })
                    ->pluck("id"));
            })
            ->whereIn("orderstatus_id", [config("constants.ORDER_STATUS_CLOSED")])
            ->get();
    
        return $userOrdoo->isEmpty() && !Auth::user()
            ->hasRole(config('constants.ROLE_ADMIN')) ? false : true;
    }
    
    /**
     * Checks whether user has taken MBTI or not
     *
     * \App\User $user
     *
     * @return boolean
     */
    private function userHasTakenMBTI(User $user)
    {
        $userAnswers = Mbtianswer::all()
            ->where("user_id", $user->id);
    
        return $userAnswers->isEmpty() ? false : true;
    }

    public function store(Request $request)
    {
        if (!$this->isAuthorized() || $this->userHasTakenMBTI(Auth::user())) {
            return $this->response->setStatusCode(403);
        }
    
        $answers = [];
        for ($i = 1; $i <= $this->numberOfQuestions; $i++) {
            if ($request->has("question".$i)) {
                array_push($answers, $request->get("question".$i));
            }
        }
    
        if (count($answers) != $this->numberOfQuestions) {
            return $this->response->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);
        }
    
        $mbtiAnswer          = new Mbtianswer();
        $mbtiAnswer->user_id = Auth::user()->id;
        $mbtiAnswer->answers = json_encode($answers, JSON_UNESCAPED_UNICODE);
        if (!$mbtiAnswer->save()) {
            return $this->response->setStatusCode(Response::HTTP_SERVICE_UNAVAILABLE);
        }
    
        return $this->response->setStatusCode(Response::HTTP_OK);
    }

    public function show(Mbtianswer $mbtianswer)
    {
        $answers = json_decode($mbtianswer->answers);
        dd(count($answers));
    }

    /**
     * Display a description about MBTI and a link to begin the exam
     *
     * @return \Illuminate\Http\Response
     */
    public function introduction()
    {
        if ($this->isAuthorized()) {
            $pageName = "MBTI";
    
            return view("mbti.intro", compact("pageName"));
        } else {
            return redirect(action("Web\HomeController@error403"));
        }
    }
}
