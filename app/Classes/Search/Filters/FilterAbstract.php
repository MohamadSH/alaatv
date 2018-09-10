<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-04
 * Time: 15:35
 */

namespace App\Classes\Search\Filters;


use Illuminate\Database\Eloquent\Builder;
use LogicException;

class FilterAbstract implements Filter
{
    protected $attribute ;


    public function __construct()
    {
        if(!isset($this->attribute))
            throw new LogicException(get_class($this) . ' must have a $attribute');
    }

    public function apply(Builder $builder, $value,  FilterCallback $callback ): Builder
    {
        return $builder->where($this->attribute, $value);
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    protected function getValueShouldBeSetMessage()
    {
        return trans("filter.value should be set", ["filter" => get_class($this)]);
    }

    /**
     * @return array|\Illuminate\Contracts\Translation\Translator|null|string
     */
    protected function getValueShouldBeArrayMessage()
    {
        return trans("filter.value should be array", ["filter" => get_class($this)]);
    }
}