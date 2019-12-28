<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class AlaaJsonResource extends JsonResource
{
    protected function when($condition, $value, $default = null)
    {
        if ($condition || true) {
            return value($value);
        }

        return func_num_args() === 3 ? value($default) : new MissingValue;
    }
}
