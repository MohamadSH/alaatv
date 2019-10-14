<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-11
 * Time: 10:06
 */

namespace App\Classes\Search;

use LogicException;
use App\Classes\Search\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

abstract class SearchAbstract
{
    protected const DEFAULT_PAGE_NUMBER = 1;
    
    protected $cacheKey;
    
    protected $cacheTime;
    
    protected $validFilters;
    
    protected $model;
    
    protected $dummyFilterCallBack;
    
    protected $pageName = 'page';
    
    protected $pageNum;
    
    protected $numberOfItemInEachPage = 10;
    
    public function __construct()
    {
        if (!isset($this->model)) {
            throw new LogicException(get_class($this).' must have a $model');
        }
        
        $this->dummyFilterCallBack = new DummyFilterCallBack();
        $this->cacheKey            = get_class($this).':';
        $this->cacheTime           = config('constants.CACHE_60');
        $this->pageNum             = self::DEFAULT_PAGE_NUMBER;
        $this->model               = (new $this->model);
    }
    
    public function get(array ...$params)
    {
//        dd($params[0]);
        return $this->apply($params[0]);
    }
    
    abstract protected function apply(array $filters);
    
    /**
     * @param  int  $numberOfItemInEachPage
     *
     * @return SearchAbstract
     */
    public function setNumberOfItemInEachPage(int $numberOfItemInEachPage): SearchAbstract
    {
        $this->numberOfItemInEachPage = $numberOfItemInEachPage;
        
        return $this;
    }
    
    /**
     * @param  string  $pageName
     *
     * @return SearchAbstract
     */
    public function setPageName(string $pageName): SearchAbstract
    {
        $this->pageName = $pageName;
        
        return $this;
    }
    
    protected function applyDecoratorsFromFiltersArray(array $filters, Builder $query)
    {
        foreach ($filters as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);
            if ($this->isValidFilter($filterName) && $this->isValidDecorator($decorator)) {
                $decorator = $this->setupDecorator($decorator);
                
                if ($this->isFilterDecorator($decorator)) {
                    $query = $decorator->apply($query, $value, $this->dummyFilterCallBack);
                }
            }
        }
        
        return $query;
    }
    
    protected function createFilterDecorator($name)
    {
        return __NAMESPACE__.'\\Filters\\'.studly_case($name);
    }
    
    protected function isValidFilter($filterName)
    {
        return in_array($filterName, $this->validFilters);
    }
    
    protected function isValidDecorator($decorator)
    {
        return class_exists($decorator);
    }
    
    abstract protected function setupDecorator($decorator);
    
    protected function isFilterDecorator($decorator)
    {
        return ($decorator instanceof Filter);
    }
    
    abstract protected function getResults(Builder $query);
    
    /**
     * @param  array  $array
     *
     * @return string
     */
    protected function makeCacheKey(array $array): string
    {
        $key = $this->cacheKey.$this->pageName.'-'.$this->pageNum.':'.md5(serialize($this->validFilters).serialize($array));
        
        return $key;
    }
    
    /**
     * @param  array  $filters
     *
     * @return int|mixed
     */
    protected function setPageNum(array $filters)
    {
        return isset($filters[$this->pageName]) ? $filters[$this->pageName] : SearchAbstract::DEFAULT_PAGE_NUMBER;
    }
    
    /**
     * @param  array  $params
     *
     * @return array
     */
    protected function getFromParams(array $params, $index): array
    {
        return (array) array_get(array_merge(...$params), $index);
    }
}
