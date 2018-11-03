<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class AlterTableUsersAddSlugname extends Migration
{
    use \App\Traits\CharacterCommon;

    private $oldTeachers;

    public function __construct()
    {
        $this->oldTeachers = collect([
                                         [
                                             "userid"        => "2",
                                             "userfirstname" => "رضا",
                                             "userlastname"  => "شامیزاده",
                                             "mobile"        => "09991550613",
                                             "password"      => "9651550613",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3",
                                             "userfirstname" => "روح الله",
                                             "userlastname"  => "حاجی سلیمانی",
                                             "mobile"        => "09997336794",
                                             "password"      => "7337336794",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4",
                                             "userfirstname" => "محسن",
                                             "userlastname"  => "شهریان",
                                             "mobile"        => "09999692882",
                                             "password"      => "4699692882",
                                         ]
                                         ,
                                         [
                                             "userid"        => "5",
                                             "userfirstname" => "علیرضا",
                                             "userlastname"  => "رمضانی",
                                             "mobile"        => "09997912437",
                                             "password"      => "4957912437",
                                         ]
                                         ,
                                         [
                                             "userid"        => "6",
                                             "userfirstname" => "پدرام",
                                             "userlastname"  => "علیمرادی",
                                             "mobile"        => "09997985109",
                                             "password"      => "5397985109",
                                         ]
                                         ,
                                         [
                                             "userid"        => "7",
                                             "userfirstname" => "عبدالرضا",
                                             "userlastname"  => "مرادی",
                                             "mobile"        => "09993707484",
                                             "password"      => "8283707484",
                                         ]
                                         ,
                                         [
                                             "userid"        => "8",
                                             "userfirstname" => "علی اکبر",
                                             "userlastname"  => "عزتی",
                                             "mobile"        => "09994687166",
                                             "password"      => "1014687166",
                                         ]
                                         ,
                                         [
                                             "userid"        => "9",
                                             "userfirstname" => "مسعود",
                                             "userlastname"  => "حدادی",
                                             "mobile"        => "09995776510",
                                             "password"      => "9445776510",
                                         ]
                                         ,
                                         [
                                             "userid"        => "20",
                                             "userfirstname" => "محمدرضا",
                                             "userlastname"  => "مقصودی",
                                             "mobile"        => "09997835481",
                                             "password"      => "1637835481",
                                         ]
                                         ,
                                         [
                                             "userid"        => "97",
                                             "userfirstname" => "محمد علی",
                                             "userlastname"  => "امینی راد",
                                             "mobile"        => "09992250618",
                                             "password"      => "9322250618",
                                         ]
                                         ,
                                         [
                                             "userid"        => "103",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "تفتی",
                                             "mobile"        => "09998520269",
                                             "password"      => "5558520269",
                                         ]
                                         ,
                                         [
                                             "userid"        => "246",
                                             "userfirstname" => "",
                                             "userlastname"  => "جعفری",
                                             "mobile"        => "09992042338",
                                             "password"      => "8912042338",
                                         ]
                                         ,
                                         [
                                             "userid"        => "307",
                                             "userfirstname" => "حمید",
                                             "userlastname"  => "فدایی فرد",
                                             "mobile"        => "09993694022",
                                             "password"      => "6783694022",
                                         ]
                                         ,
                                         [
                                             "userid"        => "308",
                                             "userfirstname" => "کیاوش",
                                             "userlastname"  => "فراهانی",
                                             "mobile"        => "09993056881",
                                             "password"      => "3623056881",
                                         ]
                                         ,
                                         [
                                             "userid"        => "310",
                                             "userfirstname" => "مصطفی",
                                             "userlastname"  => "جعفری نژاد",
                                             "mobile"        => "09993231211",
                                             "password"      => "9873231211",
                                         ]
                                         ,
                                         [
                                             "userid"        => "311",
                                             "userfirstname" => "رفیع",
                                             "userlastname"  => "رفیعی",
                                             "mobile"        => "09998208012",
                                             "password"      => "1928208012",
                                         ]
                                         ,
                                         [
                                             "userid"        => "313",
                                             "userfirstname" => "علی",
                                             "userlastname"  => "صدری",
                                             "mobile"        => "09995783188",
                                             "password"      => "9255783188",
                                         ]
                                         ,
                                         [
                                             "userid"        => "314",
                                             "userfirstname" => "امید",
                                             "userlastname"  => "زاهدی",
                                             "mobile"        => "09998374076",
                                             "password"      => "1978374076",
                                         ]
                                         ,
                                         [
                                             "userid"        => "318",
                                             "userfirstname" => "محسن",
                                             "userlastname"  => "معینی",
                                             "mobile"        => "09994478111",
                                             "password"      => "8224478111",
                                         ]
                                         ,
                                         [
                                             "userid"        => "319",
                                             "userfirstname" => "میلاد",
                                             "userlastname"  => "ناصح زاده",
                                             "mobile"        => "09997447782",
                                             "password"      => "1577447782",
                                         ]
                                         ,
                                         [
                                             "userid"        => "320",
                                             "userfirstname" => "محمد",
                                             "userlastname"  => "پازوکی",
                                             "mobile"        => "09996582414",
                                             "password"      => "2046582414",
                                         ]
                                         ,
                                         [
                                             "userid"        => "321",
                                             "userfirstname" => "",
                                             "userlastname"  => "جهانبخش",
                                             "mobile"        => "09996194956",
                                             "password"      => "4876194956",
                                         ]
                                         ,
                                         [
                                             "userid"        => "322",
                                             "userfirstname" => "حسن",
                                             "userlastname"  => "مرصعی",
                                             "mobile"        => "09991730235",
                                             "password"      => "7661730235",
                                         ]
                                         ,
                                         [
                                             "userid"        => "323",
                                             "userfirstname" => "",
                                             "userlastname"  => "بختیاری",
                                             "mobile"        => "09993001622",
                                             "password"      => "1943001622",
                                         ]
                                         ,
                                         [
                                             "userid"        => "324",
                                             "userfirstname" => "علی نقی",
                                             "userlastname"  => "طباطبایی",
                                             "mobile"        => "09999943651",
                                             "password"      => "3939943651",
                                         ]
                                         ,
                                         [
                                             "userid"        => "325",
                                             "userfirstname" => "وحید",
                                             "userlastname"  => "کبریایی",
                                             "mobile"        => "09999304447",
                                             "password"      => "4409304447",
                                         ]
                                         ,
                                         [
                                             "userid"        => "326",
                                             "userfirstname" => "",
                                             "userlastname"  => "درویش",
                                             "mobile"        => "09992097117",
                                             "password"      => "6332097117",
                                         ]
                                         ,
                                         [
                                             "userid"        => "363",
                                             "userfirstname" => "",
                                             "userlastname"  => "صابری",
                                             "mobile"        => "09997208997",
                                             "password"      => "8467208997",
                                         ]
                                         ,
                                         [
                                             "userid"        => "364",
                                             "userfirstname" => "",
                                             "userlastname"  => "ارشی",
                                             "mobile"        => "09999062941",
                                             "password"      => "8279062941",
                                         ]
                                         ,
                                         [
                                             "userid"        => "366",
                                             "userfirstname" => "جعفر",
                                             "userlastname"  => "رنجبرزاده",
                                             "mobile"        => "09990856015",
                                             "password"      => "5380856015",
                                         ]
                                         ,
                                         [
                                             "userid"        => "367",
                                             "userfirstname" => "محمد رضا",
                                             "userlastname"  => "آقاجانی",
                                             "mobile"        => "09996370036",
                                             "password"      => "2836370036",
                                         ]
                                         ,
                                         [
                                             "userid"        => "478",
                                             "userfirstname" => "محمد رضا ",
                                             "userlastname"  => "حسینی فرد",
                                             "mobile"        => "09996503218",
                                             "password"      => "6396503218",
                                         ]
                                         ,
                                         [
                                             "userid"        => "533",
                                             "userfirstname" => "محمد",
                                             "userlastname"  => "صادقی",
                                             "mobile"        => "09990300629",
                                             "password"      => "2240300629",
                                         ]
                                         ,
                                         [
                                             "userid"        => "534",
                                             "userfirstname" => "باقر",
                                             "userlastname"  => "رضا خانی",
                                             "mobile"        => "09995186011",
                                             "password"      => "9255186011",
                                         ]
                                         ,
                                         [
                                             "userid"        => "535",
                                             "userfirstname" => "معین",
                                             "userlastname"  => "کریمی",
                                             "mobile"        => "09998086488",
                                             "password"      => "2358086488",
                                         ]
                                         ,
                                         [
                                             "userid"        => "536",
                                             "userfirstname" => "حسین",
                                             "userlastname"  => "کرد",
                                             "mobile"        => "09994947848",
                                             "password"      => "5954947848",
                                         ]
                                         ,
                                         [
                                             "userid"        => "537",
                                             "userfirstname" => "",
                                             "userlastname"  => "دورانی",
                                             "mobile"        => "09994869634",
                                             "password"      => "8704869634",
                                         ]
                                         ,
                                         [
                                             "userid"        => "965",
                                             "userfirstname" => "کاظم",
                                             "userlastname"  => "کاظمی",
                                             "mobile"        => "09992807002",
                                             "password"      => "6032807002",
                                         ]
                                         ,
                                         [
                                             "userid"        => "1427",
                                             "userfirstname" => "",
                                             "userlastname"  => "کازرانیان",
                                             "mobile"        => "09996246380",
                                             "password"      => "5926246380",
                                         ]
                                         ,
                                         [
                                             "userid"        => "1428",
                                             "userfirstname" => "",
                                             "userlastname"  => "شاه محمدی",
                                             "mobile"        => "09999223623",
                                             "password"      => "5819223623",
                                         ]
                                         ,
                                         [
                                             "userid"        => "1431",
                                             "userfirstname" => "محمد حسین",
                                             "userlastname"  => "شکیباییان",
                                             "mobile"        => "09999582008",
                                             "password"      => "8499582008",
                                         ]
                                         ,
                                         [
                                             "userid"        => "2875",
                                             "userfirstname" => "یاشار",
                                             "userlastname"  => "بهمند",
                                             "mobile"        => "09999472085",
                                             "password"      => "6369472085",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3172",
                                             "userfirstname" => "خسرو",
                                             "userlastname"  => "محمد زاده",
                                             "mobile"        => "09992289718",
                                             "password"      => "6482289718",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3895",
                                             "userfirstname" => "میثم",
                                             "userlastname"  => "حسین خانی",
                                             "mobile"        => "09997301087",
                                             "password"      => "5227301087",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3906",
                                             "userfirstname" => "پوریا",
                                             "userlastname"  => "رحیمی",
                                             "mobile"        => "09992800416",
                                             "password"      => "3832800416",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3971",
                                             "userfirstname" => "",
                                             "userlastname"  => "نوری",
                                             "mobile"        => "09993883868",
                                             "password"      => "6193883868",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3972",
                                             "userfirstname" => "رضا",
                                             "userlastname"  => "آقاجانی",
                                             "mobile"        => "09994582836",
                                             "password"      => "2914582836",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3973",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "امینی راد",
                                             "mobile"        => "09993368407",
                                             "password"      => "7253368407",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3974",
                                             "userfirstname" => "سید حسین",
                                             "userlastname"  => "رخ صفت",
                                             "mobile"        => "09993610514",
                                             "password"      => "8013610514",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3975",
                                             "userfirstname" => "بهمن",
                                             "userlastname"  => "مؤذنی پور",
                                             "mobile"        => "09993294993",
                                             "password"      => "5233294993",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3976",
                                             "userfirstname" => "محمد صادق",
                                             "userlastname"  => "ثابتی",
                                             "mobile"        => "09993195124",
                                             "password"      => "8163195124",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3977",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "جلادتی",
                                             "mobile"        => "09995290087",
                                             "password"      => "8715290087",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3979",
                                             "userfirstname" => "داریوش",
                                             "userlastname"  => "راوش",
                                             "mobile"        => "09995411768",
                                             "password"      => "5945411768",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3980",
                                             "userfirstname" => "پیمان",
                                             "userlastname"  => "طلوعی",
                                             "mobile"        => "09990634879",
                                             "password"      => "9810634879",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3993",
                                             "userfirstname" => "محمد حسین",
                                             "userlastname"  => "انوشه",
                                             "mobile"        => "09994536894",
                                             "password"      => "1654536894",
                                         ]
                                         ,
                                         [
                                             "userid"        => "3998",
                                             "userfirstname" => "عباس",
                                             "userlastname"  => "راستی بروجنی",
                                             "mobile"        => "09993648802",
                                             "password"      => "5303648802",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4012",
                                             "userfirstname" => "جواد",
                                             "userlastname"  => "نایب کبیر",
                                             "mobile"        => "09991738525",
                                             "password"      => "9231738525",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4019",
                                             "userfirstname" => "عمار",
                                             "userlastname"  => " تاج بخش",
                                             "mobile"        => "09991494536",
                                             "password"      => "5661494536",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4020",
                                             "userfirstname" => "سروش",
                                             "userlastname"  => "معینی",
                                             "mobile"        => "09991369930",
                                             "password"      => "2301369930",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4021",
                                             "userfirstname" => "",
                                             "userlastname"  => "نادریان",
                                             "mobile"        => "09995323369",
                                             "password"      => "8755323369",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4022",
                                             "userfirstname" => "شهروز",
                                             "userlastname"  => "رحیمی",
                                             "mobile"        => "09998327816",
                                             "password"      => "2148327816",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4023",
                                             "userfirstname" => "سیروس",
                                             "userlastname"  => "نصیری",
                                             "mobile"        => "09992983588",
                                             "password"      => "2872983588",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4030",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "صنیعی طهرانی",
                                             "mobile"        => "09991357099",
                                             "password"      => "8431357099",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4034",
                                             "userfirstname" => "هامون",
                                             "userlastname"  => "سبطی",
                                             "mobile"        => "09999865115",
                                             "password"      => "5899865115",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4035",
                                             "userfirstname" => "حامد",
                                             "userlastname"  => "پویان نظر",
                                             "mobile"        => "09991085599",
                                             "password"      => "8131085599",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4036",
                                             "userfirstname" => "فرشید",
                                             "userlastname"  => "داداشی",
                                             "mobile"        => "09996947115",
                                             "password"      => "9556947115",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4037",
                                             "userfirstname" => "ناصر",
                                             "userlastname"  => "حشمتی",
                                             "mobile"        => "09993403835",
                                             "password"      => "3463403835",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4038",
                                             "userfirstname" => "محمدامین",
                                             "userlastname"  => "نباخته",
                                             "mobile"        => "09992595909",
                                             "password"      => "6592595909",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4039",
                                             "userfirstname" => "جلال",
                                             "userlastname"  => "موقاری",
                                             "mobile"        => "09997805308",
                                             "password"      => "7187805308",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4040",
                                             "userfirstname" => "محسن",
                                             "userlastname"  => " آهویی",
                                             "mobile"        => "09996710139",
                                             "password"      => "1646710139",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4041",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "ناصر شریعت",
                                             "mobile"        => "09994935716",
                                             "password"      => "4554935716",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4043",
                                             "userfirstname" => "سید حسام الدین",
                                             "userlastname"  => "جلالی",
                                             "mobile"        => "09999934699",
                                             "password"      => "1849934699",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4046",
                                             "userfirstname" => "ابوالفضل",
                                             "userlastname"  => "جعفری",
                                             "mobile"        => "09997858374",
                                             "password"      => "8947858374",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4047",
                                             "userfirstname" => "سهراب",
                                             "userlastname"  => "ابوذرخانی فرد",
                                             "mobile"        => "09991774103",
                                             "password"      => "9271774103",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4048",
                                             "userfirstname" => "سید حبیب",
                                             "userlastname"  => "میرانی",
                                             "mobile"        => "09992431052",
                                             "password"      => "4642431052",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4049",
                                             "userfirstname" => "حامد",
                                             "userlastname"  => "امیراللهی",
                                             "mobile"        => "09993704294",
                                             "password"      => "4903704294",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4050",
                                             "userfirstname" => "سید حمید رضا",
                                             "userlastname"  => "مداح حسینی",
                                             "mobile"        => "09991968225",
                                             "password"      => "0000000000",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4051",
                                             "userfirstname" => "علی اصغر",
                                             "userlastname"  => "ترجانی",
                                             "mobile"        => "09993094760",
                                             "password"      => "2693094760",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4052",
                                             "userfirstname" => "مهدی",
                                             "userlastname"  => "صفری",
                                             "mobile"        => "09990789285",
                                             "password"      => "1420789285",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4053",
                                             "userfirstname" => "نیما",
                                             "userlastname"  => "صدفی",
                                             "mobile"        => "09996362893",
                                             "password"      => "6116362893",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4054",
                                             "userfirstname" => "رضا",
                                             "userlastname"  => "تهرانی",
                                             "mobile"        => "09999837820",
                                             "password"      => "4119837820",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4055",
                                             "userfirstname" => "بهمن",
                                             "userlastname"  => "منصوری",
                                             "mobile"        => "09995329266",
                                             "password"      => "6905329266",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4056",
                                             "userfirstname" => "علیرضا",
                                             "userlastname"  => "محمد زاده",
                                             "mobile"        => "09993198122",
                                             "password"      => "9933198122",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4057",
                                             "userfirstname" => "امیر حسین",
                                             "userlastname"  => "دلال شریفی",
                                             "mobile"        => "09994849196",
                                             "password"      => "6514849196",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4058",
                                             "userfirstname" => "امید",
                                             "userlastname"  => "احدیان",
                                             "mobile"        => "09993959187",
                                             "password"      => "3933959187",
                                         ]
                                         ,
                                         [
                                             "userid"        => "4059",
                                             "userfirstname" => "علی",
                                             "userlastname"  => "محمدی",
                                             "mobile"        => "09992359493",
                                             "password"      => "7562359493",
                                         ],
                                     ]);
    }


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'nameSlug')) {
                $table->string('nameSlug')
                      ->nullable()
                      ->comment("اسلاگ شده نام")
                      ->after("lastName");
            }
        });

        $teachers = \App\User::getTeachers();
        $output = new ConsoleOutput();
        $output->writeln('insert teacher slug....');
        $progress = new ProgressBar($output, $teachers->count());
        foreach ($teachers as $teacher) {
            $oldTeacher = $this->oldTeachers->where("mobile", $teacher->mobile)
                                            ->first();
            if (isset($oldTeacher)) {
                $teacher->nameSlug = $this->make_slug($oldTeacher["userfirstname"] . " " . $oldTeacher["userlastname"], "_");
            } else {
                $teacher->nameSlug = $this->make_slug($teacher->firstName . " " . $teacher->lastName, "_");
            }
            dump($teacher->nameSlug);
            if (!$teacher->update()) {
                echo "Error on updating teacher #" . $teacher->id;
                echo "<br>";
            }
            $progress->advance();
        }
        $progress->finish();
        $output->writeln('Done!');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'nameSlug')) {
                $table->dropColumn('nameSlug');
            }
        });
    }
}
