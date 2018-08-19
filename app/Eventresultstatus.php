<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Eventresultstatus
 *
 * @property int $id
 * @property string|null $name نام این وضعیت
 * @property string|null $displayName نام قابل نمایش این وضعیت
 * @property string|null $description توضیح این وضعیت
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereDisplayName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Eventresultstatus whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Eventresultstatus extends Model
{
    //
}
