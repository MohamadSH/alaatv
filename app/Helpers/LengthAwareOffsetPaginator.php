<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Countable;
use ArrayAccess;
use ArrayIterator;
use JsonSerializable;
use IteratorAggregate;
use Illuminate\Pagination\LengthAwarePaginator;

class LengthAwareOffsetPaginator extends  LengthAwarePaginator implements
    Arrayable,
    ArrayAccess,
    Countable,
    IteratorAggregate,
    JsonSerializable,
    Jsonable
{
    protected $items;

    protected $total;

    protected $total_pages;

    protected $limit;

    protected $offset;

    protected $options;

    /**
     * LengthAwareOffsetPaginator constructor.
     *
     * @param Collection $items
     * @param $total
     * @param $limit
     * @param $offset
     * @param array $options
     */
    public function __construct(Collection $items, $total, $limit, $offset, array $options = [])
    {
        $this->items = $items;

        if ($items->count() > $limit) {
            $this->items = $items->take($limit);
        }

        $this->total = $total;

        $this->limit = $limit;
        $this->offset = $offset;
        $this->options = $options;

        $this->total_pages = ($total/$limit);
    }

    /**
     * Get url of an offset.
     *
     * @param int $offset
     *
     * @return string Url of an offset
     */
    public function url($pageNumber)
    {
        $query = isset($this->options['queryParameter']) ? $this->options['queryParameter'] : [];

        $offset = ($pageNumber - 1) * $this->limit;
        $query = array_merge($query, ['page' => ['limit' => $this->limit, 'offset' => $offset]]);
        $url = isset($this->options['path']) ? $this->options['path'] : '/';

        return $url.'?'.http_build_query($query);
    }

    /**
     * Get last page.
     *
     * @return int Last page
     */
    public function lastPage()
    {
        $totalPages = ceil($this->total / $this->limit);
        return $totalPages;
    }

    /**
     * Get last page offset.
     *
     * @return int Last page offset
     */
    public function totalPages()
    {
        return $this->total_pages;
    }

    /**
     * Get current page.
     *
     * @return int Last page offset
     */
    public function currentPage()
    {
        $pages = (int)ceil($this->offset / $this->limit);

        $currentPage = ($pages + 1);

        return $currentPage;
    }

    public function perPage()
    {
        return $this->limit;
    }

    /**
     * Get last page url.
     *
     * @return string
     */
    public function lastPageUrl()
    {
        $last = $this->lastPage();

        return $this->url($last);
    }

    /**
     * get next page url.
     *
     * @return string
     */
    public function nextPageUrl()
    {
        $nextOffset = $this->offset + $this->limit;

        return ($nextOffset >= $this->total)
            ? null
            : $this->url($nextOffset);
    }

    /**
     * get previous page url.
     *
     * @return string
     */
    public function previousPageUrl()
    {
        if ($this->offset == 0) {
            return null;
        }

        $prevOffset = $this->offset - $this->limit;

        return ($prevOffset < 0)
            ? $this->url($prevOffset + $this->limit - $this->offset)
            : $this->url($prevOffset);
    }

    public function items()
    {
        return $this->items;
    }

    /**
     * get total items.
     *
     * @return int
     */
    public function total()
    {
        return $this->total;
    }

    /**
     * Get the number of items for the current page.
     *
     * @return int
     */
    public function count()
    {
        // return $this->total;
        return $this->items->count();
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items->all());
    }

    /**
     * Determine if the given item exists.
     *
     * @param mixed $key
     *
     * @return bool
     */
    public function offsetExists($key)
    {
        return $this->items->has($key);
    }

    /**
     * Get the item at the given offset.
     *
     * @param mixed $key
     *
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->items->get($key);
    }

    /**
     * Set the item at the given offset.
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function offsetSet($key, $value)
    {
        $this->items->put($key, $value);
    }

    /**
     * Unset the item at the given key.
     *
     * @param mixed $key
     */
    public function offsetUnset($key)
    {
        $this->items->forget($key);
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'first' => $this->url(0),
            'last' => $this->lastPageUrl(),
            'next' => $this->nextPageUrl(),
            'prev' => $this->previousPageUrl(),
            'data' => $this->items->toArray(),
        ];
    }

    /**
     * Convert the object into something JSON serializable.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param int $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}