<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-11
 * Time: 10:06
 */

namespace App\Classes\Search;


use App\Classes\Search\Filters\Filter;
use App\Classes\Search\Filters\Tag;
use App\Classes\Search\Tag\ContentTagManagerViaApi;
use Illuminate\Database\Eloquent\Builder;

class ContentSearch
{

    protected const MODEL = "App\Content" ;
    protected $dummyFilterCallBack;

    public function __construct()
    {
        $this->dummyFilterCallBack = new DummyFilterCallBack();
    }

    public function apply(array $filters){
        $query = $this->applyDecoratorsFromFiltersArray($filters, (new (self::MODEL))->newQuery());
        return $this->getResults($query);
    }

    private function applyDecoratorsFromFiltersArray(array $filters, Builder $query)
    {
        foreach ($filters as $filterName => $value) {
            $decorator = $this->createFilterDecorator($filterName);
            if ($this->isValidDecorator($decorator)) {
                $decorator = $this->setupDecorator($decorator);

                if($this->isFilterDecorator($decorator))
                    $query = $decorator->apply($query, $value ,$this->dummyFilterCallBack);
            }
        }
        return $query;
    }
    private function createFilterDecorator($name)
    {
        return __NAMESPACE__ . '\\Filters\\' . studly_case($name);
    }
    private function isValidDecorator($decorator)
    {
        return class_exists($decorator) ;
    }
    private function isFilterDecorator($decorator){
        return ( $decorator instanceof Filter);
    }
    public function getResults(Builder $query)
    {
        return $query->get();
    }

    /**
     * @param $decorator
     * @return mixed
     */
    private function setupDecorator($decorator)
    {
        $decorator = (new $decorator);
        if ($decorator instanceof Tag)
            $decorator->setTagManager(new ContentTagManagerViaApi());
        return $decorator;
    }
}
