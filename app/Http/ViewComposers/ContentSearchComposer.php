<?php

namespace App\Http\ViewComposers;


use App\Traits\CharacterCommon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContentSearchComposer
{
    use CharacterCommon;


    protected $request;

    /**
     * Create a new ContentSearch composer.
     *
     * @param  Request  $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     *
     * @return void
     */
    public function compose(View $view)
    {
        $sideBarMode = "closed";
        list($ads1, $ads2, $tags, $extraTags, $filterData) = $this->getData();

        $view->with(compact('sideBarMode', 'ads1', 'ads2', 'tags', 'extraTags', 'filterData'));
    }

    /**
     * @return array
     */
    private function getData(): array
    {
        [
            $ads1,
            $ads2,
        ] = $this->getAdsArray();
        [
            $tags,
            $extraTags,
        ] = $this->getTags();

        $filterData = $this->getFilterdData();
        return [
            $ads1,
            $ads2,
            $tags,
            $extraTags,
            $filterData,
        ];
    }

    /**
     * @return array
     */
    private function getAdsArray(): array
    {
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
        return [
            $ads1,
            $ads2,
        ];
    }

    /**
     * @return array
     */
    private function getTags(): array
    {
        /**
         * Page inputs
         */
        $tags = [];
        if ($this->request->has("tags")) {
            $tags = $this->request->tags;
        }

        $extraTags = [];
        return [
            $tags,
            $extraTags,
        ];
    }

    /**
     * @return array
     */
    private function getFilterdData(): array
    {
        $lessonTeacher  = collect([
            ""                    => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "ثابتی",
                    "firstName" => "محمد صادق",
                    "value"     => "محمد_صادق_ثابتی",
                ],
                [
                    "lastName"  => "نصیری",
                    "firstName" => "سیروس",
                    "value"     => "سیروس_نصیری",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "شهریان",
                    "firstName" => "محسن",
                    "value"     => "محسن_شهریان",
                ],
                [
                    "lastName"  => "مؤذنی پور",
                    "firstName" => "بهمن",
                    "value"     => "بهمن_مؤذنی_پور",
                ],
                [
                    "lastName"  => "معینی",
                    "firstName" => "سروش",
                    "value"     => "سروش_معینی",
                ],
                [
                    "lastName"  => "شاه محمدی",
                    "firstName" => "",
                    "value"     => "شاه_محمدی",
                ],
                [
                    "lastName"  => "حسینی فرد",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_حسینی_فرد",
                ],
                [
                    "lastName"  => "کبریایی",
                    "firstName" => "وحید",
                    "value"     => "وحید_کبریایی",
                ],
                [
                    "lastName"  => "مرصعی",
                    "firstName" => "حسن",
                    "value"     => "حسن_مرصعی",
                ],
                [
                    "lastName"  => "مقصودی",
                    "firstName" => "محمدرضا",
                    "value"     => "محمدرضا_مقصودی",
                ],
                [
                    "lastName"  => "رحیمی",
                    "firstName" => "شهروز",
                    "value"     => "شهروز_رحیمی",
                ],
                [
                    "lastName"  => "کرد",
                    "firstName" => "حسین",
                    "value"     => "حسین_کرد",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
                [
                    "lastName"  => "نایب کبیر",
                    "firstName" => "جواد",
                    "value"     => "جواد_نایب_کبیر",
                ],
                [
                    "lastName"  => "نباخته",
                    "firstName" => "محمدامین",
                    "value"     => "محمدامین_نباخته",
                ],
                [
                    "lastName"  => "صدری",
                    "firstName" => "علی",
                    "value"     => "علی_صدری",
                ],
                [
                    "lastName"  => "محمد زاده",
                    "firstName" => "خسرو",
                    "value"     => "خسرو_محمد_زاده",
                ],
                [
                    "lastName"  => "علیمرادی",
                    "firstName" => "پدرام",
                    "value"     => "پدرام_علیمرادی",
                ],
                [
                    "lastName"  => "ناصح زاده",
                    "firstName" => "میلاد",
                    "value"     => "میلاد_ناصح_زاده",
                ],
                [
                    "lastName"  => "جلادتی",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_جلادتی",
                ],
                [
                    "lastName"  => "ناصر شریعت",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_ناصر_شریعت",
                ],
                [
                    "lastName"  => "تاج بخش",
                    "firstName" => "عمار",
                    "value"     => "عمار_تاج_بخش",
                ],
                [
                    "lastName"  => "حشمتی",
                    "firstName" => "ناصر",
                    "value"     => "ناصر_حشمتی",
                ],
                [
                    "lastName"  => "آهویی",
                    "firstName" => "محسن",
                    "value"     => "محسن_آهویی",
                ],
                [
                    "lastName"  => "رنجبرزاده",
                    "firstName" => "جعفر",
                    "value"     => "جعفر_رنجبرزاده",
                ],
                [
                    "lastName"  => "آقاجانی",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_آقاجانی",
                ],
                [
                    "lastName"  => "صنیعی طهرانی",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_صنیعی_طهرانی",
                ],
                [
                    "lastName"  => "حسین انوشه",
                    "firstName" => "محمد",
                    "value"     => "محمد_حسین_انوشه",
                ],
                [
                    "lastName"  => "حسین شکیباییان",
                    "firstName" => "محمد",
                    "value"     => "محمد_حسین_شکیباییان",
                ],
                [
                    "lastName"  => "پویان نظر",
                    "firstName" => "حامد",
                    "value"     => "حامد_پویان_نظر",
                ],
                [
                    "lastName"  => "حاجی سلیمانی",
                    "firstName" => "روح الله",
                    "value"     => "روح_الله_حاجی_سلیمانی",
                ],
                [
                    "lastName"  => "معینی",
                    "firstName" => "محسن",
                    "value"     => "محسن_معینی",
                ],
                [
                    "lastName"  => "جعفری",
                    "firstName" => "",
                    "value"     => "جعفری",
                ],
                [
                    "lastName"  => "طلوعی",
                    "firstName" => "پیمان",
                    "value"     => "پیمان_طلوعی",
                ],
                [
                    "lastName"  => "فدایی فرد",
                    "firstName" => "حمید",
                    "value"     => "حمید_فدایی_فرد",
                ],
                [
                    "lastName"  => "رمضانی",
                    "firstName" => "علیرضا",
                    "value"     => "علیرضا_رمضانی",
                ],
                [
                    "lastName"  => "داداشی",
                    "firstName" => "فرشید",
                    "value"     => "فرشید_داداشی",
                ],
                [
                    "lastName"  => "کازرانیان",
                    "firstName" => "",
                    "value"     => "کازرانیان",
                ],
                [
                    "lastName"  => "نادریان",
                    "firstName" => "",
                    "value"     => "نادریان",
                ],
                [
                    "lastName"  => "جهانبخش",
                    "firstName" => "",
                    "value"     => "جهانبخش",
                ],
                [
                    "lastName"  => "عزتی",
                    "firstName" => "علی اکبر",
                    "value"     => "علی_اکبر_عزتی",
                ],
                [
                    "lastName"  => "فراهانی",
                    "firstName" => "کیاوش",
                    "value"     => "کیاوش_فراهانی",
                ],
                [
                    "lastName"  => "درویش",
                    "firstName" => "",
                    "value"     => "درویش",
                ],
                [
                    "lastName"  => "تفتی",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_تفتی",
                ],
                [
                    "lastName"  => "سبطی",
                    "firstName" => "هامون",
                    "value"     => "هامون_سبطی",
                ],
                [
                    "lastName"  => "راوش",
                    "firstName" => "داریوش",
                    "value"     => "داریوش_راوش",
                ],
                [
                    "lastName"  => "مرادی",
                    "firstName" => "عبدالرضا",
                    "value"     => "عبدالرضا_مرادی",
                ],
                [
                    "lastName"  => "صادقی",
                    "firstName" => "محمد",
                    "value"     => "محمد_صادقی",
                ],
                [
                    "lastName"  => "کاظمی",
                    "firstName" => "کاظم",
                    "value"     => "کاظم_کاظمی",
                ],
                [
                    "lastName"  => "حسین خانی",
                    "firstName" => "میثم",
                    "value"     => "میثم__حسین_خانی",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "محمد علی",
                    "value"     => "محمد_علی_امینی_راد",
                ],
                [
                    "lastName"  => "پازوکی",
                    "firstName" => "محمد",
                    "value"     => "محمد_پازوکی",
                ],
                [
                    "lastName"  => "راستی بروجنی",
                    "firstName" => "عباس",
                    "value"     => "عباس_راستی_بروجنی",
                ],
                [
                    "lastName"  => "جعفری",
                    "firstName" => "ابوالفضل",
                    "value"     => "ابوالفضل_جعفری",
                ],
                [
                    "lastName"  => "موقاری",
                    "firstName" => "جلال",
                    "value"     => "جلال_موقاری",
                ],
                [
                    "lastName"  => "رحیمی",
                    "firstName" => "پوریا",
                    "value"     => "پوریا_رحیمی",
                ],
                [
                    "lastName"  => "حدادی",
                    "firstName" => "مسعود",
                    "value"     => "مسعود_حدادی",
                ],
                [
                    "lastName"  => "ارشی",
                    "firstName" => "",
                    "value"     => "ارشی",
                ],
                [
                    "lastName"  => "آقاجانی",
                    "firstName" => "رضا",
                    "value"     => "رضا_آقاجانی",
                ],
                [
                    "lastName"  => "جلالی",
                    "firstName" => "سید حسام الدین",
                    "value"     => "سید_حسام_الدین_جلالی",
                ],
                [
                    "lastName"  => "بهمند",
                    "firstName" => "یاشار",
                    "value"     => "یاشار_بهمند",
                ],
                [
                    "lastName"  => "جعفری نژاد",
                    "firstName" => "مصطفی",
                    "value"     => "مصطفی_جعفری_نژاد",
                ],
                [
                    "lastName"  => "زاهدی",
                    "firstName" => "امید",
                    "value"     => "امید_زاهدی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "دیفرانسیل"           => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "ثابتی",
                    "firstName" => "محمد صادق",
                    "value"     => "محمد_صادق_ثابتی",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "شهریان",
                    "firstName" => "محسن",
                    "value"     => "محسن_شهریان",
                ],
                [
                    "lastName"  => "نصیری",
                    "firstName" => "سیروس",
                    "value"     => "سیروس_نصیری",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "گسسته"               => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "مؤذنی پور",
                    "firstName" => "بهمن",
                    "value"     => "بهمن_مؤذنی_پور",
                ],
                [
                    "lastName"  => "معینی",
                    "firstName" => "سروش",
                    "value"     => "سروش_معینی",
                ],
                [
                    "lastName"  => "محمدی",
                    "firstName" => "شاه",
                    "value"     => "شاه_محمدی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "تحلیلی"              => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "ثابتی",
                    "firstName" => "محمد صادق",
                    "value"     => "محمد_صادق_ثابتی",
                ],
                [
                    "lastName"  => "حسینی فرد",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_حسینی_فرد",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "هندسه_پایه"          => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "کبریایی",
                    "firstName" => "وحید",
                    "value"     => "وحید_کبریایی",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "حسینی فرد",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_حسینی_فرد",
                ],
                [
                    "lastName"  => "مرصعی",
                    "firstName" => "حسن",
                    "value"     => "حسن_مرصعی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "حسابان"              => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "ثابتی",
                    "firstName" => "محمد صادق",
                    "value"     => "محمد_صادق_ثابتی",
                ],
                [
                    "lastName"  => "مقصودی",
                    "firstName" => "محمدرضا",
                    "value"     => "محمدرضا_مقصودی",
                ],
                [
                    "lastName"  => "رحیمی",
                    "firstName" => "شهروز",
                    "value"     => "شهروز_رحیمی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "جبر_و_احتمال"        => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "کرد",
                    "firstName" => "حسین",
                    "value"     => "حسین_کرد",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "ریاضی_پایه"          => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
                [
                    "lastName"  => "نایب کبیر",
                    "firstName" => "جواد",
                    "value"     => "جواد_نایب_کبیر",
                ],
                [
                    "lastName"  => "شهریان",
                    "firstName" => "محسن",
                    "value"     => "محسن_شهریان",
                ],
                [
                    "lastName"  => "مقصودی",
                    "firstName" => "محمدرضا",
                    "value"     => "محمدرضا_مقصودی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "ریاضی_تجربی"         => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
                [
                    "lastName"  => "نباخته",
                    "firstName" => "محمدامین",
                    "value"     => "محمدامین_نباخته",
                ],
                [
                    "lastName"  => "حسینی فرد",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_حسینی_فرد",
                ],
                [
                    "lastName"  => "صدری",
                    "firstName" => "علی",
                    "value"     => "علی_صدری",
                ],
                [
                    "lastName"  => "ثابتی",
                    "firstName" => "محمد صادق",
                    "value"     => "محمد_صادق_ثابتی",
                ]
            ])
                ->sortBy("lastName")
                ->values(),
            "ریاضی_انسانی"        => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "محمد زاده",
                    "firstName" => "خسرو",
                    "value"     => "خسرو_محمد_زاده",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
            ])->sortBy("lastName"),
            "عربی"                => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "علیمرادی",
                    "firstName" => "پدرام",
                    "value"     => "پدرام_علیمرادی",
                ],
                [
                    "lastName"  => "ناصح زاده",
                    "firstName" => "میلاد",
                    "value"     => "میلاد_ناصح_زاده",
                ],
                [
                    "lastName"  => "جلادتی",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_جلادتی",
                ],
                [
                    "lastName"  => "ناصر شریعت",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_ناصر_شریعت",
                ],
                [
                    "lastName"  => "تاج بخش",
                    "firstName" => "عمار",
                    "value"     => "عمار_تاج_بخش",
                ],
                [
                    "lastName"  => "حشمتی",
                    "firstName" => "ناصر",
                    "value"     => "ناصر_حشمتی",
                ],
                [
                    "lastName"  => "آهویی",
                    "firstName" => "محسن",
                    "value"     => "محسن_آهویی",
                ],
                [
                    "lastName"  => "رنجبرزاده",
                    "firstName" => "جعفر",
                    "value"     => "جعفر_رنجبرزاده",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "شیمی"                => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "آقاجانی",
                    "firstName" => "محمد رضا",
                    "value"     => "محمد_رضا_آقاجانی",
                ],
                [
                    "lastName"  => "طهرانی",
                    "firstName" => "مهدی صنیعی",
                    "value"     => "مهدی_صنیعی_طهرانی",
                ],
                [
                    "lastName"  => "انوشه",
                    "firstName" => "محمد حسین",
                    "value"     => "محمد_حسین_انوشه",
                ],
                [
                    "lastName"  => "شکیباییان",
                    "firstName" => "محمد حسین ",
                    "value"     => "محمد_حسین_شکیباییان",
                ],
                [
                    "lastName"  => "پویان نظر",
                    "firstName" => "حامد ",
                    "value"     => "حامد_پویان_نظر",
                ],
                [
                    "lastName"  => "حاجی سلیمانی",
                    "firstName" => "روح الله ",
                    "value"     => "روح_الله_حاجی_سلیمانی",
                ],
                [
                    "lastName"  => "معینی",
                    "firstName" => "محسن ",
                    "value"     => "محسن_معینی",
                ],
                [
                    "lastName"  => "جعفری",
                    "firstName" => "",
                    "value"     => "جعفری",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "فیزیک"               => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "طلوعی",
                    "firstName" => "پیمان",
                    "value"     => "پیمان_طلوعی",
                ],
                [
                    "lastName"  => "فدایی فرد",
                    "firstName" => "حمید",
                    "value"     => "حمید_فدایی_فرد",
                ],
                [
                    "lastName"  => "رمضانی",
                    "firstName" => "علیرضا",
                    "value"     => "علیرضا_رمضانی",
                ],
                [
                    "lastName"  => "داداشی",
                    "firstName" => "فرشید",
                    "value"     => "فرشید_داداشی",
                ],
                [
                    "lastName"  => "کازرانیان",
                    "firstName" => "",
                    "value"     => "کازرانیان",
                ],
                [
                    "lastName"  => "نادریان",
                    "firstName" => "",
                    "value"     => "نادریان",
                ],
                [
                    "lastName"  => "جهانبخش",
                    "firstName" => "",
                    "value"     => "جهانبخش",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "زبان_انگلیسی"        => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "عزتی",
                    "firstName" => "علی اکبر",
                    "value"     => "علی_اکبر_عزتی",
                ],
                [
                    "lastName"  => "فراهانی",
                    "firstName" => "کیاوش",
                    "value"     => "کیاوش_فراهانی",
                ],
                [
                    "lastName"  => "درویش",
                    "firstName" => "",
                    "value"     => "درویش",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "دین_و_زندگی"         => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "تفتی",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_تفتی",
                ],
                [
                    "lastName"  => "رنجبرزاده",
                    "firstName" => "جعفر",
                    "value"     => "جعفر_رنجبرزاده",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "زبان_و_ادبیات_فارسی" => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "سبطی",
                    "firstName" => "هامون",
                    "value"     => "هامون_سبطی",
                ],
                [
                    "lastName"  => "راوش",
                    "firstName" => "داریوش",
                    "value"     => "داریوش_راوش",
                ],
                [
                    "lastName"  => "مرادی",
                    "firstName" => "عبدالرضا",
                    "value"     => "عبدالرضا_مرادی",
                ],
                [
                    "lastName"  => "صادقی",
                    "firstName" => "محمد",
                    "value"     => "محمد_صادقی",
                ],
                [
                    "lastName"  => "کاظمی",
                    "firstName" => "کاظم",
                    "value"     => "کاظم_کاظمی",
                ],
                [
                    "lastName"  => "خانی حسین",
                    "firstName" => "میثم",
                    "value"     => "میثم__حسین_خانی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "آمار_و_مدلسازی"      => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "شامیزاده",
                    "firstName" => "رضا",
                    "value"     => "رضا_شامیزاده",
                ],
                [
                    "lastName"  => "کبریایی",
                    "firstName" => "وحید",
                    "value"     => "وحید_کبریایی",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "زیست_شناسی"          => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "محمد علی",
                    "value"     => "محمد_علی_امینی_راد",
                ],
                [
                    "lastName"  => "پازوکی",
                    "firstName" => "محمد",
                    "value"     => "محمد_پازوکی",
                ],
                [
                    "lastName"  => "راستی بروجنی",
                    "firstName" => "عباس",
                    "value"     => "عباس_راستی_بروجنی",
                ],
                [
                    "lastName"  => "جعفری",
                    "firstName" => "ابوالفضل",
                    "value"     => "ابوالفضل_جعفری",
                ],
                [
                    "lastName"  => "موقاری",
                    "firstName" => "جلال",
                    "value"     => "جلال_موقاری",
                ],
                [
                    "lastName"  => "رحیمی",
                    "firstName" => "پوریا",
                    "value"     => "پوریا_رحیمی",
                ],
                [
                    "lastName"  => "حدادی",
                    "firstName" => "مسعود",
                    "value"     => "مسعود_حدادی",
                ],
                [
                    "lastName"  => "ارشی",
                    "firstName" => "",
                    "value"     => "ارشی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "ریاضی_و_آمار"        => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "مهدی",
                    "value"     => "مهدی_امینی_راد",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "منطق"                => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "آقاجانی",
                    "firstName" => "رضا",
                    "value"     => "رضا_آقاجانی",
                ],
                [
                    "lastName"  => "الدین جلالی",
                    "firstName" => "سید حسام",
                    "value"     => "سید_حسام_الدین_جلالی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "المپیاد_فیزیک"       => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "جعفری نژاد",
                    "firstName" => "مصطفی",
                    "value"     => "مصطفی_جعفری_نژاد",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "المپیاد_نجوم"        => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "بهمند",
                    "firstName" => "یاشار",
                    "value"     => "یاشار_بهمند",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
            "مشاوره"              => collect([
                [
                    "index"     => "همه دبیرها",
                    "firstName" => "",
                    "value"     => "",
                ],
                [
                    "lastName"  => "امینی راد",
                    "firstName" => "محمد علی",
                    "value"     => "محمد_علی_امینی_راد",
                ],
                [
                    "lastName"  => "زاهدی",
                    "firstName" => "امید",
                    "value"     => "امید_زاهدی",
                ],
            ])
                ->sortBy("lastName")
                ->values(),
        ]);
        $allLessons     = collect([
            [
                "value"        => "",
                "initialIndex" => "همه دروس",
            ],
            [
                "value" => "مشاوره",
                "index" => "مشاوره",
            ],
            [
                "value" => "دیفرانسیل",
                "index" => "دیفرانسیل",
            ],
            [
                "value" => "تحلیلی",
                "index" => "تحلیلی",
            ],
            [
                "value" => "گسسته",
                "index" => "گسسته",
            ],
            [
                "value" => "حسابان",
                "index" => "حسابان",
            ],
            [
                "value" => "جبر_و_احتمال",
                "index" => "جبر و احتمال",
            ],
            [
                "value" => "ریاضی_پایه",
                "index" => "ریاضی پایه",
            ],
            [
                "value" => "هندسه_پایه",
                "index" => "هندسه پایه",
            ],
            [
                "value" => "فیزیک",
                "index" => "فیزیک",
            ],
            [
                "value" => "شیمی",
                "index" => "شیمی",
            ],
            [
                "value" => "عربی",
                "index" => "عربی",
            ],
            [
                "value" => "زبان_و_ادبیات_فارسی",
                "index" => "زبان و ادبیات فارسی",
            ],
            [
                "value" => "دین_و_زندگی",
                "index" => "دین و زندگی",
            ],
            [
                "value" => "زبان_انگلیسی",
                "index" => "زبان انگلیسی",
            ],
            [
                "value" => "آمار_و_مدلسازی",
                "index" => "آمار و مدلسازی",
            ],
            [
                "value" => "زیست_شناسی",
                "index" => "زیست شناسی",
            ],
            [
                "value" => "ریاضی_تجربی",
                "index" => "ریاضی تجربی",
            ],
            [
                "value" => "ریاضی_انسانی",
                "index" => "ریاضی انسانی",
            ],
            [
                "value" => "ریاضی_و_آمار",
                "index" => "ریاضی و آمار",
            ],
            [
                "value" => "منطق",
                "index" => "منطق",
            ],
            [
                "value" => "اخلاق",
                "index" => "اخلاق",
            ],
            [
                "value" => "المپیاد_نجوم",
                "index" => "المپیاد نجوم",
            ],
            [
                "value" => "المپیاد_فیزیک",
                "index" => "المپیاد فیزیک",
            ],
        ])
            ->sortBy("index")
            ->values();
        $riaziLessons   = collect([
            [
                "value"        => "",
                "initialIndex" => "همه دروس",
            ],
            [
                "value" => "مشاوره",
                "index" => "مشاوره",
            ],
            [
                "value" => "دیفرانسیل",
                "index" => "دیفرانسیل",
            ],
            [
                "value" => "تحلیلی",
                "index" => "تحلیلی",
            ],
            [
                "value" => "گسسته",
                "index" => "گسسته",
            ],
            [
                "value" => "حسابان",
                "index" => "حسابان",
            ],
            [
                "value" => "جبر_و_احتمال",
                "index" => "جبر و احتمال",
            ],
            [
                "value" => "ریاضی_پایه",
                "index" => "ریاضی پایه",
            ],
            [
                "value" => "هندسه_پایه",
                "index" => "هندسه پایه",
            ],
            [
                "value" => "فیزیک",
                "index" => "فیزیک",
            ],
            [
                "value" => "شیمی",
                "index" => "شیمی",
            ],
            [
                "value" => "عربی",
                "index" => "عربی",
            ],
            [
                "value" => "زبان_و_ادبیات_فارسی",
                "index" => "زبان و ادبیات فارسی",
            ],
            [
                "value" => "دین_و_زندگی",
                "index" => "دین و زندگی",
            ],
            [
                "value" => "زبان_انگلیسی",
                "index" => "زبان انگلیسی",
            ],
            [
                "value" => "آمار_و_مدلسازی",
                "index" => "آمار و مدلسازی",
            ],
            [
                "value" => "المپیاد_نجوم",
                "index" => "المپیاد نجوم",
            ],
            [
                "value" => "المپیاد_فیزیک",
                "index" => "المپیاد فیزیک",
            ],
        ])
            ->sortBy("index")
            ->values();
        $tajrobiLessons = collect([
            [
                "value"        => "",
                "initialIndex" => "همه دروس",
            ],
            [
                "value" => "مشاوره",
                "index" => "مشاوره",
            ],
            [
                "value" => "زیست_شناسی",
                "index" => "زیست شناسی",
            ],
            [
                "value" => "ریاضی_تجربی",
                "index" => "ریاضی تجربی",
            ],
            [
                "value" => "ریاضی_پایه",
                "index" => "ریاضی پایه",
            ],
            [
                "value" => "هندسه_پایه",
                "index" => "هندسه پایه",
            ],
            [
                "value" => "فیزیک",
                "index" => "فیزیک",
            ],
            [
                "value" => "شیمی",
                "index" => "شیمی",
            ],
            [
                "value" => "عربی",
                "index" => "عربی",
            ],
            [
                "value" => "زبان_و_ادبیات_فارسی",
                "index" => "زبان و ادبیات فارسی",
            ],
            [
                "value" => "دین_و_زندگی",
                "index" => "دین و زندگی",
            ],
            [
                "value" => "زبان_انگلیسی",
                "index" => "زبان انگلیسی",
            ],
            [
                "value" => "آمار_و_مدلسازی",
                "index" => "آمار و مدلسازی",
            ],
            [
                "value" => "المپیاد_نجوم",
                "index" => "المپیاد نجوم",
            ],
            [
                "value" => "المپیاد_فیزیک",
                "index" => "المپیاد فیزیک",
            ],
        ])
            ->sortBy("index")
            ->values();
        $ensaniLessons  = collect([
            [
                "value"        => "",
                "initialIndex" => "همه دروس",
            ],
            [
                "value" => "مشاوره",
                "index" => "مشاوره",
            ],
            [
                "value" => "ریاضی_انسانی",
                "index" => "ریاضی انسانی",
            ],
            [
                "value" => "ریاضی_و_آمار",
                "index" => "ریاضی و آمار",
            ],
            [
                "value" => "منطق",
                "index" => "منطق",
            ],
            [
                "value" => "اخلاق",
                "index" => "اخلاق",
            ],
            [
                "value" => "عربی",
                "index" => "عربی",
            ],
            [
                "value" => "زبان_و_ادبیات_فارسی",
                "index" => "زبان و ادبیات فارسی",
            ],
            [
                "value" => "دین_و_زندگی",
                "index" => "دین و زندگی",
            ],
            [
                "value" => "زبان_انگلیسی",
                "index" => "زبان انگلیسی",
            ],
            [
                "value" => "آمار_و_مدلسازی",
                "index" => "آمار و مدلسازی",
            ],
        ])
            ->sortBy("index")
            ->values();

        $filterData = [
            'lessonTeacher' => $lessonTeacher,
            'lessons'       => [
                'allLessons'     => $allLessons,
                'riaziLessons'   => $riaziLessons,
                'tajrobiLessons' => $tajrobiLessons,
                'ensaniLessons'  => $ensaniLessons,
            ],
        ];
        return $filterData;
    }

    /**
     * @param $tags
     * @param $inputs
     *
     * @return string
     */
    private function findDefault(array $tags, array $inputs)
    {
        $inputSlug = array_map(function ($input) {
            return $this->make_slug($input, '_');
        }, $inputs);
        $default   = array_intersect($tags, $inputSlug);
        if (is_array($default)) {
            $default = array_first($default);

            return array_search($default, $inputSlug);
        }

        return null;
    }
}
