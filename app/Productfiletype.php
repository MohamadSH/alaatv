<?php

namespace App;

use App\Traits\DateTrait;
use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;

/**
 * App\Productfiletype
 *
 * @property int                                                         $id
 * @property string|null                                                 $name        نام نوع
 * @property string|null                                                 $displayName نام قابل نمایش نوع
 * @property string|null                                                 $description نام قابل نمایش نوع
 * @property Carbon|null                                         $created_at
 * @property Carbon|null                                         $updated_at
 * @property Carbon|null                                         $deleted_at
 * @property-read Collection|Productfile[] $productfiles
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Productfiletype onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Productfiletype whereCreatedAt($value)
 * @method static Builder|Productfiletype whereDeletedAt($value)
 * @method static Builder|Productfiletype whereDescription($value)
 * @method static Builder|Productfiletype whereDisplayName($value)
 * @method static Builder|Productfiletype whereId($value)
 * @method static Builder|Productfiletype whereName($value)
 * @method static Builder|Productfiletype whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Productfiletype withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Productfiletype withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Productfiletype newModelQuery()
 * @method static Builder|Productfiletype newQuery()
 * @method static Builder|Productfiletype query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                       $cache_cooldown_seconds
 * @property-read int|null                                                    $productfiles_count
 */
class Productfiletype extends BaseModel
{
    use DateTrait;
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'displayName',
    ];

    /**
     * @return array
     */
    public static function makeSelectArray(): array
    {
        $productFileTypes = Productfiletype::pluck('displayName', 'id')
            ->toArray();
        $productFileTypes = Arr::add($productFileTypes, 0, "انتخاب کنید");
        $productFileTypes = Arr::sortRecursive($productFileTypes);

        return $productFileTypes;
    }

    public function productfiles()
    {
        return $this->hasMany('\App\Productfile');
    }

}
