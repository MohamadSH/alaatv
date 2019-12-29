<?php


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class AlaaJsonResource extends AlaaJsonResourceWithoutPagination
{
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
}
