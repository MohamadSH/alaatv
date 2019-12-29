<?php

namespace App;

use Carbon\Carbon;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * App\Attributeset
 *
 * @property int                              $id
 * @property string|null                      $name        نام دسته
 * @property string|null                      $description توضیح دسته
 * @property int                              $order       ترتیب دسته صفت
 * @property Carbon|null              $created_at
 * @property Carbon|null              $updated_at
 * @property Carbon|null              $deleted_at
 * @property-read Collection|Attributegroup[] $attributegroups
 * @property-read Collection|Product[]        $products
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|Attributeset onlyTrashed()
 * @method static bool|null restore()
 * @method static Builder|Attributeset whereCreatedAt($value)
 * @method static Builder|Attributeset whereDeletedAt($value)
 * @method static Builder|Attributeset whereDescription($value)
 * @method static Builder|Attributeset whereId($value)
 * @method static Builder|Attributeset whereName($value)
 * @method static Builder|Attributeset whereOrder($value)
 * @method static Builder|Attributeset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|Attributeset withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Attributeset withoutTrashed()
 * @mixin Eloquent
 * @method static Builder|Attributeset newModelQuery()
 * @method static Builder|Attributeset newQuery()
 * @method static Builder|Attributeset query()
 * @method static Builder|BaseModel disableCache()
 * @method static Builder|BaseModel withCacheCooldownSeconds($seconds)
 * @property-read mixed                                                          $cache_cooldown_seconds
 * @property-read int|null                                                       $attributegroups_count
 * @property-read int|null                                                       $products_count
 */
class Attributeset extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    protected $touches = [
        'attributegroups',
    ];

    public function attributes()
    {
        $key = "Attributeset:" . $this->cacheKey();

        return Cache::remember($key, config("constants.CACHE_60"), function () {
            $result = DB::table('attributesets')
                ->join('attributegroups', function ($join) {
                    $join->on('attributesets.id', '=', 'attributegroups.attributeset_id')
                        ->whereNull('attributegroups.deleted_at');
                })
                ->join('attribute_attributegroup', function ($join) {
                    $join->on('attribute_attributegroup.attributegroup_id', '=', 'attributegroups.id');
                })
                ->join('attributes', function ($join) {
                    $join->on('attributes.id', '=', 'attribute_attributegroup.attribute_id')
                        ->whereNull('attributes.deleted_at');
                })
                ->select([
                    "attributes.*",
                    'attribute_attributegroup.attributegroup_id as pivot_attributegroup_id',
                    'attribute_attributegroup.order as pivot_order',
                    'attribute_attributegroup.description as pivot_description',
                ])
                ->where('attributesets.id', '=', $this->id)
                ->whereNull('attributesets.deleted_at')
                ->orderBy('pivot_order')
                ->get();

            $result = Attribute::hydrate($result->toArray());

            $result->transform(function ($item, $key) {

                $p = [
                    "attributegroup_id" => $item->pivot_attributegroup_id,
                    "order"             => $item->pivot_order,
                    "description"       => $item->pivot_description,
                ];
                $p = $item->newPivot($item, $p, 'attribute_attributegroup', true);

                $item->relations = [

                    "pivot" => $p,
                ];
                unset($item->pivot_attributegroup_id, $item->pivot_order, $item->pivot_description);

                return $item;
            });

            return $result;
        });
    }

    public function cacheKey()
    {
        $key  = $this->getKey();
        $time = isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;

        return sprintf("%s-%s", //$this->getTable(),
            $key, $time);
    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function attributegroups()
    {
        return $this->hasMany('App\Attributegroup')
            ->orderBy('order');
    }
}
