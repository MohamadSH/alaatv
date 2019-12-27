<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Contract
 *
 * @property int                             $id
 * @property int                             $user_id       کاربر طرف قرارداد
 * @property int|null                        $product_id    محصول قرارداد
 * @property int|null                        $registerer_id کاربر ثبت کننده قرارداد
 * @property string|null                     $name          نام قرارداد
 * @property string|null                     $description   توضیح درباره قرارداد
 * @property Carbon|null $since         شروع قرارداد
 * @property Carbon|null $till          اتمام قرارداد
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @property-read Product|null               $product
 * @property-read User|null                  $registerer
 * @property-read User                       $user
 * @method static Builder|Contract newModelQuery()
 * @method static Builder|Contract newQuery()
 * @method static Builder|Contract query()
 * @method static Builder|Contract whereCreatedAt($value)
 * @method static Builder|Contract whereDeletedAt($value)
 * @method static Builder|Contract whereDescription($value)
 * @method static Builder|Contract whereId($value)
 * @method static Builder|Contract whereName($value)
 * @method static Builder|Contract whereProductId($value)
 * @method static Builder|Contract whereRegistererId($value)
 * @method static Builder|Contract whereSince($value)
 * @method static Builder|Contract whereTill($value)
 * @method static Builder|Contract whereUpdatedAt($value)
 * @method static Builder|Contract whereUserId($value)
 * @mixin Eloquent
 */
class Contract extends Model
{
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'since',
        'till',
    ];

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'product_id',
        'registerer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::Class);
    }

    public function registerer()
    {
        return $this->belongsTo(User::Class);
    }

    public function product()
    {
        return $this->belongsTo(Product::Class);
    }
}
