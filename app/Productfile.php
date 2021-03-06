<?php

namespace App;

use App\Traits\DateTrait;
use App\Traits\Helper;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Kalnoy\Nestedset\QueryBuilder;

/**
 * App\Productfile
 *
 * @property int                       $id
 * @property int                       $product_id         آی دی مشخص کننده محصول این فایل
 * @property int|null                  $productfiletype_id توضیج درباره نوع رشته
 * @property string|null               $file               اسم فایل
 * @property string|null               $cloudFile          فایل آپلود شده در سرور خارجی
 * @property string|null               $name               عنوان فایل
 * @property string|null               $description        توضیح درباره فایل
 * @property int                       $order              ترتیب فایل
 * @property int                       $enable             فعال بودن یا غیرفعال بودن فایل
 * @property string|null               $validSince         تاریخ شروع استفاده از فایل
 * @property Carbon|null               $created_at
 * @property Carbon|null               $updated_at
 * @property Carbon|null               $deleted_at
 * @property-read Product              $product
 * @property-read Productfiletype|null $productfiletype
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Productfile onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Productfile whereCloudFile($value)
 * @method static Builder|Productfile whereCreatedAt($value)
 * @method static Builder|Productfile whereDeletedAt($value)
 * @method static Builder|Productfile whereDescription($value)
 * @method static Builder|Productfile whereEnable($value)
 * @method static Builder|Productfile whereFile($value)
 * @method static Builder|Productfile whereId($value)
 * @method static Builder|Productfile whereName($value)
 * @method static Builder|Productfile whereOrder($value)
 * @method static Builder|Productfile whereProductId($value)
 * @method static Builder|Productfile whereProductfiletypeId($value)
 * @method static Builder|Productfile whereUpdatedAt($value)
 * @method static Builder|Productfile whereValidSince($value)
 * @method static \Illuminate\Database\Query\Builder|Productfile withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Productfile withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Productfile enable()
 * @method static Builder|Productfile valid()
 * @method static Builder|Productfile newModelQuery()
 * @method static Builder|Productfile newQuery()
 * @method static Builder|Productfile query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property int|null             $content_id
 * @property int|null             $contentset_id
 * @property-read Content|null    $content
 * @property-read mixed           $cache_cooldown_seconds
 * @property-read Contentset|null $set
 * @method static Builder|Productfile whereContentId($value)
 * @method static Builder|Productfile whereContentsetId($value)
 */
class Productfile extends BaseModel
{
    use Helper, DateTrait;
    /**
     * @var array
     */
    protected $fillable = [
        'product_id',
        'productfiletype_id',
        'file',
        'name',
        'description',
        'order',
        'enable',
        'validSince',
        'cloudFile',
    ];

    public function product()
    {
        return $this->belongsTo('\App\Product');
    }

    public function content()
    {
        return $this->belongsTo('\App\Content');
    }

    public function set()
    {
        return $this->belongsTo(Contentset::class, 'contentset_id');
    }

    public function productfiletype()
    {
        return $this->belongsTo('\App\Productfiletype');
    }


    /**
     * Scope a query to only include enable(or disable) Products.
     *
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeEnable($query)
    {
        return $query->where('enable', '=', 1);
    }

    public function scopeValid($query)
    {
        /** @var QueryBuilder $query */
        return $query->where(function ($q) {
            /** @var QueryBuilder $q */
            $q->where('validSince', '<', Carbon::createFromFormat('Y-m-d H:i:s', Carbon::now('Asia/Tehran')))
                ->orwhereNull('validSince');
        });
    }

    /**
     * @param $fileName
     * @param $productId
     *
     * @return string
     */
    public function getExternalLinkForProductFileByFileName($fileName, $productId): string
    {
        $cloudFile = Productfile::where('file', $fileName)
            ->whereIn('product_id', $productId)
            ->get()
            ->first()->cloudFile;
        //TODO: verify "$productFileLink = "http://".env("SFTP_HOST" , "").":8090/". $cloudFile;"
        $productFileLink = config('constants.DOWNLOAD_SERVER_PROTOCOL',
                'https://') . config('constants.PAID_SERVER_NAME') . $cloudFile;
        $unixTime        = Carbon::today()
            ->addDays(2)->timestamp;
        $userIP          = request()->ip();
        //TODO: fix diffrent Ip
        $ipArray    = explode('.', $userIP);
        $ipArray[3] = 0;
        $userIP     = implode('.', $ipArray);

        $linkHash     = generateSecurePathHash($unixTime, $userIP, 'TakhteKhak', $cloudFile);
        $externalLink = $productFileLink . '?md5=' . $linkHash . '&expires=' . $unixTime;
        return $externalLink;
    }
}
