<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Sanatisharifmerge
 *
 * @property int                    $id
 * @property int|null               $videoid                     آی دی مشخص کننده یک فیلم
 * @property int                    $videoTransferred            فیلم به آلاء منتقل شده یا خیر؟
 * @property string|null            $videoname                   نام فیلم
 * @property string|null            $videodescrip                توضیح فیلم
 * @property int                    $videosession                جلسه فیلم
 * @property string|null            $keywords                    کلمات کلیدی فیلم
 * @property string|null            $videolink                   آدرس فایل hd فیلم
 * @property string|null            $videolinkhq                 آدرس فایل hq فیلم
 * @property string|null            $videolink240p               آدرس فایل 240p فیلم
 * @property string|null            $videolinktakhtesefid        آدرس فایل در سرور تخته سفید
 * @property int|null               $videoEnable                 فعال بودن یا نبودن فیلم
 * @property string|null            $thumbnail                   آدرس فایل تامبنیل فیلم
 * @property int|null               $pamphletid                  آی دی مشخص کننده یک جزوه
 * @property int                    $pamphletTransferred         جزوه به آلاء منتقل شده یا خیر؟
 * @property string|null            $pamphletname                نام جزوه
 * @property string|null            $pamphletaddress             آدرس فایل جزوه
 * @property string|null            $pamphletdescrip             توضیح جزوه
 * @property int                    $pamphletsession             جلسه جزوه
 * @property int|null               $pamphletEnable              فعال بودن یا نبودن جزوه
 * @property int                    $isexercise                  فایل جزوه یک آزمون است یا خیر
 * @property int|null               $lessonid                    آی دی مشخص کننده درس
 * @property int                    $lessonTransferred           درس به آلاء منتقل شده یا خیر؟
 * @property string|null            $lessonname                  نام درس
 * @property int|null               $lessonEnable                فعال بودن یا نبودن درس
 * @property int|null               $depid                       آی دی مشخص کننده مقطع
 * @property int                    $departmentTransferred       مقطع به آلاء منتقل شده یا خیر؟
 * @property string|null            $depname                     نام مقطع
 * @property string|null            $depyear                     سال مقطع
 * @property int|null               $departmentlessonid          آی دی مشخص کننده درس دپارتمان
 * @property string|null            $pic                         عکس دپلسن
 * @property int                    $departmentlessonTransferred درس دپارتمان به آلاء منتقل شده یا خیر؟
 * @property int|null               $departmentlessonEnable      فعال بودن یا نبودن درس دپارتمان
 * @property string|null            $teacherfirstname            نام کوچک دبیر
 * @property string|null            $teacherlastname             نام خانوادگی دبیر
 * @property string|null            $pageOldAddress              آدرس قدیم صفحه
 * @property string|null            $pageNewAddress              آدرس جدید صفحه
 * @property int|null               $content_id                  آدرس محتوای نظیر در صورت وجود
 * @property \Carbon\Carbon|null    $created_at
 * @property \Carbon\Carbon|null    $updated_at
 * @property \Carbon\Carbon|null    $deleted_at
 * @property-read \App\Content|null $content
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Sanatisharifmerge onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepartmentTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepartmentlessonEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepartmentlessonTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepartmentlessonid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereDepyear($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereContentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereIsexercise($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereLessonEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereLessonTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereLessonid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereLessonname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePageNewAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePageOldAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletaddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletdescrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePamphletsession($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge wherePic($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereTeacherfirstname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereTeacherlastname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideoEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideoTransferred($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideodescrip($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideoid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideolink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideolink240p($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideolinkhq($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideolinktakhtesefid($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideoname($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereVideosession($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Sanatisharifmerge withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Sanatisharifmerge withoutTrashed()
 * @mixin \Eloquent
 * @property int|null               $educationalcontent_id       آدرس محتوای نظیر در صورت وجود
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge whereEducationalcontentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Sanatisharifmerge query()
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
        'content_id',
    ];

    public function content()
    {
        return $this->belongsTo('App\Content');
    }
}
