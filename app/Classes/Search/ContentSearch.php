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
use App\Collection\ContentCollection;
use function foo\func;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;

class ContentSearch extends SearchAbstract
{
    protected $pageName = 'contentPage';
    protected $validFilters = [
      'name',
      'tags',
      'contentType'
    ];
    protected $model = "App\Content" ;

    public function __construct()
    {
        parent::__construct();
        $this->model = (new $this->model);
    }


    public function apply(array $filters ) :LengthAwarePaginator {
        $this->pageNum = $this->setPageNum($filters);
        $key = $this->makeCacheKey($filters);

        return Cache::tags(['content','search'])->remember($key,$this->cacheTime,function () use( $filters ) {
//            dump("in cache");
            $query = $this->applyDecoratorsFromFiltersArray($filters, $this->model->newQuery());
            return $this->getResults($query);
        });
    }

    protected function getResults(Builder $query)
    {
        $result = $query ->active()
                      ->orderBy("created_at" , "desc")
                      ->paginate($this->numberOfItemInEachPage,
                          ['*'],
                          $this->pageName,
                          $this->pageNum
                      );
        return $result;
    }



    /**
     * @param $decorator
     * @return mixed
     */
    protected function setupDecorator($decorator)
    {
        $decorator = (new $decorator);
        if ($decorator instanceof Tags)
            $decorator->setTagManager(new ContentTagManagerViaApi());
        return $decorator;
    }

    /**
     * @param array $filters
     * @return int|mixed
     */
    private function setPageNum(array $filters)
    {
        return isset($filters[$this->pageName]) ? $filters[$this->pageName] : self::DEFAULT_PAGE_NUMBER;

    }
}
