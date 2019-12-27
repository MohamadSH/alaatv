<?php
/**
 * Created by PhpStorm.
 * User: sohrab
 * Date: 2018-09-04
 * Time: 15:35
 */

namespace App\Classes\Search\Filters;

use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Builder;
use LogicException;

class FilterAbstract implements Filter
{
    protected $attribute;

    protected $relation;

    public function __construct()
    {
        if (!isset($this->attribute)) {
            throw new LogicException(get_class($this) . ' must have a $attribute');
        }
    }

    public function apply(Builder $builder, $value, FilterCallback $callback): Builder
    {
        $value = $this->getSearchValue($value);

        return $builder->where($this->attribute, 'LIKE', "%" . $value . "%");
    }

    protected function getSearchValue($value)
    {
        return trim($value);
    }

    /**
     * @return array|Translator|null|string
     */
    protected function getValueShouldBeSetMessage()
    {
        return trans("filter.value should be set", ["filter" => get_class($this)]);
    }

    /**
     * @return array|Translator|null|string
     */
    protected function getValueShouldBeArrayMessage()
    {
        return trans("filter.value should be array", ["filter" => get_class($this)]);
    }
}
