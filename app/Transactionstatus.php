<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Transactionstatus
 *
 * @property int                                                              $id
 * @property string|null                                                      $name        نام وضعیت
 * @property string|null                                                      $displayName نام قابل نمایش این وضعیت
 * @property int                                                              $order       ترتیب
 * @property string|null                                                      $description توضیح درباره وضعیت
 * @property \Carbon\Carbon|null                                              $created_at
 * @property \Carbon\Carbon|null                                              $updated_at
 * @property \Carbon\Carbon|null                                              $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Transaction[] $transactions
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Transactionstatus onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Transactionstatus whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Transactionstatus withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Transactionstatus withoutTrashed()
 * @mixin \Eloquent
 */
class Transactionstatus extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function transactions()
    {
        return $this->hasMany('App\Transaction');
    }
}
