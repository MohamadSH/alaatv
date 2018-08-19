<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Discounttype
 *
 * @property int $id
 * @property string|null $name نام
 * @property string|null $displayName نام قابل نمایش
 * @property string|null $description توضیح کوتاه
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Discounttype whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Discounttype extends Model
{
    //
}
