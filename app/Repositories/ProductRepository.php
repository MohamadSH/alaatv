<?php


namespace App\Repositories;


use App\Product;

class ProductRepository
{
    /**
     * @param array $setIds
     * @return Product|\Illuminate\Database\Eloquent\Builder
     */
    public static function getProductsByUserId(array $setIds){
        return Product::whereHas('sets', function ($q) use ($setIds) {
                            $q->whereIn('contentset_id', $setIds)
                                ->whereNotNull('grand_id');
                        });
    }
}
