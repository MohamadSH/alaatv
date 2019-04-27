<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-11
 * Time: 10:06
 */

namespace App\Classes\Search;

use App\Classes\Search\{Filters\Tags, Tag\ContentTagManagerViaApi};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ContentSearch extends SearchAbstract
{
    protected $model = "App\Content";
    
    protected $pageName = 'contentPage';

//    protected $numberOfItemInEachPage = 2;
    protected $validFilters = [
        'name',
        'set',
        'tags',
        'contentType',
        'createdAtSince',
        'createdAtTill',
    ];
    
    public function get(array ...$params)
    {
        $filters      = $this->getFromParams($params, "filters");
        $contentTypes = $this->getFromParams($params, "contentTypes");
        $items        = collect();
        foreach ($contentTypes as $contentType) {
            ${$contentType.'Result'} = $this->getFiltered($filters, ['contentType' => (array) $contentType]);
            $items->offsetSet($contentType, $this->normalizeResult(${$contentType.'Result'}));
        }
        
        return $items;
    }
    
    /**
     * @param  array  ...$filters
     *
     * @return LengthAwarePaginator|null
     */
    private function getFiltered(array ...$filters): ?LengthAwarePaginator
    {
        $filters     = array_merge(...$filters);
        $contentType = array_get($filters, "contentType");
        if (is_null($contentType)) {
            throw new \InvalidArgumentException("filters[contentType] should be set.");
        }
        
        return $this->setPageName($contentType[0].'Page')
            ->apply($filters);
    }
    
    private function normalizeResult(LengthAwarePaginator $resutl)
    {
        return $resutl->count() > 0 ? $resutl : null;
    }
    
    /**
     * @param  array  $filters
     *
     * @return mixed
     */
    protected function apply(array $filters): LengthAwarePaginator
    {
        $this->pageNum = $this->setPageNum($filters);
        $key           = $this->makeCacheKey($filters);
        
        return Cache::tags([
            'content',
            'search',
        ])
            ->remember($key, $this->cacheTime, function () use ($filters) {
                //            dump("in cache");
                $query = $this->applyDecoratorsFromFiltersArray($filters, $this->model->newQuery());
                
                return $this->getResults($query)
                    ->appends($filters);
            });
    }
    
    protected function getResults(Builder $query)
    {
        //ToDo: Active condition has conflict with admin
        $result = $query->active()
            ->orderBy("created_at", "desc")
            ->paginate($this->numberOfItemInEachPage, ['*'], $this->pageName, $this->pageNum);
        
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
        if ($decorator instanceof Tags) {
            $decorator->setTagManager(new ContentTagManagerViaApi());
        }
        
        return $decorator;
    }
}
