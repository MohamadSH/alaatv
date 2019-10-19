<?php

namespace App;

/**
 * App\Paymentmethod
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام این روش
 * @property string|null                                                      $displayName نام قابل نمایش روش
 * @property string|null                                                      $description توضیح این روش
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentmethod onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentmethod withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Paymentmethod withoutTrashed()
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Paymentmethod query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null $transactions_count
 */
class Paymentmethod extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
    
    public function transactions()
    {
        return $this->hasMany('\App\Transaction');
    }
}
