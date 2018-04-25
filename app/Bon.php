<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bon extends Model
{
    use SoftDeletes;
    /**      * The attributes that should be mutated to dates.        */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'displayName',
        'description',
        'order',
        'enable',
    ];
    public function cacheKey()
    {
        $key = $this->getKey();
        $time= isset($this->updated_at) ? $this->updated_at->timestamp : $this->created_at->timestamp;
        return sprintf(
            "%s-%s",
            //$this->getTable(),
            $key,
            $time
        );
    }

    public function products()
    {
        return $this->belongsToMany('\App\Product')->withPivot('discount', 'bonPlus');
    }

    public function users()
    {
        return $this->belongsToMany('\App\User')->withPivot('number');
    }

    public function userbons()
    {
        return $this->hasMany('\App\Userbon');
    }

    public function bontype()
    {
        return $this->belongsTo("\App\BonType");
    }
    public function scopeEnable($query)
    {
        return $query->where('isEnable', '=', 1);
    }
}
