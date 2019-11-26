<?php


namespace App\Classes;


use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class TagSplitter
{

    //Nezame Amoozeshi
    private const G0 = ['نظام_آموزشی_جدید', 'نظام_آموزشی_قدیم'];

    //Maghtaa
    private const G1 = [
        'کنکور', 'دهم', 'یازدهم', 'دوازدهم', 'المپیاد', 'اول_دبیرستان', 'دوم_دبیرستان', 'سوم_دبیرستان', 'چهارم_دبیرستان',
    ];

    //Reshte
    private const G2 = ['رشته_ریاضی', 'رشته_تجربی', 'رشته_انسانی'];

    //Dars
    private const G3 = [
        'آمار_و_مدلسازی',
        'اخلاق',
        'دین_و_زندگی',
        'ریاضی_انسانی',
        'ریاضی_و_آمار',
        'زبان_انگلیسی',
        'مشاوره',
        'منطق',
        'هندسه',
        'فیزیک',
        'عربی',
        'شیمی',
        'زیست_شناسی',
        'زبان_و_ادبیات_فارسی',
        'ریاضی_پایه',
        'ریاضی_تجربی',
        'دین_و_زندگی',
        'المپیاد_نجوم',
        'المپیاد_فیزیک',
        'گسسته',
        'هندسه_کنکور',
        'هندسه_پایه',
        'دیفرانسیل',
        'حسابان',
        'جبر_و_احتمال',
        'تحلیلی',
        'المپیاد_نجوم',
        'آمار_و_احتمال'
    ];

    //Dabir
    private const G4 = [
        'امید_زاهدی',
        'محمد_علی_امینی_راد',
        'یاشار_بهمند',
        'مصطفی_جعفری_نژاد',
        'سید_حسام_الدین_جلالی',
        'رضا_آقاجانی',
        'مهدی_امینی_راد',
        'محمد_پازوکی',
        'جلال_موقاری',
        'پوریا_رحیمی',
        'عباس_راستی_بروجنی',
        'مسعود_حدادی',
        'ابوالفضل_جعفری',
        'ارشی',
        'وحید_کبریایی',
        'رضا_شامیزاده',
        'کاظم_کاظمی',
        'عبدالرضا_مرادی',
        'محمد_صادقی',
        'هامون_سبطی',
        'داریوش_راوش',
        'میثم__حسین_خانی',
        'جعفر_رنجبرزاده',
        'مهدی_تفتی',
        'کیاوش_فراهانی',
        'علی_اکبر_عزتی',
        'درویش',
        'کازرانیان',
        'نادریان',
        'حمید_فدایی_فرد',
        'پیمان_طلوعی',
        'علیرضا_رمضانی',
        'فرشید_داداشی',
        'جهانبخش',
        'حامد_پویان_نظر',
        'محسن_معینی',
        'مهدی_صنیعی_طهرانی',
        'محمد_حسین_شکیباییان',
        'روح_الله_حاجی_سلیمانی',
        'جعفری',
        'محمد_حسین_انوشه',
        'محمد_رضا_آقاجانی',
        'مهدی_ناصر_شریعت',
        'میلاد_ناصح_زاده',
        'پدرام_علیمرادی',
        'ناصر_حشمتی',
        'مهدی_جلادتی',
        'عمار_تاج_بخش',
        'محسن_آهویی',
        'خسرو_محمد_زاده',
        'محمدامین_نباخته',
        'علی_صدری',
        'محمد_رضا_حسینی_فرد',
        'محمد_صادق_ثابتی',
        'جواد_نایب_کبیر',
        'محمدرضا_مقصودی',
        'محسن_شهریان',
        'حسین_کرد',
        'شهروز_رحیمی',
        'حسن_مرصعی',
        'سروش_معینی',
        'شاه_محمدی',
        'بهمن_مؤذنی_پور',
        'سیروس_نصیری',
        'محمد_رضا_یاری',
        'احسان_گودرزی',
        'میثم_حسین_خانی',
    ];

    //Tree
    private const G5 = [];

    public function group(array $tags): Collection
    {
        return Cache::tags(['tagGroup'])
            ->remember('group_of_tags:/'.md5(implode(' ', $tags)), config('constants.CACHE_600'),
                function () use ($tags) {
                    $groupedTags = collect();
                    foreach ($tags as $tag) {
                        $groupNumber = $this->findGroupOfTag($tag);
                        $savedTags   = ($groupedTags->has($groupNumber)) ? $groupedTags[$groupNumber] : [];
                        $savedTags[] = $tag;
                        $groupedTags->put($groupNumber, $savedTags);
                    }
                    return $groupedTags;
                });
    }

    private function findGroupOfTag(string $tag) :int
    {
        return Cache::tags(['tagGroup'])
            ->remember('group_number_'.$tag, config('constants.CACHE_600'), function () use ($tag) {
                if(in_array($tag, self::G0)){
                    return 0 ;
                }
                if (in_array($tag, self::G1)) {
                    return 1 ;
                }
                if (in_array($tag, self::G2)) {
                    return 2 ;
                }
                if (in_array($tag, self::G3)) {
                    return 3 ;
                }
                if (in_array($tag, self::G4)) {
                    return 4 ;
                }
                if (in_array($tag, self::G5)) {
                    return 5 ;
                }
                return 6;
            });

    }
}
