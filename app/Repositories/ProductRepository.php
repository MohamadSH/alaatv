<?php


namespace App\Repositories;


use App\Product;
use Illuminate\Database\Eloquent\Builder;

class ProductRepository
{
    /**
     * @param array $setIds
     * @return Product|\Illuminate\Database\Eloquent\Builder
     */
    public static function getProductsByUserId(array $setIds):Builder{
        return Product::whereHas('sets', function ($q) use ($setIds) {
                            $q->whereIn('contentset_id', $setIds)
                                ->whereNotNull('grand_id');
                        });
    }

    /**
     * @param string $teacherName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getProductByTag(string $teacherName): Builder
    {
        return Product::where('tags', 'like', '%' . $teacherName . '%');
    }
}
