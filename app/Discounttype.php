<?php

namespace App;

/**
 * App\Discounttype
 *
 * @property int                 $id
 * @property string|null         $name        نام
 * @property string|null         $displayName نام قابل نمایش
 * @property string|null         $description توضیح کوتاه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null         $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\BaseModel withCacheCooldownSeconds($seconds)
 */
class Discounttype extends BaseModel
{
    //
}
