<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-11
 * Time: 10:06
 */

namespace App\Classes\Search;


use App\Classes\Search\Filters\Filter;
use App\Classes\Search\Filters\Tags;
use App\Classes\Search\Tag\ContentTagManagerViaApi;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Config;

abstract class SearchAbstract
{

    protected $cacheKey;
    protected $cacheTime;
    protected $validFilters ;
    protected $model;
    protected $dummyFilterCallBack;
    protected $pageName = 'page';
    protected $pageNum;
    public function __construct()
    {
        $this->dummyFilterCallBack = new DummyFilterCallBack();
        $this->cacheKey = get_class($this).':';
        $this->cacheTime = Config::get("constants.CACHE_5");
        $this->pageNum = 1;
    }

    abstract public function apply(array $filters);

    protected function applyDecoratorsFromFiltersArray(array $filters, Builder $query)
    {
        foreach ($filters as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);
            if ($this->isValidFilter($filterName) && $this->isValidDecorator($decorator)) {
                $decorator = $this->setupDecorator($decorator);

                if ($this->isFilterDecorator($decorator))
                    $query = $decorator->apply($query, $value, $this->dummyFilterCallBack);
            }
        }
        return $query;
    }

    protected function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name);
    }

    protected function isValidFilter($filterName)
    {
        return in_array($filterName, $this->validFilters);
    }

    protected function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }

    protected function isFilterDecorator($decorator)
    {
        return ($decorator instanceof Filter);
    }

    abstract protected function getResults(Builder $query);
    abstract protected function setupDecorator($decorator);

    /**
     * @param array $array
     * @return string
     */
    protected function makeCacheKey(array $array): string
    {
        $key = $this->cacheKey . $this->pageNum . ':'.md5(serialize($this->validFilters).serialize($array));
        return $key;
    }
}
