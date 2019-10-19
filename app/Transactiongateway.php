<?php

namespace App;

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
 * @property int                                                              $enable                        فعال بودن
 *           یا نبودن درگاه
 * @property int                                                              $order                         ترتیب - در
 *           صورت نیاز به استفاده
 * @property int|null                                                         $bank_id                       آیدی مشخص
 *           کننده بانک درگاه
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Transactiongateway onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereBankId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereCertificatePrivateKeyFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway
 *         whereCertificatePrivateKeyPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereEnable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereMerchantNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereMerchantPassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transactiongateway withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Transactiongateway withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway enable($enable = 1)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactiongateway name($name)
 * @property-read int|null $transactions_count
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
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  int                                    $enable
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnable($query, int $enable = 1)
    {
        return $query->where('enable', $enable);
    }
    
    /**
     *  Scope a query to only include Gateways with specified name.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string                                 $name
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeName($query, string $name)
    {
        return $query->where('name', $name);
    }
}
