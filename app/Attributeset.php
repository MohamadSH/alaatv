<?php

namespace App;

use App\Helpers\Helper;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Attributeset extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];
    public function cacheKey()
    {
        $key = $this->getKey();
        $time= isset($this->update) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }
    public function attributes(){
        $key = "Attributeset:".$this->cacheKey();
        return Cache::remember($key,Config::get("constants.CACHE_60"),function () {
            $result = DB::table('attributesets')
                ->join('attributegroups', 'attributesets.id', '=', 'attributegroups.attributeset_id')
                ->join('attribute_attributegroup', 'attribute_attributegroup.attributegroup_id', '=', 'attributegroups.id')
                ->join('attributes', 'attributes.id', '=', 'attribute_attributegroup.attribute_id')
                ->select([
                    "attributes.*",
                    'attribute_attributegroup.attributegroup_id as pivot_attributegroup_id',
                    'attribute_attributegroup.order as pivot_order',
                    'attribute_attributegroup.description as pivot_description',
                    ])
                ->where('attributesets.id','=',$this->id)
                ->get();

            $result = Attribute::hydrate($result->toArray());

            $result->transform(function ($item, $key) {

                $p = [
                    "attributegroup_id" => $item->pivot_attributegroup_id,
                    "order" => $item->pivot_order,
                    "description" => $item->pivot_description,
                ];
                $p = $item->newPivot($item,$p,'attribute_attributegroup',true);

                $item->relations = [

                    "pivot" => $p
                ];
                unset(
                    $item->pivot_attributegroup_id,
                    $item->pivot_order,
                    $item->pivot_description
                );
                return $item;
            });
//            dd($result);
            return $result;

        });

    }

    public function products()
    {
        return $this->hasMany('App\Product');
    }

    public function attributegroups()
    {
        return $this->hasMany('App\Attributegroup')->orderBy('order');
    }

    /**
     * @return string
     * Converting Created_at field to jalali
     */
    public function CreatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->created_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->created_at, "toJalali");
    }

    /**
     * @return string
     * Converting Updated_at field to jalali
     */
    public function UpdatedAt_Jalali()
    {
        $helper = new Helper();
        $explodedDateTime = explode(" ", $this->updated_at);
//        $explodedTime = $explodedDateTime[1] ;
        return $helper->convertDate($this->updated_at, "toJalali");
    }
}
