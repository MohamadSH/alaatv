<?php

namespace App\Classes;

use Illuminate\Http\Exceptions\HttpResponseException;

class Nullable
{
    private $result;

    /**
     * Nullable constructor.
     *
     * @param $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @param $default
     * @return mixed
     */
    public function getValue($default)
    {
        if (! is_null($this->result)) {
            return $this->result;
        }

        if (is_null($cb)) {
            return optional();
        } elseif (is_callable($default)) {
            return $default();
        } else {
            return $default;
        }
    }

    /**
     * @param $response
     * @return mixed
     */
    public function orFailWith($response)
    {
        throw new HttpResponseException($response);
    }
}