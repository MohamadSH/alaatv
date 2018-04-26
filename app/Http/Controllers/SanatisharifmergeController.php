<?php

namespace App\Http\Controllers;

use App\Contentset;
use App\Sanatisharifmerge;
use App\Traits\CharacterCommon;
use App\Traits\MetaCommon;
use App\Traits\RequestCommon;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;

class SanatisharifmergeController extends Controller
{
    use CharacterCommon;
    use RequestCommon;
    use MetaCommon;
    private $response;
    private $teachers ;

    function __construct()
    {
        $this->teachers = collect([
            [
                "userid" => "2",
    "userfirstname" => "رضا",
    "userlastname" => "شامیزاده",
    "mobile" => "09991550613",
    "password" => "9651550613",
  ]
   , [
        "userid" => "3",
    "userfirstname" => "روح الله",
    "userlastname" => "حاجی سلیمانی",
    "mobile" => "09997336794",
    "password" => "7337336794"
  ]
   , [
        "userid" => "4",
    "userfirstname" => "محسن",
    "userlastname" => "شهریان",
    "mobile" => "09999692882",
    "password" => "4699692882",
  ]
   , [
        "userid" => "5",
    "userfirstname" => "علیرضا",
    "userlastname" => "رمضانی",
    "mobile" => "09997912437",
    "password" => "4957912437",
  ]
   , [
        "userid" => "6",
    "userfirstname" => "پدرام",
    "userlastname" => "علیمرادی",
    "mobile" => "09997985109",
    "password" => "5397985109",
  ]
   , [
        "userid" => "7",
    "userfirstname" => "عبدالرضا",
    "userlastname" => "مرادی",
    "mobile" => "09993707484",
    "password" => "8283707484",
  ]
   , [
        "userid" => "8",
    "userfirstname" => "علی اکبر",
    "userlastname" => "عزتی",
    "mobile" => "09994687166",
    "password" => "1014687166",
  ]
   , [
        "userid" => "9",
    "userfirstname" => "مسعود",
    "userlastname" => "حدادی",
    "mobile" => "09995776510",
    "password" => "9445776510",
  ]
   , [
        "userid" => "20",
    "userfirstname" => "محمدرضا",
    "userlastname" => "مقصودی",
    "mobile" => "09997835481",
    "password" => "1637835481",
  ]
   , [
        "userid" => "97",
    "userfirstname" => "محمد علی",
    "userlastname" => "امینی راد",
    "mobile" => "09992250618",
    "password" => "9322250618",
  ]
   , [
        "userid" => "103",
    "userfirstname" => "مهدی",
    "userlastname" => "تفتی",
    "mobile" => "09998520269",
    "password" => "5558520269",
  ]
   , [
        "userid" => "246",
    "userfirstname" => "",
    "userlastname" => "جعفری",
    "mobile" => "09992042338",
    "password" => "8912042338",
  ]
   , [
        "userid" => "274",
    "userfirstname" => "گروه آموزشی",
    "userlastname" => " ",
    "mobile" => "09996214616",
    "password" => "2706214616",
  ]
   , [
        "userid" => "307",
    "userfirstname" => "حمید",
    "userlastname" => "فدایی فرد",
    "mobile" => "09993694022",
    "password" => "6783694022",
  ]
   , [
        "userid" => "308",
    "userfirstname" => "کیاوش",
    "userlastname" => "فراهانی",
    "mobile" => "09993056881",
    "password" => "3623056881",
  ]
   , [
        "userid" => "310",
    "userfirstname" => "مصطفی",
    "userlastname" => "جعفری نژاد",
    "mobile" => "09993231211",
    "password" => "9873231211",
  ]
   , [
        "userid" => "311",
    "userfirstname" => "رفیع",
    "userlastname" => "رفیعی",
    "mobile" => "09998208012",
    "password" => "1928208012",
  ]
   , [
        "userid" => "313",
    "userfirstname" => "علی",
    "userlastname" => "صدری",
    "mobile" => "09995783188",
    "password" => "9255783188",
  ]
   , [
        "userid" => "314",
    "userfirstname" => "امید",
    "userlastname" => "زاهدی",
    "mobile" => "09998374076",
    "password" => "1978374076",
  ]
   , [
        "userid" => "315",
    "userfirstname" => "مشاوران دبیرستان",
    "userlastname" => "",
    "mobile" => "09994951579",
    "password" => "8014951579",
  ]
   , [
        "userid" => "318",
    "userfirstname" => "محسن",
    "userlastname" => "معینی",
    "mobile" => "09994478111",
    "password" => "8224478111",
  ]
   , [
        "userid" => "319",
    "userfirstname" => "میلاد",
    "userlastname" => "ناصح زاده",
    "mobile" => "09997447782",
    "password" => "1577447782",
  ]
   , [
        "userid" => "320",
    "userfirstname" => "محمد",
    "userlastname" => "پازوکی",
    "mobile" => "09996582414",
    "password" => "2046582414",
  ]
   , [
        "userid" => "321",
    "userfirstname" => "",
    "userlastname" => "جهانبخش",
    "mobile" => "09996194956",
    "password" => "4876194956",
  ]
   , [
        "userid" => "322",
    "userfirstname" => "حسن",
    "userlastname" => "مرصعی",
    "mobile" => "09991730235",
    "password" => "7661730235",
  ]
   , [
        "userid" => "323",
    "userfirstname" => "",
    "userlastname" => "بختیاری",
    "mobile" => "09993001622",
    "password" => "1943001622",
  ]
   , [
        "userid" => "324",
    "userfirstname" => "علی نقی",
    "userlastname" => "طباطبایی",
    "mobile" => "09999943651",
    "password" => "3939943651",
  ]
   , [
        "userid" => "325",
    "userfirstname" => "وحید",
    "userlastname" => "کبریایی",
    "mobile" => "09999304447",
    "password" => "4409304447",
  ]
   , [
        "userid" => "326",
    "userfirstname" => "",
    "userlastname" => "درویش",
    "mobile" => "09992097117",
    "password" => "6332097117",
  ]
   , [
        "userid" => "363",
    "userfirstname" => "",
    "userlastname" => "صابری",
    "mobile" => "09997208997",
    "password" => "8467208997",
  ]
   , [
        "userid" => "364",
    "userfirstname" => "",
    "userlastname" => "ارشی",
    "mobile" => "09999062941",
    "password" => "8279062941",
  ]
   , [
        "userid" => "366",
    "userfirstname" => "جعفر",
    "userlastname" => "رنجبرزاده",
    "mobile" => "09990856015",
    "password" => "5380856015",
  ]
   , [
        "userid" => "367",
    "userfirstname" => "محمد رضا",
    "userlastname" => "آقاجانی",
    "mobile" => "09996370036",
    "password" => "2836370036",
  ]
   , [
        "userid" => "478",
    "userfirstname" => "محمد رضا ",
    "userlastname" => "حسینی فرد",
    "mobile" => "09996503218",
    "password" => "6396503218",
  ]
   , [
        "userid" => "533",
    "userfirstname" => "محمد",
    "userlastname" => "صادقی",
    "mobile" => "09990300629",
    "password" => "2240300629",
  ]
   , [
        "userid" => "534",
    "userfirstname" => "باقر",
    "userlastname" => "رضا خانی",
    "mobile" => "09995186011",
    "password" => "9255186011",
  ]
   , [
        "userid" => "535",
    "userfirstname" => "معین",
    "userlastname" => "کریمی",
    "mobile" => "09998086488",
    "password" => "2358086488",
  ]
   , [
        "userid" => "536",
    "userfirstname" => "حسین",
    "userlastname" => "کرد",
    "mobile" => "09994947848",
    "password" => "5954947848",
  ]
   , [
        "userid" => "537",
    "userfirstname" => "",
    "userlastname" => "دورانی",
    "mobile" => "09994869634",
    "password" => "8704869634",
  ]
   , [
        "userid" => "965",
    "userfirstname" => "کاظم",
    "userlastname" => "کاظمی",
    "mobile" => "09992807002",
    "password" => "6032807002",
  ]
   , [
        "userid" => "1427",
    "userfirstname" => "",
    "userlastname" => "کازرانیان",
    "mobile" => "09996246380",
    "password" => "5926246380",
  ]
   , [
        "userid" => "1428",
    "userfirstname" => "",
    "userlastname" => "شاه محمدی",
    "mobile" => "09999223623",
    "password" => "5819223623",
  ]
   , [
        "userid" => "1431",
    "userfirstname" => "محمد حسین",
    "userlastname" => "شکیباییان",
    "mobile" => "09999582008",
    "password" => "8499582008",
  ]
   , [
        "userid" => "2875",
    "userfirstname" => "یاشار",
    "userlastname" => "بهمند",
    "mobile" => "09999472085",
    "password" => "6369472085",
  ]
   , [
        "userid" => "3172",
    "userfirstname" => "خسرو",
    "userlastname" => "محمد زاده",
    "mobile" => "09992289718",
    "password" => "6482289718",
  ]
   , [
        "userid" => "3895",
    "userfirstname" => "میثم",
    "userlastname" => "حسین خانی",
    "mobile" => "09997301087",
    "password" => "5227301087",
  ]
   , [
        "userid" => "3906",
    "userfirstname" => "پوریا",
    "userlastname" => "رحیمی",
    "mobile" => "09992800416",
    "password" => "3832800416",
  ]
   , [
        "userid" => "3971",
    "userfirstname" => "",
    "userlastname" => "نوری",
    "mobile" => "09993883868",
    "password" => "6193883868",
  ]
   , [
        "userid" => "3972",
    "userfirstname" => "رضا",
    "userlastname" => "آقاجانی",
    "mobile" => "09994582836",
    "password" => "2914582836",
  ]
   , [
        "userid" => "3973",
    "userfirstname" => "مهدی",
    "userlastname" => "امینی راد",
    "mobile" => "09993368407",
    "password" => "7253368407",
  ]
   , [
        "userid" => "3974",
    "userfirstname" => "سید حسین",
    "userlastname" => "رخ صفت",
    "mobile" => "09993610514",
    "password" => "8013610514",
  ]
   , [
        "userid" => "3975",
    "userfirstname" => "بهمن",
    "userlastname" => "مؤذنی پور",
    "mobile" => "09993294993",
    "password" => "5233294993",
  ]
   , [
        "userid" => "3976",
    "userfirstname" => "محمد صادق",
    "userlastname" => "ثابتی",
    "mobile" => "09993195124",
    "password" => "8163195124",
  ]
  , [
        "userid" => "3977",
    "userfirstname" => "مهدی",
    "userlastname" => "جلادتی",
    "mobile" => "09995290087",
    "password" => "8715290087",
  ]
   , [
        "userid" => "3979",
    "userfirstname" => "داریوش",
    "userlastname" => "راوش",
    "mobile" => "09995411768",
    "password" => "5945411768",
  ]
   , [
        "userid" => "3980",
    "userfirstname" => "پیمان",
    "userlastname" => "طلوعی",
    "mobile" => "09990634879",
    "password" => "9810634879",
  ]
   , [
        "userid" => "3993",
    "userfirstname" => "محمد حسین",
    "userlastname" => "انوشه",
    "mobile" => "09994536894",
    "password" => "1654536894",
  ]
   , [
        "userid" => "3998",
    "userfirstname" => "عباس",
    "userlastname" => "راستی بروجنی",
    "mobile" => "09993648802",
    "password" => "5303648802",
  ]
   , [
        "userid" => "4012",
    "userfirstname" => "جواد",
    "userlastname" => "نایب کبیر",
    "mobile" => "09991738525",
    "password" => "9231738525",
  ]
   , [
        "userid" => "4019",
    "userfirstname" => "عمار",
    "userlastname" => " تاج بخش",
    "mobile" => "09991494536",
    "password" => "5661494536",
  ]
   , [
        "userid" => "4020",
    "userfirstname" => "سروش",
    "userlastname" => "معینی",
    "mobile" => "09991369930",
    "password" => "2301369930",
  ]
   , [
        "userid" => "4021",
    "userfirstname" => "",
    "userlastname" => "نادریان",
    "mobile" => "09995323369",
    "password" => "8755323369",
  ]
   , [
        "userid" => "4022",
    "userfirstname" => "شهروز",
    "userlastname" => "رحیمی",
    "mobile" => "09998327816",
    "password" => "2148327816",
  ]
   , [
        "userid" => "4023",
    "userfirstname" => "سیروس",
    "userlastname" => "نصیری",
    "mobile" => "09992983588",
    "password" => "2872983588",
  ]
  , [
        "userid" => "4030",
    "userfirstname" => "مهدی",
    "userlastname" => "صنیعی طهرانی",
    "mobile" => "09991357099",
    "password" => "8431357099",
  ]
   , [
        "userid" => "4034",
    "userfirstname" => "هامون",
    "userlastname" => "سبطی",
    "mobile" => "09999865115",
    "password" => "5899865115",
  ]
   , [
        "userid" => "4035",
    "userfirstname" => "حامد",
    "userlastname" => "پویان نظر",
    "mobile" => "09991085599",
    "password" => "8131085599",
  ]
   , [
        "userid" => "4036",
    "userfirstname" => "فرشید",
    "userlastname" => "داداشی",
    "mobile" => "09996947115",
    "password" => "9556947115",
  ]
   , [
        "userid" => "4037",
    "userfirstname" => "ناصر",
    "userlastname" => "حشمتی",
    "mobile" => "09993403835",
    "password" => "3463403835",
  ]
   , [
        "userid" => "4038",
    "userfirstname" => "محمدامین",
    "userlastname" => "نباخته",
    "mobile" => "09992595909",
    "password" => "6592595909",
  ]
   , [
        "userid" => "4039",
    "userfirstname" => "جلال",
    "userlastname" => "موقاری",
    "mobile" => "09997805308",
    "password" => "7187805308",
  ]
  , [
        "userid" => "4040",
    "userfirstname" => "محسن",
    "userlastname" => " آهویی",
    "mobile" => "09996710139",
    "password" => "1646710139",
  ]
   , [
        "userid" => "4041",
    "userfirstname" => "مهدی",
    "userlastname" => "ناصر شریعت",
    "mobile" => "09994935716",
    "password" => "4554935716",
  ]
   , [
        "userid" => "4043",
    "userfirstname" => "سید حسام الدین",
    "userlastname" => "جلالی",
    "mobile" => "09999934699",
    "password" => "1849934699",
  ]
   , [
        "userid" => "4046",
    "userfirstname" => "ابوالفضل",
    "userlastname" => "جعفری",
    "mobile" => "09997858374",
    "password" => "8947858374",
  ]
   , [
        "userid" => "4047",
    "userfirstname" => "سهراب",
    "userlastname" => "ابوذرخانی فرد",
    "mobile" => "09991774103",
    "password" => "9271774103",
  ]
   , [
        "userid" => "4048",
    "userfirstname" => "سید حبیب",
    "userlastname" => "میرانی",
    "mobile" => "09992431052",
    "password" => "4642431052",
  ]
   , [
        "userid" => "4049",
    "userfirstname" => "حامد",
    "userlastname" => "امیراللهی",
    "mobile" => "09993704294",
    "password" => "4903704294",
  ]
   , [
        "userid" => "4050",
    "userfirstname" => "سید حمید رضا",
    "userlastname" => "مداح حسینی",
    "mobile" => "09991968225",
    "password" => "3201968225",
  ]
   , [
        "userid" => "4051",
    "userfirstname" => "علی اصغر",
    "userlastname" => "ترجانی",
    "mobile" => "09993094760",
    "password" => "2693094760",
  ]
   , [
        "userid" => "4052",
    "userfirstname" => "مهدی",
    "userlastname" => "صفری",
    "mobile" => "09990789285",
    "password" => "1420789285",
  ]
   , [
        "userid" => "4053",
    "userfirstname" => "نیما",
    "userlastname" => "صدفی",
    "mobile" => "09996362893",
    "password" => "6116362893",
  ]
   , [
        "userid" => "4054",
    "userfirstname" => "رضا",
    "userlastname" => "تهرانی",
    "mobile" => "09999837820",
    "password" => "4119837820",
  ]
   , [
        "userid" => "4055",
    "userfirstname" => "بهمن",
    "userlastname" => "منصوری",
    "mobile" => "09995329266",
    "password" => "6905329266",
  ]
   , [
        "userid" => "4056",
    "userfirstname" => "علیرضا",
    "userlastname" => "محمد زاده",
    "mobile" => "09993198122",
    "password" => "9933198122",
  ]
   , [
        "userid" => "4057",
    "userfirstname" => "امیر حسین",
    "userlastname" => "دلال شریفی",
    "mobile" => "09994849196",
    "password" => "6514849196",
  ]
   , [
        "userid" => "4058",
    "userfirstname" => "امید",
    "userlastname" => "احدیان",
    "mobile" => "09993959187",
    "password" => "3933959187",
  ]
   , [
        "userid" => "4059",
    "userfirstname" => "علی",
    "userlastname" => "محمدی",
    "mobile" => "09992359493",
    "password" => "7562359493",
  ]
        ]);
        $this->response = new Response();
    }

    private function deplessonMultiplexer($deplessonid , $mod = 1){
        if($mod==1)
            $c=[];
        else
            $c = "";
        switch ($deplessonid)
        {
            case 1 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 3 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 4 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 5 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 6 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 8 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 9 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 10 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 11 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 12 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 13 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 17 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 20 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 21 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 22 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 23 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 25 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 26 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 27 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 28 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 29 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 30 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 31 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 32 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 33 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 34 :
                break;
            case 35 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 36 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 37 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 38 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
                break;
            case 39 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 40 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 41 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 42 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 43 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 44 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 45 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 46 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 47 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 48 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی", "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 50 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 51 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 52 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 53 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 54 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 56 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 57 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 58 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 60 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 61 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 62 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 63 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 64 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 65 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 66 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 68 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 69 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 71 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 72 :
                break;
            case 73 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 74 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 75 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 76 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 77 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 78 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 79 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 80 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 81 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 84 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 86 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 87 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 88 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 89 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 90 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 91 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 92 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 93 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 94 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 95 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 96 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 97 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
                break;
            case 98 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 99 :if($mod==1)
                $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
            else
                $c = "";
                break;
            case 100 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 101 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 102 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 103 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 104 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 105 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 106 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 107 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 108 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 109 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 110 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 111 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 112 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 113 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 114 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 115 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 116 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 117 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 118 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 119 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 120 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 121 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 122 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 123 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 124 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 125 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 126 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 127 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 128 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 129 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 130 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 131 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 132 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 133 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 134 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 135 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 136 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 137 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 138 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 139 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 140 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 141 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 142 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی"];
                else
                    $c = "";
                break;
            case 143 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 144 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 145 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 146 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 147 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 148 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 149 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 150 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 151 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 152 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 153 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 154 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 155 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 156 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 157 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 158 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 159 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 160 :
                if($mod==1)
                    $c=["رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 162 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 163 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 164 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 165 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 166 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 167 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 168 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 169 :
                if($mod==1)
                    $c=[ "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 170 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "آرایه های ادبی کنکور دکتر هامون سبطی";
                break;
            case 171 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 172 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 173 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 174 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 175 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 177 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 178 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 179 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 180 :
                if($mod==1)
                    $c=["رشته_ریاضی"];
                else
                    $c = "";
                break;
            case 182 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 183 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 184 :
                if($mod==1)
                    $c=["رشته_انسانی"];
                else
                    $c = "";
                break;
            case 185 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 186 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 187 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" ];
                else
                    $c = "";
                break;
            case 188 :
                if($mod==1)
                    $c=["رشته_ریاضی" ];
                else
                    $c = "";
                break;
            case 189 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 190 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 191 :
                if($mod==1)
                    $c=["رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 192 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 193 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی"];
                else
                    $c = "";
                break;
            case 194 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "";
                break;
            case 195 :
                if($mod==1)
                    $c=["رشته_تجربی"];
                else
                    $c = "زیست ترکیبی کنکور";
                break;
            case 196 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            case 197 :
                if($mod==1)
                    $c=["رشته_ریاضی" , "رشته_تجربی" , "رشته_انسانی" ];
                else
                    $c = "";
                break;
            default:
                if($mod==1)
                    $c=[];
                else
                    $c = "";
                break;
        }
        return $c ;
    }

    private function departmentMultiplexer($depid , $mod = 1)
    {
        if($mod==1)
            $c=["متوسطه2"];
        else
            $c = "";
        switch ($depid) {
            case 1 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "اول_دبیرستان" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "شبیه_ساز_کلاس_درس"
                    ]);
                else
                    $c = "";
                break;
            case 2 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "دوم_دبیرستان" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه",
                        "شبیه_ساز_کلاس_درس"
                            ]);
                else
                    $c = "";
                break;
            case 3 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "سوم_دبیرستان" ,
                                "ضبط_کلاس_درس" ,
                                "نظام_آموزشی_قدیم" ,
                                "پایه",
                                "شبیه_ساز_کلاس_درس"
                                ]);
                else
                    $c = "";
                break;
            case 4 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "کنکور" ,
                                "ضبط_کلاس_درس" ,
                                "نظام_آموزشی_قدیم" ,
                                "پیش",
                                "شبیه_ساز_کلاس_درس"
                                ]);
                else
                    $c = "";
                break;
            case 7 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "کنکور" ,
                                "ضبط_استودیویی" ,
                                "نظام_آموزشی_قدیم" ,
                                "پیش" ,
                                "همایش" ,
                                "جمع_بندی"
                                ]);
                else
                    $c = "";
                break;
            case 8 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "سوم_دبیرستان" ,
                                "ضبط_استودیویی" ,
                                "نظام_آموزشی_قدیم" ,
                                "پایه" ,
                                "امتحان_نهایی"
                                ]);
                else
                    $c = "";
                break;
            case 9 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "المپیاد_علمی" ,
                                "ضبط_استودیویی" ,
                                "نظام_آموزشی_قدیم" ,
                                "پایه"
                            ]);
                else
                    $c = "";
                break;
            case 10 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "کنکور" ,
                                "ضبط_کلاس_درس" ,
                                "نظام_آموزشی_قدیم" ,
                                "پیش" ,
                                "شبیه_ساز_کلاس_درس"
                                ]);
                else
                    $c = "";
                break;
            case 11 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "کنکور" ,
                                "دهم",
                                "یازدهم",
                                "اول_دبیرستان",
                                "دوم_دبیرستان",
                                "سوم_دبیرستان",
                                "چهارم_دبیرستان" ,
                                "ضبط_استودیویی" ,
                                "نظام_آموزشی_قدیم" ,
                                "نظام_آموزشی_جدید" ,
                                "مشاوره",
                                "پیش"  ,
                                "پایه"
                            ]);
                else
                    $c = "";
                break;
            case 12 :
                if ($mod == 1)
                    $c = array_merge($c , [
                                "کنکور" ,
                                "ضبط_کلاس_درس" ,
                                "نظام_آموزشی_قدیم" ,
                                "پیش",
                                "شبیه_ساز_کلاس_درس"
                                                ]);
                else
                    $c = "";
                break;
            case 13 :
                if ($mod == 1)
                    $c = [];
                else
                    $c = "";
                break;
            case 14 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "سوم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 15 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "شبیه_ساز_کلاس_درس",
                        "پیش_آزمون",
                    ]);
                else
                    $c = "";
                break;
            case 16 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "دوم_دبیرستان" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "شبیه_ساز_کلاس_درس",
                    ]);
                else
                    $c = "";
                break;
            case 17 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "نکته_و_تست",
                    ]);
                else
                    $c = "";
                break;
            case 18 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "سوم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 19 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "همایش" ,
                        "جمع_بندی"
                    ]);
                else
                    $c = "";
                break;
            case 20 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "شبیه_ساز_کلاس_درس"
                    ]);
                else
                    $c = "";
                break;
            case 21 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_کلاس_درس" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "شبیه_ساز_کلاس_درس"
                    ]);
                else
                    $c = "";
                break;
            case 22 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "اول_دبیرستان",
                        "دوم_دبیرستان",
                        "سوم_دبیرستان",
                        "چهارم_دبیرستان",
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 23 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "المپیاد_علمی" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 24 :
                if ($mod == 1)
                    $c = [
                        "متوسطه1",
                        "نهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ];
                else
                    $c = "";
                break;
            case 25 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "نکته_و_تست",
                    ]);
                else
                    $c = "";
                break;
            case 26 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 27 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "دهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 28 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "دهم",
                        "یازدهم",
                        "اول_دبیرستان",
                        "دوم_دبیرستان",
                        "سوم_دبیرستان",
                        "چهارم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "نظام_آموزشی_جدید" ,
                        "مشاوره",
                        "ماز",
                        "پیش"  ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 29 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش"  ,
                        "شب_کنکور",
                    ]);
                else
                    $c = "";
                break;
            case 30 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "سوم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 31 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "چهارم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 32 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش"  ,
                        "جمع_بندی",
                        "همایش"
                    ]);
                else
                    $c = "";
                break;
            case 33 :
                if ($mod == 1)
                    $c = [];
                else
                    $c = "";
                break;
            case 35 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش"  ,
                        "تحلیل_آزمون"
                    ]);
                else
                    $c = "";
                break;
            case 36 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش"  ,
                        "همایش"
                    ]);
                else
                    $c = "";
                break;
            case 37 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "دهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 38 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "یازدهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 39 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "دهم",
                        "یازدهم",
                        "اول_دبیرستان",
                        "دوم_دبیرستان",
                        "سوم_دبیرستان",
                        "چهارم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "نظام_آموزشی_جدید" ,
                        "پیش"  ,
                        "پایه",
                        "صفر_تا_صد"
                    ]);
                else
                    $c = "";
                break;
            case 40 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "یازدهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 41 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 42 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "چهارم_دبیرستان" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پایه" ,
                        "صفر_تا_صد",
                    ]);
                else
                    $c = "";
                break;
            case 43 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "دهم" ,
                        "ضبط_استودیو" ,
                        "نظام_آموزشی_جدید" ,
                        "پایه"
                    ]);
                else
                    $c = "";
                break;
            case 44 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "نکته_و_تست",
                    ]);
                else
                    $c = "";
                break;
            case 45 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش" ,
                        "نکته_و_تست",
                    ]);
                else
                    $c = "";
                break;
            case 46 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "کنکور" ,
                        "ضبط_استودیویی" ,
                        "نظام_آموزشی_قدیم" ,
                        "پیش"  ,
                        "جمع_بندی",
                        "همایش"
                    ]);
                else
                    $c = "";
                break;
            default:
                if ($mod == 1)
                    $c = [];
                else
                    $c = "";
                break;
        }
        return $c;
    }

    private function lessonMultiplexer($lessonid , $lessonname , $mod = 1)
    {
        if($mod==1)
            $c=[
                $this->make_slug($lessonname , "_")
            ];
        else
            $c = "";
        switch ($lessonid) {
            case 1 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 3 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 4 :
                if ($mod == 1)
                   ;
                else
                    $c = "";
                break;
            case 5 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 6 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 7 :
                if ($mod == 1)
                    $c = [
                        "زبان_و_ادبیات_فارسی"
                    ];
                else
                    $c = "";
                break;
            case 8 :
                if ($mod == 1)
                    $c = ["زبان_انگلیسی"];
                else
                    $c = "";
                break;
            case 9 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 10 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 11 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 12 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 13 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "ریاضی_پایه"
                    ]);
                else
                    $c = "";
                break;
            case 14 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 15 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 16 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 19 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "ریاضی_پایه"
                    ]);
                else
                    $c = "";
                break;
            case 20 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "ریاضی_پایه"
                    ]);
                else
                    $c = "";
                break;
            case 21 :
                if ($mod == 1)
                    $c = [
                        "فیزیک"
                    ];
                else
                    $c = "";
                break;
            case 23 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 24 :
                if ($mod == 1)
                    $c = [
                        "زبان_انگلیسی" ,
                        "سوم_دبیرستان" ,
                        "چهارم_دبیرستان"];
                else
                    $c = "";
                break;
            case 25 :
                if ($mod == 1)
                    $c = [
                        "فیزیک"
                    ];
                else
                    $c = "";
                break;
            case 26 :
                if ($mod == 1)
                    $c = [
                        "فیزیک"
                    ];
                else
                    $c = "";
                break;
            case 27 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 28 :
                if ($mod == 1)
                    $c = [
                        "گسسته" ,
                        "جبر_و_احتمال" ,
                        "پایه" ,
                        "سوم_دبیرستان" ,
                    ];
                else
                    $c = "";
                break;
            case 29 :
                if ($mod == 1)
                    $c = [
                        "ریاضی_تجربی" ,
                    ];
                else
                    $c = "";
                break;
            case 30 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 31 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 32 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 33 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 34 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 35 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 38 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 39 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 40 :
                if ($mod == 1)
                    $c = [
                        "ریاضی_پایه" ,
                    ];
                else
                    $c = "";
                break;
            case 41 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 42 :
                if ($mod == 1)
                   ;
                else
                    $c = "";
                break;
            case 43 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 44 :
                if ($mod == 1)
                    $c = [
                        "زبان_و_ادبیات_فارسی_انسانی" ,
                    ];
                else
                    $c = "";
                break;
            case 45 :
                if ($mod == 1)
                    $c = array_merge($c , [
                        "زبان_و_ادبیات_فارسی"
                    ]);
                else
                    $c = "";
                break;
            case 46 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            case 47 :
                if ($mod == 1)
                    ;
                else
                    $c = "";
                break;
            default:
                if ($mod == 1)
                    $c = [];
                else
                    $c = "";
                break;
        }
        return $c;
    }

    private function determineContentSetName($deplessonid , $lessonname , $depname , $depyear)
    {
        /**making year label* */
//            $year_remanider = (int)$sanatisharifRecord->depyear % 100 ;
        if(isset($depyear))
        {
            $year_plus_remainder = (int)$depyear % 100 +1 ;
            $yearLabel = " ($year_plus_remainder-$depyear)" ;
        }
        else
        {
            $yearLabel = "" ;
        }

        $name = $lessonname . " ".$depname .$yearLabel ;
        $specialName = $this->deplessonMultiplexer($deplessonid,2);
        if(strlen($specialName) > 0) $name = $specialName ;
        return $name;
    }

    private function determineTeacherName(  $userfirstname , $userlastname ,  $id = 0  , $mod = 1)
    {
        /**
         *  mod 1 => id is deplessonid
         *  mod 2 => id is videoid
         */

        if($mod == 1)
            switch ($id)
            {//deplessonid
                case 20 :
                    $userid = 0;
                    break;
                case 23:
                    $userid = 318;
                    break;
                case 28:
                    $userid = 0 ;
                    break;
                case 34 :
                    $userid = 0;
                    break;
                case 97 :
                    $userid = 0;
                    break;
                case 142 :
                    $userid = 0;
                    break;
                case 143:
                    $userid = 307;
                    break;
                case 144:
                    $userid = 3;
                    break;
                case 145:
                    $userid = 4049 ;
                    break;
                case 146:
                    $userid = 366 ;
                    break;
                case 147:
                    $userid = 8 ;
                    break;
                default:
                    break;
            }
        elseif($mod == 2)
            switch ($id)
            {//videoid
                case 513:
                case 511:
                    $userid = 318;
                    break;
                case 5315:
                case 5319:
                case 5320:
                    $userid = 307;
                    break;
                case 5316:
                    $userid = 3;
                    break;
                case 5321:
                    $userid = 4049 ;
                    break;
                case 5322:
                    $userid = 366 ;
                    break;
                case 5317 :
                case 5318:
                    $userid = 8 ;
                    break;
                case 409 :
                    $userid = 4047;
                    break;
                case 616 :
                case 617 :
                    $userid = 4048;
                    break;
                case 6227 :
                case 6228 :
                case 6229 :
                case 6230 :
                case 6237 :
                case 6238 :
                case 6239 :
                    $userid = 2;
                    break;
                case 577:
                case 578:
                case 595:
                case 597:
                case 678:
                case 680:
                case 682:
                    $userid = 20;
                    break;
                case 677:
                case 679:
                case 681:
                    $userid = 4059;
                    break;
                case 3264:
                    $userid = 4950;
                    break;
                case 6351:
                    $userid = 4030;
                    break;
                case 5251:
                    $userid = 3974;
                    break;
                case 5252:
                    $userid = 4051;
                    break;
                case 5253:
                    $userid = 4052;
                    break;
                case 5254:
                    $userid = 4053;
                    break;
                case 5255:
                    $userid = 4054;
                    break;
                case 6347:
                    $userid = 3974;
                    break;
                case 6348:
                    $userid = 4055;
                    break;
                case 6349:
                    $userid = 4056;
                    break;
                case 6350:
                    $userid = 4057;
                    break;
                case 6352:
                    $userid = 4058;
                    break;
                default:
                    break;
            }

        if(isset($userid))
        {
            if($userid == 0)
            {
                $userfirstname = "";
                $userlastname = "" ;
            }
            else
            {
                $user = $this->teachers->where("userid" , $userid)->first() ;
                if(isset($user))
                {
                    $userfirstname = $user["userfirstname"] ;
                    $userlastname = $user["userlastname"] ;
                }
                else
                {
                    dump("warning : teacher with userid ".$user." was not found!");
                }
            }
        }

        if(!isset($userfirstname))
            $userfirstname = "";
        if(!isset($userlastname))
            $userlastname = "";

        return [
            "firstname" =>$userfirstname ,
            "lastname" => $userlastname
        ];
    }

    private function makeName($firstname , $lastname){
        $fullName = "";
        if(isset($firstname) && strlen($firstname) > 0)
            $fullName .= $firstname;
        if(isset($lastname) &&  strlen($lastname) > 0)
            if(strlen($fullName) > 0 )
                $fullName .= " ".$lastname;
            else
                $fullName .= $firstname;

        return $fullName ;
    }

    private function determineAuthor($frstname , $lastname)
    {
        $author = $this->teachers->where("userfirstname" , $frstname)->where("userlastname" , $lastname)->first();
        if(isset($author))
        {
            $info = [];
            if (strlen($frstname) > 0)
                $info["firstName"] = $frstname;
            if (strlen($lastname) > 0)
                $info["lastName"] = $lastname;
            $info["mobile"] = $author["mobile"];
            $info["nationalCode"] = "0000000000";
            $password = $author["password"];
            $info["password"] = bcrypt($password);
            $info["userstatus_id"] = 1;
            $authorAccount = User::firstOrCreate([
                "mobile" => $info["mobile"] ,
                "nationalCode" => $info["nationalCode"]
            ], $info);

            if(isset($authorAccount))
            {
                $userId = $authorAccount->id;
            }
        }
        else
        {
            $userId = 0;
        }

        return $userId ;
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
        try {
            $sanatisharifRecords = Sanatisharifmerge::whereNull("videoid")
                ->whereNull("pamphletid")
                ->whereNotNull("departmentlessonid")
                ->where("departmentlessonTransferred" , 0)
                ->get();
//        $sanatisharifRecords = Sanatisharifmerge::groupBy('departmentlessonid')->where("departmentlessonTransferred" , 0);
            //Bug: farze kon ye deplesson ham khodesh vared shode ham video barayash vared shode. man chon bar asase sotoone departmentlessonTransferred filter mikonam
            // var recordi ke deplessonid va videoid darad dataye departmentlessonTransferred sefr ast kare filtere man ra kharab mikonad

            dump("number of available deplessons : ".count($sanatisharifRecords));
            $successCoutner = 0;
            $failedCounter = 0 ;
            $skippedCounter = 0 ;
            $excludedDeplessons = [34 , 15 ,24 , 67 , 70];
            foreach ($sanatisharifRecords as $sanatisharifRecord)
            {
                if(in_array( $sanatisharifRecord->departmentlessonid , $excludedDeplessons))
                {
                    $skippedCounter++;
                    continue;
                }
                $request = new Request();


                $request->offsetSet("id" , $sanatisharifRecord->departmentlessonid);
                $request->offsetSet("enable" , $sanatisharifRecord->departmentlessonEnable);
                $request->offsetSet("display" , $sanatisharifRecord->departmentlessonEnable);

                $tags = [
                    "دوره_آموزشی"
                ];
                $name = $this->determineContentSetName($sanatisharifRecord->departmentlessonid , $sanatisharifRecord->lessonname , $sanatisharifRecord->depname,$sanatisharifRecord->depyear) ;
                $tags = array_merge($tags ,$this->deplessonMultiplexer($sanatisharifRecord->departmentlessonid,1));
                $tags = array_merge($tags , $this->departmentMultiplexer($sanatisharifRecord->depid)) ;
                $tags = array_merge($tags , $this->lessonMultiplexer($sanatisharifRecord->lessonid , $this->make_slug($sanatisharifRecord->lessonname))) ;
                $teacherNameArray =  $this->determineTeacherName($sanatisharifRecord->teacherfirstname , $sanatisharifRecord->teacherlastname , $sanatisharifRecord->departmentlessonid , 1);
                $teacherName = $this->makeName($teacherNameArray["firstname"] , $teacherNameArray["lastname"]) ;
                if(strlen($teacherName) > 0)
                {
                    array_push($tags , $this->make_slug($teacherName , "_") );
                    $name .= " " .$teacherName;
                }

                $tagsJson = [
                    "bucket" => "contentset",
                    "tags" => $tags
                ];
                $request->offsetSet("tags" , json_encode($tagsJson));
                dump($tags);

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
                        $successCoutner++;
                    }elseif($response->getStatusCode() == 503)
                    {
                        dump("departmentlesson state wasn't saved. id: ".$sanatisharifRecord->departmentlessonid);
                        $failedCounter++;
                    }
                }
                elseif($response->getStatusCode() == 503)
                {
                    $failedCounter++;
                    dump("departmentlesson wasn't transferred. id: ".$sanatisharifRecord->departmentlessonid);
                }
            }
            dump("number of failed: ".$failedCounter);
            dump("number of successful : ".$successCoutner);
            dump("number of skipped : ".$skippedCounter);
            return $this->response->setStatusCode(200)->setContent(["message"=>"Creating Playlists Done Successfully"]);

        } catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response->setStatusCode(503)
                ->setContent([
                    "message" => $message,
                    "error" => $e->getMessage(),
                    "line" => $e->getLine(),
                    "file" => $e->getFile()
                ]);
        }
    }

    public function copyContent()
    {
        try{
            if(!Input::has("t")) return $this->response->setStatusCode(422)->setContent(["message"=>"Wrong inputs: Please pass parameter t. Available values: p , v"]);
            else $contentType = Input::get("t");

            switch ($contentType)
            {
                case "v" :
                    $threshold = 300;
                    $contentTypeLable = "video";
                    $contentTypePersianLable = "فیلم";
                    break;
                case "p" :
                    $threshold = 500;
                    $contentTypeLable = "pamphlet";
                    $contentTypePersianLable = "جزوه";
                    $contentTypePersianLable2 = "PDF";
                    break;
                default:
                    return $this->response->setStatusCode(422)->setContent(["message"=>"Wrong inputs: Please pass parameter t. Available values: p , v"]);
                    break;
            }
            $idColumn = $contentTypeLable."id";
            $nameColumn = $contentTypeLable."name";
            $descriptionColumn = $contentTypeLable."descrip";
            $enableColumn = $contentTypeLable."Enable";
            $sessionColumn = $contentTypeLable."session";

            $sanatisharifRecords = Sanatisharifmerge::whereNotNull($contentTypeLable."id")->where($contentTypeLable."Transferred" , 0);
            if(Input::has("id"))
            {
                $id = Input::get("id");
                $sanatisharifRecords->where($idColumn ,$id );
            }
            $sanatisharifRecords = $sanatisharifRecords->get();

            $counter = 0 ;
            $successCounter = 0 ;
            $failCounter = 0;
            $warningCounter = 0;
            $skippedCounter = 0 ;
            dump( "start time (processing response data):". Carbon::now("asia/tehran"));
            dump(count($sanatisharifRecords)." records available for transfer");
            $excludedVideos = [34 , 15 , 24 , 67 , 70] ;
            foreach ($sanatisharifRecords as $sanatisharifRecord)
            {
                if($counter >= $threshold) break;
                try{
                    if(in_array($sanatisharifRecord->departmentlessonid , $excludedVideos))
                    {
                        $counter++;
                        $skippedCounter++;
                        continue;
                    }
                    $request = new Request();
                    $storeContentReuest = new \App\Http\Requests\InsertEducationalContentRequest();
                    dump($contentTypeLable."id ".$sanatisharifRecord->$idColumn." started");
                    switch ($contentType)
                    {
                        case "v" :
                            /**   conditional by passing some records   */
                            if( ( (!isset($sanatisharifRecord->videolink) || strlen($sanatisharifRecord->videolink)==0)
                                    && (!isset($sanatisharifRecord->videolinkhq) || strlen($sanatisharifRecord->videolinkhq) ==0)
                                    && (!isset($sanatisharifRecord->videolink240p) || strlen($sanatisharifRecord->videolink240p)==0) )
                                || (!$sanatisharifRecord->videoEnable && $sanatisharifRecord->videosession == 0) )
                            {
//                http://cdn4.takhtesefid.org/videos/hq".$video->videolinkonline.".mp4?name=hq-".$video->videolinkonline.".mp4
                                dump("Videoid ".$sanatisharifRecord->videoid." skipped");
                                if(!$sanatisharifRecord->videoEnable && $sanatisharifRecord->videosession == 0)
                                {
                                    $request->offsetSet("videoTransferred" , 2);
                                }elseif(isset($sanatisharifRecord->videolinktakhtesefid))
                                    $request->offsetSet("videoTransferred" , 4);
                                else
                                    $request->offsetSet("videoTransferred" , 3);
                                $response = $this->update($request , $sanatisharifRecord);
                                if($response->getStatusCode() == 200)
                                {
                                    $skippedCounter++ ;
                                }elseif($response->getStatusCode() == 503)
                                {
                                    $failCounter++ ;
                                    dump("Skipped status wasn't saved for video: ".$sanatisharifRecord->videoid);
                                }
                                continue 2;
                            }

                            $files = array();
                            if(isset($sanatisharifRecord->videolink) && strlen($sanatisharifRecord->videolink)>0) array_push($files ,
                                [
                                   "name"=>$sanatisharifRecord->videolink,
                                    "caption"=>"کیفیت عالی" , "label"=>"hd"
                            ]);
                            if(isset($sanatisharifRecord->videolinkhq) && strlen($sanatisharifRecord->videolinkhq)>0) array_push($files ,
                                [
                                "name"=>$sanatisharifRecord->videolinkhq ,
                                "caption"=>"کیفیت بالا" , "label"=>"hq"
                            ]);
                            if(isset($sanatisharifRecord->videolink240p) && strlen($sanatisharifRecord->videolink240p)>0) array_push($files ,
                                ["name"=>$sanatisharifRecord->videolink240p ,
                                    "caption"=>"کیفیت متوسط" , "label"=>"240p"
                                ]);
                            if(isset($sanatisharifRecord->thumbnail) && strlen($sanatisharifRecord->thumbnail)>0)
                            {
                                $thumbnailFile = $sanatisharifRecord->thumbnail ;
                            }
                            else
                            {
                                if(isset($sanatisharifRecord->videolink) && strlen($sanatisharifRecord->videolink)>0)
                                    $filePath = $sanatisharifRecord->videolink;
                                elseif(isset($sanatisharifRecord->videolinkhq) && strlen($sanatisharifRecord->videolinkhq)>0)
                                    $filePath = $sanatisharifRecord->videolinkhq;
                                elseif(isset($sanatisharifRecord->videolink240p) && strlen($sanatisharifRecord->videolink240p)>0)
                                    $filePath = $sanatisharifRecord->videolink240p;

                                if(isset($filePath))
                                {
                                    $pathInfoArray = pathinfo($filePath);
                                    $thumbnailFile = "https://cdn.sanatisharif.ir/media/thumbnails/".$sanatisharifRecord->departmentlessonid."/". $pathInfoArray["filename"] . ".jpg"  ;
                                }
                            }
                            array_push($files , [
                                "name"=>$thumbnailFile ,
                                "caption"=>"تامبنیل" , "label"=>"thumbnail"
                            ] );
                            if(!empty($files)) $storeContentReuest->offsetSet("files" , $files );
                            $template_id = 1;
                            $contentTypeId = [8];
                            break;
                        case "p":
                            $files = array();
                            $pamphletFileName = basename($sanatisharifRecord->pamphletaddress);
                            if(isset($sanatisharifRecord->pamphletaddress) && strlen($sanatisharifRecord->pamphletaddress)>0)
                                array_push($files ,["name"=>$pamphletFileName  , "disk_id" => 4 ]);
                            if(!empty($files))
                                $storeContentReuest->offsetSet("files" , $files );
                            $template_id = 2;
                            $contentTypeId = [1];
                            break;
                        default:
                            break;
                    }

                    $storeContentReuest->offsetSet("template_id" , $template_id);

                    if( isset($sanatisharifRecord->$nameColumn) && strlen($sanatisharifRecord->$nameColumn) > 0)
                    {
                        $storeContentReuest->offsetSet("name" , $sanatisharifRecord->$nameColumn);
                        $metaTitle = strip_tags(htmlspecialchars(substr($sanatisharifRecord->$nameColumn ,0,55)));
                        $storeContentReuest->offsetSet("metaTitle" , $metaTitle );
                    }

                    if(isset($sanatisharifRecord->$descriptionColumn) && strlen($sanatisharifRecord->$descriptionColumn) > 0)
                    {
                        $storeContentReuest->offsetSet("description" , $sanatisharifRecord->$descriptionColumn);
                        $metaDescription =  htmlspecialchars(strip_tags(substr($sanatisharifRecord->$descriptionColumn, 0 , 155)));
                        $storeContentReuest->offsetSet("metaDescription" , $metaDescription);
                    }

                    if( (isset($sanatisharifRecord->$nameColumn) && strlen($sanatisharifRecord->$nameColumn)>0)
                        || (isset($sanatisharifRecord->$descriptionColumn) && strlen($sanatisharifRecord->$descriptionColumn)>0) )
                    {
                        $text = strip_tags($sanatisharifRecord->$nameColumn) . " " . strip_tags($sanatisharifRecord->$descriptionColumn);
                        $text = preg_replace('/[^\p{L}|\p{N}]+/u', ' ', $text);
                        $text = preg_replace('/[\p{Z}]{2,}/u', " ", $text);

                        $addKeyword = 'دبیرستان,دانشگاه,صنعتی,شریف,آلاء,الا,دانشگاه شریف, دبیرستان شریف, فیلم, آموزش,رایگان,کنکور,امتحان نهایی,تدریس';
                        $manualKeyword = '';
                        $metaKeywords = $this->generateKeywordsMeta($text, $manualKeyword, $addKeyword);
                        $storeContentReuest->offsetSet("metaKeywords" , $metaKeywords);
                    }

                    $teacherNameArray =  $this->determineTeacherName($sanatisharifRecord->teacherfirstname , $sanatisharifRecord->teacherlastname , $sanatisharifRecord->videoid , 2);

                    $authorId = $this->determineAuthor($teacherNameArray['firstname'] , $teacherNameArray["lastname"]) ;
                    if($authorId == 0)
                    {
                        $warningCounter++;
                        dump("warning could not find the teacher for ".$contentTypeLable . " " .$sanatisharifRecord->$idColumn) ;
                        dump("teacher name: ".$sanatisharifRecord->teacherfirstname." ".$sanatisharifRecord->teacherlastname) ;
                    }
                    else
                    {
                        $storeContentReuest->offsetSet("author_id" , $authorId);
                    }


                    $tags = [$this->make_slug($contentTypePersianLable,"_")];

                    if(isset($contentTypePersianLable2) && strlen($contentTypePersianLable2)>0)
                        $tags = array_merge ( $tags , [$this->make_slug($contentTypePersianLable2,"_")]);
                    $tags = array_merge($tags , $this->deplessonMultiplexer($sanatisharifRecord->departmentlessonid));
                    $tags = array_merge($tags , $this->departmentMultiplexer($sanatisharifRecord->depid)) ;
                    $tags = array_merge($tags , $this->lessonMultiplexer($sanatisharifRecord->lessonid , $this->make_slug($sanatisharifRecord->lessonname))) ;
                    $teacherName = $this->makeName($teacherNameArray["firstname"] , $teacherNameArray["lastname"]) ;
                    if(strlen($teacherName) > 0)
                        array_push($tags , $this->make_slug($teacherName , "_") );
                    $tagsJson = [
                      "bucket" => "content",
                      "tags" => $tags
                    ];
                    $storeContentReuest->offsetSet("tags" , json_encode($tagsJson));

                    dump($tags);

                    if(!$sanatisharifRecord->$enableColumn) $storeContentReuest->offsetSet("enable" , 0);
//            $storeContentReuest->offsetSet("validSince" , ""); //ToDo

                    $storeContentReuest->offsetSet("contenttypes" , $contentTypeId);
                    if(Contentset::where("id",$sanatisharifRecord->departmentlessonid)->get()->isNotEmpty())
                    {
                        $storeContentReuest->offsetSet("contentsets" , [["id"=>$sanatisharifRecord->departmentlessonid , "order"=>$sanatisharifRecord->$sessionColumn , "isDefault"=>1]]);
                    }
                    else
                    {
                        $warningCounter++ ;
                        dump("Warning contentset was not exist. id: ".$sanatisharifRecord->departmentlessonid);
                    }
                    $storeContentReuest->offsetSet("fromAPI" , true);

                    $controller = new EducationalContentController();
                    $response = $controller->store($storeContentReuest);
                    $responseContent =  json_decode($response->getContent());
                    if($response->getStatusCode() == 200)
                    {
                        $request->offsetSet($contentTypeLable."Transferred" , 1);
                        if(isset($responseContent->id))
                            $request->offsetSet("educationalcontent_id" , $responseContent->id);
                        $response = $this->update($request , $sanatisharifRecord);
                        if($response->getStatusCode() == 200)
                        {
                             $successCounter++;
                        }elseif($response->getStatusCode() == 503)
                        {
                            $failCounter++;
                            dump("failed Transferred status wasn't saved for $contentTypeLable: ".$sanatisharifRecord->$idColumn);
                        }
                    }elseif($response->getStatusCode() == 503)
                    {
                        $failCounter++;
                        dump("failed $contentTypeLable wasn't transferred. id: ".$sanatisharifRecord->$idColumn);
                    }
                    $counter++ ;
                    dump($contentTypeLable."id ".$sanatisharifRecord->$idColumn." done");
                }catch(\Exception $e){
                    $failCounter++;
                    dump($e->getMessage()." ".$e->getLine()." ".$e->getFile());
                    dump("failed on processing $contentTypeLable ID: ".$sanatisharifRecord->$idColumn);
                }
            }
            dump($successCounter." records transferred successfully");
            dump($skippedCounter." records skipped");
            dump($failCounter." records failed");
            dump($warningCounter." warnings");
            dump( "finish time:". Carbon::now("asia/tehran"));
            return $this->response->setStatusCode(200)->setContent(["message"=>"Transfer Done Successfully"]);
        }
        catch (\Exception    $e) {
            $message = "unexpected error";
            return $this->response->setStatusCode(503)->setContent(["message"=>$message , "error"=>$e->getMessage() , "line"=>$e->getLine()]);
        }

    }


    private function getDepLessonTags($lId = null , $dId = null ){
        $key = "getDepLessonTags:".$lId."-".$dId;
        return Cache::rememberForever ($key,function () use ($lId,$dId) {
            $tag1 = [];
            $tag2 = [];
            $tag3 = [];
            if(isset($lId) && isset($dId)){
                $tag1 = $this->departmentMultiplexer($dId);
                $oldContent = Sanatisharifmerge::where('lessonid','=',$lId)
                    ->where('depid','=',$dId)
                    ->first();
                $tag2 = $this->lessonMultiplexer($lId,$oldContent->lessonname);
                $tag3 = $this->determineTeacherName(
                    $oldContent->teacherfirstname,
                    $oldContent->teacherlastname,
                    $oldContent->departmentlessonid,
                    1);
                $tag3 = $this->makeName($tag3["firstname"],$tag3["lastname"]);
                if(strlen($tag3) > 0)
                    $tag3 = [$this->make_slug($tag3 , "_")];
                else
                    $tag3 =[];
            }elseif (isset($lId)){
                $oldContent = Sanatisharifmerge::where('lessonid','=',$lId)->first();
                if (isset($oldContent)) {
                    $tag1 = $this->lessonMultiplexer($lId,$oldContent->lessonname);
                }
            }
            $tag = array_merge($tag1,$tag2,$tag3);
            return $tag;
        });
    }

    public function redirectLesson(Request $request , $lId = null , $dId = null){
        $tag = $this->getDepLessonTags($lId, $dId);
        $newUri = urldecode(action("HomeController@search" , ["tags"=>$tag]));
        return redirect($newUri,301);
    }

    public function redirectVideo(Request $request , $lId = null , $dId = null, $vId = null){

        $key = "Url:".$lId."-".$dId."-".$vId;
        $newUri = Cache::rememberForever ($key,function () use ($lId,$dId,$vId) {
            if( isset($vId) ) {
                $v = Sanatisharifmerge::where('videoid','=',$vId)->first();
                if (isset($v)) {
                    if (isset($v->educationalcontent)) {
                        return action('EducationalContentController@show',$v->educationalcontent);
                    }
                }
            }
            $tag = $this->getDepLessonTags($lId, $dId);
            return urldecode(action("HomeController@search" , ["tags"=>$tag]));

        });
        return redirect($newUri,301);

    }

    public function redirectPamphlet(Request $request , $lId = null , $dId = null, $pId = null){
        $key = "Url:".$lId."-".$dId."-".$pId;
        $newUri = Cache::rememberForever ($key,function () use ($lId,$dId,$pId) {
            if( isset($pId) ) {
                $p = Sanatisharifmerge::where('pamphletid','=',$pId)->first();
                if (isset($p)) {
                    if (isset($p->educationalcontent)) {
                        return action('EducationalContentController@show',$p->educationalcontent);
                    }
                }
            }
            $tag = $this->getDepLessonTags($lId, $dId);
            return urldecode(action("HomeController@search" , ["tags"=>$tag]));

        });
        return redirect($newUri,301);
    }

//    public function redirectVideo
}
