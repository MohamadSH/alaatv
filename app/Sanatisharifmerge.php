<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Sanatisharifmerge
 *
 * @property int               $id
 * @property int|null          $videoid                     آی دی مشخص کننده یک فیلم
 * @property int               $videoTransferred            فیلم به آلاء منتقل شده یا خیر؟
 * @property string|null       $videoname                   نام فیلم
 * @property string|null       $videodescrip                توضیح فیلم
 * @property int               $videosession                جلسه فیلم
 * @property string|null       $keywords                    کلمات کلیدی فیلم
 * @property string|null       $videolink                   آدرس فایل hd فیلم
 * @property string|null       $videolinkhq                 آدرس فایل hq فیلم
 * @property string|null       $videolink240p               آدرس فایل 240p فیلم
 * @property string|null       $videolinktakhtesefid        آدرس فایل در سرور تخته سفید
 * @property int|null          $videoEnable                 فعال بودن یا نبودن فیلم
 * @property string|null       $thumbnail                   آدرس فایل تامبنیل فیلم
 * @property int|null          $pamphletid                  آی دی مشخص کننده یک جزوه
 * @property int               $pamphletTransferred         جزوه به آلاء منتقل شده یا خیر؟
 * @property string|null       $pamphletname                نام جزوه
 * @property string|null       $pamphletaddress             آدرس فایل جزوه
 * @property string|null       $pamphletdescrip             توضیح جزوه
 * @property int               $pamphletsession             جلسه جزوه
 * @property int|null          $pamphletEnable              فعال بودن یا نبودن جزوه
 * @property int               $isexercise                  فایل جزوه یک آزمون است یا خیر
 * @property int|null          $lessonid                    آی دی مشخص کننده درس
 * @property int               $lessonTransferred           درس به آلاء منتقل شده یا خیر؟
 * @property string|null       $lessonname                  نام درس
 * @property int|null          $lessonEnable                فعال بودن یا نبودن درس
 * @property int|null          $depid                       آی دی مشخص کننده مقطع
 * @property int               $departmentTransferred       مقطع به آلاء منتقل شده یا خیر؟
 * @property string|null       $depname                     نام مقطع
 * @property string|null       $depyear                     سال مقطع
 * @property int|null          $departmentlessonid          آی دی مشخص کننده درس دپارتمان
 * @property string|null       $pic                         عکس دپلسن
 * @property int               $departmentlessonTransferred درس دپارتمان به آلاء منتقل شده یا خیر؟
 * @property int|null          $departmentlessonEnable      فعال بودن یا نبودن درس دپارتمان
 * @property string|null       $teacherfirstname            نام کوچک دبیر
 * @property string|null       $teacherlastname             نام خانوادگی دبیر
 * @property string|null       $pageOldAddress              آدرس قدیم صفحه
 * @property string|null       $pageNewAddress              آدرس جدید صفحه
 * @property int|null          $content_id                  آدرس محتوای نظیر در صورت وجود
 * @property Carbon|null       $created_at
 * @property Carbon|null       $updated_at
 * @property Carbon|null       $deleted_at
 * @property-read Content|null $content
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Sanatisharifmerge onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Sanatisharifmerge whereCreatedAt($value)
 * @method static Builder|Sanatisharifmerge whereDeletedAt($value)
 * @method static Builder|Sanatisharifmerge whereDepartmentTransferred($value)
 * @method static Builder|Sanatisharifmerge whereDepartmentlessonEnable($value)
 * @method static Builder|Sanatisharifmerge whereDepartmentlessonTransferred($value)
 * @method static Builder|Sanatisharifmerge whereDepartmentlessonid($value)
 * @method static Builder|Sanatisharifmerge whereDepid($value)
 * @method static Builder|Sanatisharifmerge whereDepname($value)
 * @method static Builder|Sanatisharifmerge whereDepyear($value)
 * @method static Builder|Sanatisharifmerge whereContentId($value)
 * @method static Builder|Sanatisharifmerge whereId($value)
 * @method static Builder|Sanatisharifmerge whereIsexercise($value)
 * @method static Builder|Sanatisharifmerge whereKeywords($value)
 * @method static Builder|Sanatisharifmerge whereLessonEnable($value)
 * @method static Builder|Sanatisharifmerge whereLessonTransferred($value)
 * @method static Builder|Sanatisharifmerge whereLessonid($value)
 * @method static Builder|Sanatisharifmerge whereLessonname($value)
 * @method static Builder|Sanatisharifmerge wherePageNewAddress($value)
 * @method static Builder|Sanatisharifmerge wherePageOldAddress($value)
 * @method static Builder|Sanatisharifmerge wherePamphletEnable($value)
 * @method static Builder|Sanatisharifmerge wherePamphletTransferred($value)
 * @method static Builder|Sanatisharifmerge wherePamphletaddress($value)
 * @method static Builder|Sanatisharifmerge wherePamphletdescrip($value)
 * @method static Builder|Sanatisharifmerge wherePamphletid($value)
 * @method static Builder|Sanatisharifmerge wherePamphletname($value)
 * @method static Builder|Sanatisharifmerge wherePamphletsession($value)
 * @method static Builder|Sanatisharifmerge wherePic($value)
 * @method static Builder|Sanatisharifmerge whereTeacherfirstname($value)
 * @method static Builder|Sanatisharifmerge whereTeacherlastname($value)
 * @method static Builder|Sanatisharifmerge whereThumbnail($value)
 * @method static Builder|Sanatisharifmerge whereUpdatedAt($value)
 * @method static Builder|Sanatisharifmerge whereVideoEnable($value)
 * @method static Builder|Sanatisharifmerge whereVideoTransferred($value)
 * @method static Builder|Sanatisharifmerge whereVideodescrip($value)
 * @method static Builder|Sanatisharifmerge whereVideoid($value)
 * @method static Builder|Sanatisharifmerge whereVideolink($value)
 * @method static Builder|Sanatisharifmerge whereVideolink240p($value)
 * @method static Builder|Sanatisharifmerge whereVideolinkhq($value)
 * @method static Builder|Sanatisharifmerge whereVideolinktakhtesefid($value)
 * @method static Builder|Sanatisharifmerge whereVideoname($value)
 * @method static Builder|Sanatisharifmerge whereVideosession($value)
 * @method static \Illuminate\Database\Query\Builder|Sanatisharifmerge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Sanatisharifmerge withoutTrashed()
 * @mixin Eloquent
 * @property int|null          $educationalcontent_id       آدرس محتوای نظیر در صورت وجود
 * @method static Builder|Sanatisharifmerge whereEducationalcontentId($value)
 * @method static Builder|Sanatisharifmerge newModelQuery()
 * @method static Builder|Sanatisharifmerge newQuery()
 * @method static Builder|Sanatisharifmerge query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed        $cache_cooldown_seconds
 */
class Sanatisharifmerge extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'videoid',
        'videoTransferred',
        'videoname',
        'videodescrip',
        'videosession',
        'keywords',
        'videolink',
        'videolinkhq',
        'videolink240p',
        'videolinktakhtesefid',
        'videoEnable',
        'thumbnail',
        'pamphletid',
        'pamphletTransferred',
        'pamphletname',
        'pamphletaddress',
        'pamphletdescrip',
        'pamphletsession',
        'isexercise',
        'lessonid',
        'lessonTransferred',
        'lessonname',
        'lessonEnable',
        'depid',
        'departmentTransferred',
        'depname',
        'depyear',
        'departmentlessonid',
        'pic',
        'departmentlessonTransferred',
        'departmentlessonEnable',
        'teacherfirstname',
        'teacherlastname',
        'pageOldAddress',
        'pageNewAddress',
        'educationalcontent_id',
    ];

    public function content()
    {
        return $this->belongsTo(Content::Class, 'educationalcontent_id', 'id');
    }
}
