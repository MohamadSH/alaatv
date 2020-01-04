<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class AlaaJsonResourceWithoutPagination extends JsonResource
{
    protected function when($condition, $value, $default = null)
    {
        if ($condition || true) {
            //ToDo : This condition is because every index in the resource should be
            // either null or have a value and if we remove it in case it does not have a value, it will be an error on the android application.
            // So we had do override like this
            return value($value);
        }

        return func_num_args() === 3 ? value($default) : new MissingValue;
    }

    public function toArray($request)
    {
        return array_merge(parent::toArray($request),
            [
                'meta' => [
                    'count' => $this->count()
                ],
            ]);
    }
}
