<?php

namespace App;

use App\Traits\CharacterCommon;
use App\Traits\DateTrait;
use App\Traits\Helper;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes, CascadeSoftDeletes;
    use Helper;
    use DateTrait;
    use CharacterCommon;
    use Cachable;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function cacheKey()
    {
        $key = $this->getKey();
        $time = isset($this->updated_at) ? $this->updated_at->timestamp : $this->created_at->timestamp;

        return sprintf("%s:%s-%s", $this->getTable(), $key, $time);
    }
}
