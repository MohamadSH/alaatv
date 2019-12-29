<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * App\Transactiongateway
 *
 * @property int                                                              $id
 * @property string|null                                                      $name                          نام سیستمی
 *           درگاه
 * @property string|null                                                      $displayName                   نام قابل
 *           نمایش درگاه
 * @property string|null                                                      $description                   توضیح
 *           درباره درگاه
 * @property string|null                                                      $merchantNumber                شماره
 *           مرچنت درگاه
 * @property string|null                                                      $certificatePrivateKeyFile     فایل گواهی
 *           اس اس ال برای کلید خصوصی امضا دیجیتال
 * @property string|null                                                      $certificatePrivateKeyPassword رمز عبور
 *           برای کلید خصوصی امضا دیجیتال
 * @property string|null                                                      $merchantPassword              رمز
 *           فروشنده
 * @property int                                                         $enable                        فعال بودن
 *           یا نبودن درگاه
 * @property int                                                         $order                         ترتیب - در
 *           صورت نیاز به استفاده
 * @property int|null                                                    $bank_id                       آیدی مشخص
 *           کننده بانک درگاه
 * @property Carbon|null                                         $created_at
 * @property Carbon|null                                         $updated_at
 * @property Carbon|null                                         $deleted_at
 * @property-read Collection|Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Transactiongateway onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Transactiongateway whereBankId($value)
 * @method static Builder|Transactiongateway whereCertificatePrivateKeyFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway
 *         whereCertificatePrivateKeyPassword($value)
 * @method static Builder|Transactiongateway whereCreatedAt($value)
 * @method static Builder|Transactiongateway whereDeletedAt($value)
 * @method static Builder|Transactiongateway whereDescription($value)
 * @method static Builder|Transactiongateway whereDisplayName($value)
 * @method static Builder|Transactiongateway whereEnable($value)
 * @method static Builder|Transactiongateway whereId($value)
 * @method static Builder|Transactiongateway whereMerchantNumber($value)
 * @method static Builder|Transactiongateway whereMerchantPassword($value)
 * @method static Builder|Transactiongateway whereName($value)
 * @method static Builder|Transactiongateway whereOrder($value)
 * @method static Builder|Transactiongateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Transactiongateway withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Transactiongateway withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Transactiongateway enable($enable = 1)
 * @method static Builder|Transactiongateway newModelQuery()
 * @method static Builder|Transactiongateway newQuery()
 * @method static Builder|Transactiongateway query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @method static Builder|Transactiongateway name($name)
 * @property-read int|null                                                    $transactions_count
 */
class Transactiongateway extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'merchantNumber',
        'enable',
        'order',
        'bank_id',
        'merchantPassword',
        'certificatePrivateKeyFile',
        'certificatePrivateKeyPassword',

    ];

    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }

    /**
     * Scope a query to only include enable(or disable) Gateways.
     *
     * @param Builder $query
     * @param int                                   $enable
     *
     * @return Builder
     */
    public function scopeEnable($query, int $enable = 1)
    {
        return $query->where('enable', $enable);
    }

    /**
     *  Scope a query to only include Gateways with specified name.
     *
     * @param Builder $query
     * @param string                                $name
     *
     * @return Builder
     */
    public function scopeName($query, string $name)
    {
        return $query->where('name', $name);
    }
}
