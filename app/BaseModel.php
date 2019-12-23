<?php

namespace App;

use App\Traits\CharacterCommon;
use App\Traits\DateTrait;
use App\Traits\Helper;
use Iatstuti\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class BaseModel extends Model
{
    use SoftDeletes;
    use CascadeSoftDeletes;
    use Helper;
    use DateTrait;
    use CharacterCommon;

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
        $key  = $this->getKey();
        $time = (optional($this->updated_at)->timestamp ?: optional($this->created_at)->timestamp) ?: 0;

        return sprintf("%s:%s-%s", $this->getTable(), $key, $time);
    }
}
