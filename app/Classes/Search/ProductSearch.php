<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-17
 * Time: 18:41
 */

namespace App\Classes\Search;


use App\Classes\Search\{Filters\Tags, Tag\ProductTagManagerViaApi};
use Illuminate\Database\Eloquent\{Builder};
use Illuminate\Support\Facades\{Cache};

class ProductSearch extends SearchAbstract
{
    protected $model        = "App\Product";
    protected $pageName     = 'productPage';
    protected $numberOfItemInEachPage = 28;
    protected $validFilters = [
        'name',
        'tags',
    ];

    /**
     * @param array $filters
     *
     * @return mixed
     */
    public function apply(array $filters)
    {
        $this->pageNum = $this->setPageNum($filters);
        $key = $this->makeCacheKey($filters);
        return Cache::tags([
                               'product',
                               'search',
                           ])
                    ->remember($key, $this->cacheTime, function () use ($filters) {
                        $query = $this->applyDecoratorsFromFiltersArray($filters, $this->model->newQuery());
                        return $this->getResults($query);
                    });
    }

    /**
     * @param Builder $query
     *
     * @return mixed
     */
    protected function getResults(Builder $query)
    {
        $result = $query->active()
                        ->doesntHave('parents')
                        ->whereNull('deleted_at')
                        ->orderBy("created_at", "desc")
                        ->paginate($this->numberOfItemInEachPage,
                                   ['*'],
                                   $this->pageName,
                                   $this->pageNum
                        );
        return $result;
    }

    /**
     * @param $decorator
     *
     * @return mixed
     */
    protected function setupDecorator($decorator)
    {
        $decorator = (new $decorator);
        if ($decorator instanceof Tags)
            $decorator->setTagManager(new ProductTagManagerViaApi());
        return $decorator;
    }
}