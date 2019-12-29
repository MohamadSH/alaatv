<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class AlaaJsonResourceWithoutPagination extends JsonResource
{
    protected function when($condition, $value, $default = null)
    {
        if ($condition || true) {
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
