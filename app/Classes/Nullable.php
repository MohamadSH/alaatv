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
     * @param $cb
     * @return mixed
     */
    public function getValue($cb)
    {
        if (is_null($this->result)) {
            return $cb();
        } else {
            return $this->result;
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