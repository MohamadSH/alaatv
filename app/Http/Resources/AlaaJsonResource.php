<?php


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
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

    /**
     * Create new anonymous resource collection.
     *
     * @param mixed $resource
     *
     * @return AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        return tap(new AlaaAnonymousResourceCollection($resource, static::class), function ($collection) {
            if (property_exists(static::class, 'preserveKeys')) {
                $collection->preserveKeys = (new static([]))->preserveKeys === true;
            }
        });
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
