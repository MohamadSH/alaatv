<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Contract
 *
 * @property int $id
 * @property int $user_id کاربر طرف قرارداد
 * @property int|null $product_id محصول قرارداد
 * @property int|null $registerer_id کاربر ثبت کننده قرارداد
 * @property string|null $name نام قرارداد
 * @property string|null $description توضیح درباره قرارداد
 * @property \Illuminate\Support\Carbon|null $since شروع قرارداد
 * @property \Illuminate\Support\Carbon|null $till اتمام قرارداد
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Product|null $product
 * @property-read \App\User|null $registerer
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereRegistererId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereSince($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereTill($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Contract whereUserId($value)
 * @mixin \Eloquent
 */
class Contract extends Model
{
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'since',
        'till'
    ];

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'product_id',
        'registerer_id'
    ];

    public function user(){
        return $this->belongsTo(User::Class);
    }

    public function registerer(){
        return $this->belongsTo(User::Class);
    }

    public function product(){
        return $this->belongsTo(Product::Class);
    }
}
